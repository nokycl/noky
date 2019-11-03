<?php

namespace App\Http\Controllers\Member;

use App\Helper\Reply;
use App\Http\Requests\TaskBoard\StoreTaskBoard;
use App\Project;
use App\Task;
use App\TaskboardColumn;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MemberTaskboardController extends MemberBaseController
{
    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'modules.tasks.taskBoard';
        $this->pageIcon = 'ti-layout-column3';
        $this->middleware(function ($request, $next) {
            if(!in_array('tasks',$this->user->modules)){
                abort(403);
            }
            return $next($request);
        });

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date = Carbon::now();
        $startDate = $date->subDays(30)->format('Y-m-d');
        $endDate = Carbon::now()->format('Y-m-d');
        $boardColumns = TaskboardColumn::with(['tasks' => function($q) use ($startDate, $endDate, $request){
            $q = $q->with(['subtasks', 'completedSubtasks', 'comments', 'user'])
                ->leftJoin('projects', 'projects.id', '=', 'tasks.project_id')
                ->leftJoin('users as client', 'client.id', '=', 'projects.client_id')
                ->join('users', 'users.id', '=', 'tasks.user_id')
                ->join('taskboard_columns', 'taskboard_columns.id', '=', 'tasks.board_column_id')
                ->leftJoin('users as creator_user', 'creator_user.id', '=', 'tasks.created_by')
                ->select('tasks.*');
            if($request->startDate !== null && $request->startDate != 'null' && $request->startDate != ''){
                $q = $q->where(DB::raw('DATE(tasks.`due_date`)'), '>=', $request->startDate);
            }else{
                $q = $q->where(DB::raw('DATE(tasks.`due_date`)'), '>=', $startDate);
            }

            if($request->endDate !== null && $request->endDate != 'null' && $request->endDate != ''){
                $q = $q->where(DB::raw('DATE(tasks.`due_date`)'), '<=', $request->endDate);
            }else{
                $q = $q->where(DB::raw('DATE(tasks.`due_date`)'), '<=', $endDate);
            }
            if($request->projectID != 0 && $request->projectID !=  null && $request->projectID !=  'all'){
                $q = $q->where('tasks.project_id', '=', $request->projectID);
            }

            if($request->clientID != '' && $request->clientID !=  null && $request->clientID !=  'all'){
                $q = $q->where('projects.client_id', '=', $request->clientID);
            }

            if($request->assignedTo != '' && $request->assignedTo !=  null && $request->assignedTo !=  'all'){
                $q = $q->where('tasks.user_id', '=', $request->assignedTo);
            }

            if($request->assignedBY != '' && $request->assignedBY !=  null && $request->assignedBY !=  'all'){
                $q = $q->where('creator_user.id', '=', $request->assignedBY);
            }

            if(!$this->user->can('view_tasks')){
                $q = $q->where('tasks.user_id', '=', $this->user->id);
            }


        }])->orderBy('priority', 'asc')->get();

        $this->boardColumns = $boardColumns;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->projects = ($this->user->can('view_projects')) ? Project::all() : Project::select('projects.*')->join('project_members', 'project_members.project_id', '=', 'projects.id')
            ->where('project_members.user_id', $this->user->id)
            ->get();
        $this->employees = ($this->user->can('view_employees')) ? User::allEmployees() : User::where('id', $this->user->id)->get();
        $this->clients = User::allClients();

        if($request->ajax()){
            $view = view('member.taskboard.board_data', $this->data)->render();
            return Reply::dataOnly(['view' => $view]);
        }
        return view('member.taskboard.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('member.taskboard.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskBoard $request)
    {
        $maxPriority = TaskboardColumn::max('priority');

        $board = new TaskboardColumn();
        $board->column_name = $request->column_name;
        $board->label_color = $request->label_color;
        $board->priority = ($maxPriority+1);
        $board->save();

        return Reply::redirect(route('member.taskboard.index'), __('messages.boardColumnSaved'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->boardColumn = TaskboardColumn::findOrFail($id);
        $this->maxPriority = TaskboardColumn::max('priority');
        $view =  view('member.taskboard.edit', $this->data)->render();
        return Reply::dataOnly(['status' => 'success', 'view' => $view]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTaskBoard $request, $id)
    {
        $board = TaskboardColumn::findOrFail($id);
        $oldPosition = $board->priority;
        $newPosition = $request->priority;

        if($oldPosition < $newPosition){

            $otherColumns = TaskboardColumn::where('priority', '>', $oldPosition)
                ->where('priority', '<=', $newPosition)
                ->orderBy('priority', 'asc')
                ->get();

            foreach($otherColumns as $column){
                $pos = TaskboardColumn::where('priority', $column->priority)->first();
                $pos->priority = ($pos->priority-1);
                $pos->save();
            }
        }
        else if($oldPosition > $newPosition){

        $otherColumns = TaskboardColumn::where('priority', '<', $oldPosition)
            ->where('priority', '>=', $newPosition)
            ->orderBy('priority', 'asc')
            ->get();

        foreach($otherColumns as $column){
            $pos = TaskboardColumn::where('priority', $column->priority)->first();
            $pos->priority = ($pos->priority+1);
            $pos->save();
        }
    }

        $board->column_name = $request->column_name;
        $board->label_color = $request->label_color;
        $board->priority = $request->priority;
        $board->save();

        return Reply::redirect(route('member.taskboard.index'), __('messages.boardColumnSaved'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::where('board_column_id', $id)->update(['board_column_id' => 1]);

        $board = TaskboardColumn::findOrFail($id);

        $otherColumns = TaskboardColumn::where('priority', '>', $board->priority)
            ->orderBy('priority', 'asc')
            ->get();

        foreach($otherColumns as $column){
            $pos = TaskboardColumn::where('priority', $column->priority)->first();
            $pos->priority = ($pos->priority-1);
            $pos->save();
        }

        TaskboardColumn::destroy($id);

        return Reply::dataOnly(['status' => 'success']);
    }

    public function updateIndex(Request $request){
        $taskIds = $request->taskIds;
        $boardColumnIds = $request->boardColumnIds;
        $priorities = $request->prioritys;

        if(!empty($taskIds)){
            foreach($taskIds as $key=>$taskId){
                if(!is_null($taskId)){
                    $task = Task::findOrFail($taskId);
                    $task->board_column_id = $boardColumnIds[$key];
                    $task->column_priority = $priorities[$key];
                    $task->save();
                }
            }
        }
        return Reply::dataOnly(['status' => 'success']);
    }
}
