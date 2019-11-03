<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Reply;
use App\LogTimeFor;
use App\Project;
use App\ProjectMember;
use App\ProjectTimeLog;
use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ManageAllTimeLogController extends AdminBaseController
{
    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'Time Logs';
        $this->pageIcon = 'icon-clock';
        $this->middleware(function ($request, $next) {
            if(!in_array('timelogs',$this->user->modules)){
                abort(403);
            }
            return $next($request);
        });

    }

    public function index(){
        $this->employees = User::allEmployees();
        $this->projects = Project::all();
        $this->timeLogProjects = $this->projects;
        $this->tasks = Task::all();
        $this->timeLogTasks = $this->tasks;

        $this->logTimeFor = LogTimeFor::first();

        $this->activeTimers = ProjectTimeLog::with('user')
            ->whereNull('end_time')
            ->join('users', 'users.id', '=', 'project_time_logs.user_id');

        if($this->logTimeFor != null && $this->logTimeFor->log_time_for == 'task'){
            $this->activeTimers = $this->activeTimers->join('tasks', 'tasks.id', '=', 'project_time_logs.task_id');
            $projectName = 'tasks.heading as project_name';
        }
        else{
            $this->activeTimers = $this->activeTimers->join('projects', 'projects.id', '=', 'project_time_logs.project_id');
            $projectName = 'projects.project_name';
        }

        $this->activeTimers = $this->activeTimers
            ->select('project_time_logs.*' ,$projectName, 'users.name' )
            ->get();

        return view('admin.time-logs.index', $this->data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showActiveTimer()
    {
        $this->logTimeFor = LogTimeFor::first();
        $this->activeTimers = ProjectTimeLog::with('user')
            ->whereNull('end_time')
            ->join('users', 'users.id', '=', 'project_time_logs.user_id');

        if($this->logTimeFor != null && $this->logTimeFor->log_time_for == 'task'){
            $this->activeTimers = $this->activeTimers->join('tasks', 'tasks.id', '=', 'project_time_logs.task_id');
            $projectName = 'tasks.heading as project_name';
        }
        else{
            $this->activeTimers = $this->activeTimers->join('projects', 'projects.id', '=', 'project_time_logs.project_id');
            $projectName = 'projects.project_name';
        }

        $this->activeTimers = $this->activeTimers
            ->select('project_time_logs.*' ,$projectName, 'users.name' )
            ->get();

        return view('admin.time-logs.show-active-timer', $this->data);
    }

    public function data($startDate = null, $endDate = null, $projectId = null, $employee = null) {

        $projectName = 'projects.project_name';
        $timeLogs = ProjectTimeLog::join('users', 'users.id', '=', 'project_time_logs.user_id')
            ->join('employee_details', 'users.id', '=', 'employee_details.user_id');

        $this->logTimeFor = LogTimeFor::first();

        if($this->logTimeFor != null && $this->logTimeFor->log_time_for == 'task'){
            $timeLogs = $timeLogs->join('tasks', 'tasks.id', '=', 'project_time_logs.task_id');
            $projectName = 'tasks.heading as project_name';
        }else{
            $timeLogs = $timeLogs->join('projects', 'projects.id', '=', 'project_time_logs.project_id');
        }

        $timeLogs = $timeLogs->select('project_time_logs.id', $projectName, 'project_time_logs.start_time', 'project_time_logs.end_time', 'project_time_logs.total_hours', 'project_time_logs.total_minutes', 'project_time_logs.memo', 'project_time_logs.user_id', 'project_time_logs.project_id', 'project_time_logs.task_id', 'users.name', 'employee_details.hourly_rate');


        if(!is_null($startDate)){
            $timeLogs->where(DB::raw('DATE(project_time_logs.`start_time`)'), '>=', $startDate);
        }

        if(!is_null($endDate)){
            $timeLogs->where(DB::raw('DATE(project_time_logs.`end_time`)'), '<=', $endDate);
        }

        if(!is_null($employee) && $employee !== 'all'){
            $timeLogs->where('project_time_logs.user_id', $employee);
        }

        if(!is_null($projectId) && $projectId !== 'all'){
            if($this->logTimeFor != null && $this->logTimeFor->log_time_for == 'task'){
                $timeLogs->where('project_time_logs.task_id', '=', $projectId);
            }else{
                $timeLogs->where('project_time_logs.project_id', '=', $projectId);
            }
        }

        $timeLogs = $timeLogs->get();

        return DataTables::of($timeLogs)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                return '<a href="javascript:;" class="btn btn-info btn-circle edit-time-log"
                      data-toggle="tooltip" data-time-id="'.$row->id.'"  data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                        data-toggle="tooltip" data-time-id="'.$row->id.'" data-original-title="Delete"><i class="fa fa-times" aria-hidden="true"></i></a>';
            })
            ->editColumn('name', function($row){
                return '<a href="'.route('admin.employees.show', $row->user_id).'" target="_blank" >'.ucwords($row->name).'</a>';
            })
            ->editColumn('start_time', function($row){
                return $row->start_time->timezone($this->global->timezone)->format($this->global->date_format.' '.$this->global->time_format);
            })
            ->editColumn('end_time', function($row){
                if(!is_null($row->end_time)){
                    return $row->end_time->timezone($this->global->timezone)->format($this->global->date_format.' '.$this->global->time_format);
                }
                else{
                    return "<label class='label label-success'>".__('app.active')."</label>";
                }
            })
            ->editColumn('total_hours', function($row){
                $timeLog = intdiv($row->total_minutes, 60).' hrs ';

                if(($row->total_minutes % 60) > 0){
                    $timeLog.= ($row->total_minutes % 60).' mins';
                }

                return $timeLog;
            })
            ->addColumn('earnings', function($row){
                if (is_null($row->hourly_rate)) {
                    return '--';
                }
                $hours = intdiv($row->total_minutes, 60);

                $earning = round($hours*$row->hourly_rate);
                
                return $this->global->currency->currency_symbol.$earning. ' ('.$this->global->currency->currency_code.')';
            })
            ->editColumn('project_name', function ($row) {

                if($this->logTimeFor != null && $this->logTimeFor->log_time_for == 'task'){
                    return ucfirst($row->project_name);
                }else{
                    return '<a href="' . route('admin.projects.show', $row->project_id) . '">' . ucfirst($row->project_name) . '</a>';
                }

            })
            ->rawColumns(['end_time', 'action', 'project_name', 'name'])
            ->removeColumn('project_id')
            ->removeColumn('total_minutes')
            ->removeColumn('task_id')
            ->make(true);
    }

    public function destroy($id) {
        ProjectTimeLog::destroy($id);
        return Reply::success(__('messages.timeLogDeleted'));
    }

    /**
     * @param Request $request
     * @return array
     */
    public function stopTimer(Request $request){
        $timeId = $request->timeId;
        $timeLog = ProjectTimeLog::findOrFail($timeId);
        $timeLog->end_time = Carbon::now();
        $timeLog->edited_by_user = $this->user->id;
        $timeLog->save();

        $timeLog->total_hours = ($timeLog->end_time->diff($timeLog->start_time)->format('%d')*24)+($timeLog->end_time->diff($timeLog->start_time)->format('%H'));

        if($timeLog->total_hours == 0){
            $timeLog->total_hours = round(($timeLog->end_time->diff($timeLog->start_time)->format('%i')/60),2);
        }
        $timeLog->total_minutes = ($timeLog->total_hours*60)+($timeLog->end_time->diff($timeLog->start_time)->format('%i'));

        $timeLog->save();

        $this->activeTimers = ProjectTimeLog::whereNull('end_time')
            ->get();
        $view = view('admin.projects.time-logs.active-timers', $this->data)->render();
        return Reply::successWithData(__('messages.timerStoppedSuccessfully'), ['html' => $view, 'activeTimers' => count($this->activeTimers)]);
    }
    /**
     * @param $projectId
     * @return mixed
     * @throws \Throwable
     */
    public function membersList($projectId){

        $this->members = ProjectMember::byProject($projectId);

        $list = view('admin.tasks.members-list', $this->data)->render();
        return Reply::dataOnly(['html' => $list]);
    }

    /**
     * @param $startDate
     * @param $endDate
     * @param $id
     */
    public function export($startDate, $endDate, $id, $employee = null) {

        $projectName = 'projects.project_name'; // Set default name for select in mysql
        $timeLogs = ProjectTimeLog::join('users', 'users.id', '=', 'project_time_logs.user_id');

        $this->logTimeFor = LogTimeFor::first();

        // Check for apply join Task Or Project
        if($this->logTimeFor != null && $this->logTimeFor->log_time_for == 'task'){
            $timeLogs = $timeLogs->join('tasks', 'tasks.id', '=', 'project_time_logs.task_id');
            $projectName = 'tasks.heading as project_name';
        }else{
            $timeLogs = $timeLogs->join('projects', 'projects.id', '=', 'project_time_logs.project_id');
        }

        // Fields selecting  For excel
        $timeLogs = $timeLogs->select('project_time_logs.id', 'users.name', $projectName, 'project_time_logs.start_time', 'project_time_logs.end_time', 'project_time_logs.memo', 'project_time_logs.total_minutes');

        // Condition according start_date
        if(!is_null($startDate)){
            $timeLogs->where(DB::raw('DATE(project_time_logs.`start_time`)'), '>=', "$startDate");
        }

        // Condition according start_date
        if(!is_null($endDate)){
            $timeLogs->where(DB::raw('DATE(project_time_logs.`end_time`)'), '<=', "$endDate");
        }

        // Condition according employee
        if(!is_null($employee) && $employee !== 'all'){
            $timeLogs->where('project_time_logs.user_id', $employee);
        }

        // Condition according select id
        if(!is_null($id) && $id !== 'all'){
            if($this->logTimeFor != null && $this->logTimeFor->log_time_for == 'task'){
                $timeLogs->where('project_time_logs.task_id', '=', $id);
            }else{
                $timeLogs->where('project_time_logs.project_id', '=', $id);
            }
        }
        $attributes =  ['total_minutes','duration','timer'];
        $timeLogs = $timeLogs->get()->makeHidden($attributes);

        // Initialize the array which will be passed into the Excel
        // generator.
        $exportArray = [];

        // Define the Excel spreadsheet headers
        $exportArray[] = ['ID', 'User','Log For','Start Time','End Time', 'Memo', 'Total Hours'];

        // Convert each member of the returned collection into an array,
        // and append it to the payments array.
        foreach ($timeLogs as $row) {
            $exportArray[] = $row->toArray();
        }

        // Generate and return the spreadsheet
        Excel::create('timelog', function($excel) use ($exportArray) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Time Log');
            $excel->setCreator('Worksuite')->setCompany($this->companyName);
            $excel->setDescription('time log file');

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
