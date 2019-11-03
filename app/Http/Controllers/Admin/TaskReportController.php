<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Reply;
use App\Project;
use App\Task;
use App\TaskboardColumn;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class TaskReportController extends AdminBaseController
{
    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.taskReport';
        $this->pageIcon = 'ti-pie-chart';
    }

    public function index() {
        $this->projects = Project::all();
        $this->fromDate = Carbon::today()->subDays(30);
        $this->toDate = Carbon::today();
        $this->employees = User::allEmployees();

        $taskBoardColumn = TaskboardColumn::all();

        $incompletedTaskColumn = $taskBoardColumn->filter(function ($value, $key) {
            return $value->slug == 'incomplete';
        })->first();

        $completedTaskColumn = $taskBoardColumn->filter(function ($value, $key) {
            return $value->slug == 'completed';
        })->first();

        $this->totalTasks = Task::where(DB::raw('DATE(`due_date`)'), '>=', $this->fromDate->format('Y-m-d'))
            ->where(DB::raw('DATE(`due_date`)'), '<=', $this->toDate->format('Y-m-d'))
            ->count();

        $this->completedTasks = Task::where(DB::raw('DATE(`due_date`)'), '>=', $this->fromDate->format('Y-m-d'))
            ->where(DB::raw('DATE(`due_date`)'), '<=', $this->toDate->format('Y-m-d'))
            ->where('tasks.board_column_id', $completedTaskColumn->id)
            ->count();

        $this->pendingTasks = Task::where(DB::raw('DATE(`due_date`)'), '>=', $this->fromDate->format('Y-m-d'))
            ->where(DB::raw('DATE(`due_date`)'), '<=', $this->toDate->format('Y-m-d'))
            ->where('tasks.board_column_id', $incompletedTaskColumn->id)
            ->count();

        return view('admin.reports.tasks.index', $this->data);
    }

    public function store(Request $request){

        $totalTasks = Task::where(DB::raw('DATE(`due_date`)'), '>=', $request->startDate)
            ->where(DB::raw('DATE(`due_date`)'), '<=', $request->endDate);

        if(!is_null($request->projectId)){
            $totalTasks->where('project_id', $request->projectId);
        }

        if(!is_null($request->employeeId)){
            $totalTasks->where('user_id', $request->employeeId);
        }

        $totalTasks = $totalTasks->count();

        $completedTasks = Task::where(DB::raw('DATE(`due_date`)'), '>=', $request->startDate)
            ->where(DB::raw('DATE(`due_date`)'), '<=', $request->endDate);

        if(!is_null($request->projectId)){
            $completedTasks->where('project_id', $request->projectId);
        }

        if(!is_null($request->employeeId)){
            $completedTasks->where('user_id', $request->employeeId);
        }
        $taskBoardColumn = TaskboardColumn::where('slug', 'completed')->first();
        $completedTasks = $completedTasks->where('tasks.board_column_id', $taskBoardColumn->id)->count();

        $pendingTasks = Task::where(DB::raw('DATE(`due_date`)'), '>=', $request->startDate)
            ->where(DB::raw('DATE(`due_date`)'), '<=', $request->endDate);

        if(!is_null($request->projectId)){
            $pendingTasks->where('project_id', $request->projectId);
        }

        if(!is_null($request->employeeId)){
            $pendingTasks->where('user_id', $request->employeeId);
        }
        $taskBoardColumn = TaskboardColumn::where('slug', 'incomplete')->first();
        $pendingTasks = $pendingTasks->where('tasks.board_column_id', $taskBoardColumn->id)->count();

        return Reply::successWithData(__('messages.reportGenerated'),
            ['pendingTasks' => $pendingTasks, 'completedTasks' => $completedTasks, 'totalTasks' => $totalTasks]
        );
    }

    public function data($startDate = null, $endDate = null, $employeeId = null, $projectId = null) {
        $tasks = Task::leftJoin('projects', 'projects.id', '=', 'tasks.project_id')
            ->join('users', 'users.id', '=', 'tasks.user_id')
            ->join('taskboard_columns', 'taskboard_columns.id', '=', 'tasks.board_column_id')
            ->select('tasks.id', 'projects.project_name', 'tasks.heading', 'users.name', 'users.image', 'tasks.due_date', 'tasks.project_id', 'taskboard_columns.column_name', 'taskboard_columns.label_color');

        if(!is_null($startDate)){
            $tasks->where(DB::raw('DATE(tasks.`due_date`)'), '>=', $startDate);
        }

        if(!is_null($endDate)){
            $tasks->where(DB::raw('DATE(tasks.`due_date`)'), '<=', $endDate);
        }

        if($projectId != 0){
            $tasks->where('tasks.project_id', '=', $projectId);
        }

        if($employeeId != 0){
            $tasks->where('tasks.user_id', $employeeId);
        }

        $tasks->get();

        return DataTables::of($tasks)
            ->editColumn('due_date', function($row){
                if($row->due_date->isPast()) {
                    return '<span class="text-danger">'.$row->due_date->format($this->global->date_format).'</span>';
                }
                return '<span class="text-success">'.$row->due_date->format($this->global->date_format).'</span>';
            })
            ->editColumn('name', function($row){
                return ($row->image) ? '<img src="'.asset('user-uploads/avatar/'.$row->image).'"
                                                            alt="user" class="img-circle" width="30"> '.ucwords($row->name) : '<img src="'.asset('default-profile-2.png').'"
                                                            alt="user" class="img-circle" width="30"> '.ucwords($row->name);
            })
            ->editColumn('heading', function($row){
                return ucfirst($row->heading);
            })

            ->editColumn('column_name', function($row){
                return '<label class="label" style="background-color: '.$row->label_color.'">'.$row->column_name.'</label>';
            })

            ->editColumn('project_name', function ($row) {
                if(is_null($row->project_id)){
                    return "";
                }
                return '<a href="' . route('admin.projects.show', $row->project_id) . '">' . ucfirst($row->project_name) . '</a>';
            })
            ->rawColumns(['column_name', 'project_name', 'due_date', 'name'])
            ->removeColumn('project_id')
            ->removeColumn('image')
            ->removeColumn('label_color')
            ->make(true);
    }

    public function export($startDate = null, $endDate = null, $employeeId = null, $projectId = null) {

        $tasks = Task::leftJoin('projects', 'projects.id', '=', 'tasks.project_id')
            ->join('users', 'users.id', '=', 'tasks.user_id')
            ->join('taskboard_columns', 'taskboard_columns.id', '=', 'tasks.board_column_id')
            ->select('tasks.id', 'projects.project_name', 'tasks.heading', 'users.name', 'tasks.due_date', 'taskboard_columns.column_name');

        if(!is_null($startDate) && $startDate != 0){
            $tasks->where(DB::raw('DATE(tasks.`due_date`)'), '>=', $startDate);
        }

        if(!is_null($endDate)  && $endDate != 0){
            $tasks->where(DB::raw('DATE(tasks.`due_date`)'), '<=', $endDate);
        }

        if(!is_null($projectId)  &&  $projectId != 0){
            $tasks->where('tasks.project_id', '=', $projectId);
        }

        if(!is_null($employeeId)  &&  $employeeId != 0){
            $tasks->where('tasks.user_id', $employeeId);
        }

        $tasks->get();


        $attributes =  ['due_date', 'create_on'];

        $tasks = $tasks->get()->makeHidden($attributes);

        // Initialize the array which will be passed into the Excel
        // generator.
        $exportArray = [];

        // Define the Excel spreadsheet headers
        $exportArray[] = ['ID', 'Project','Title','Assigned To','Status','Due Date'];

        // Convert each member of the returned collection into an array,
        // and append it to the payments array.
        foreach ($tasks as $row) {
            $exportArray[] = $row->toArray();
        }

        // Generate and return the spreadsheet
        Excel::create('Task Report', function($excel) use ($exportArray) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Task Report');
            $excel->setCreator('Worksuite')->setCompany($this->companyName);
            $excel->setDescription('Task Report file');

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('sheet1', function($sheet) use ($exportArray) {
                $sheet->fromArray($exportArray, null, 'A1', false, false);

                $sheet->row(1, function($row) {

                    // call row manipulation methods
                    $row->setFont(array(
                        'bold'       =>  true
                    ));

                });

            });

        })->download('xlsx');
    }

}
