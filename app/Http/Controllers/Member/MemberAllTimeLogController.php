<?php

namespace App\Http\Controllers\Member;

use App\Helper\Reply;
use App\Http\Requests\TimeLogs\StoreTimeLog;
use App\LogTimeFor;
use App\Project;
use App\ProjectMember;
use App\ProjectTimeLog;
use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class MemberAllTimeLogController extends MemberBaseController
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

        $this->logTimeFor = LogTimeFor::first();
    }

    public function index(){
        if($this->user->can('view_timelogs')){
            $this->projects = Project::all();
            $this->tasks = Task::all();
            $this->timeLogProjects = $this->projects;
            $this->timeLogTasks = $this->tasks;
        }
        else{

            $this->projects = Project::join('project_members', 'project_members.project_id', '=', 'projects.id')
                ->select('projects.*')
                ->where('project_members.user_id', '=', $this->user->id)
                ->get();

            $this->tasks = Task::where('user_id', '=', $this->user->id)
                ->get();

            $this->timeLogProjects = Project::join('project_members', 'project_members.project_id', '=', 'projects.id')
                ->select('projects.*')
                ->where('project_members.user_id', '=', $this->user->id)
                ->where('projects.manual_timelog', 'enable')
                ->get();

            $this->timeLogTasks = Task::where('user_id', '=', $this->user->id)
                ->get();
        }

        $this->employees = User::allEmployees();

        return view('member.time-log.index', $this->data);
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

        return view('member.time-log.show-active-timer', $this->data);
    }


    public function data($startDate = null, $endDate = null, $projectId = null, $employee = null) {

        $logTimeFor = $this->logTimeFor;
        $projectName = 'projects.project_name';
        $timeLogs = ProjectTimeLog::join('users', 'users.id', '=', 'project_time_logs.user_id');

        if($logTimeFor != null && $logTimeFor->log_time_for == 'task'){
            $timeLogs = $timeLogs->join('tasks', 'tasks.id', '=', 'project_time_logs.task_id');
            $projectName = 'tasks.heading as project_name';
        }else{
            $timeLogs = $timeLogs->join('projects', 'projects.id', '=', 'project_time_logs.project_id');

        }
        if(!$this->user->can('view_timelogs')){
            $timeLogs->where('project_time_logs.user_id', $this->user->id);
        }

        $timeLogs->select('project_time_logs.id', $projectName, 'project_time_logs.start_time', 'project_time_logs.end_time', 'project_time_logs.total_hours', 'project_time_logs.total_minutes', 'project_time_logs.memo', 'project_time_logs.project_id', 'project_time_logs.task_id', 'users.name');

        if(!is_null($startDate)){
            $timeLogs->where(DB::raw('DATE(project_time_logs.`start_time`)'), '>=', $startDate);
        }

        if(!is_null($endDate)){
            $timeLogs->where(DB::raw('DATE(project_time_logs.`end_time`)'), '<=', $endDate);
        }

        if(!is_null($employee) && $employee !== 'all'){
            $timeLogs->where('project_time_logs.user_id', $employee);
        }

        if($projectId != 0){
            if($logTimeFor != null && $logTimeFor->log_time_for == 'task'){
                $timeLogs->where('project_time_logs.task_id', '=', $projectId);
            }else{
                $timeLogs->where('project_time_logs.project_id', '=', $projectId);
            }
        }

        $timeLogs->get();

        return DataTables::of($timeLogs)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                if($this->user->can('delete_timelogs')){
                    return '<a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                      data-toggle="tooltip" data-time-id="'.$row->id.'" data-original-title="Delete"><i class="fa fa-times" aria-hidden="true"></i></a>';
                }
            })
            ->editColumn('start_time', function($row) {
                return $row->start_time->timezone($this->global->timezone)->format($this->global->date_format.' '.$this->global->time_format);
            })
            ->editColumn('name', function($row){
                return ucwords($row->name);
            })
            ->editColumn('end_time', function($row){
                if(!is_null($row->end_time)){
                    return $row->end_time->timezone($this->global->timezone)->format($this->global->date_format.' '.$this->global->time_format);
                }
                else{
                    return "<label class='label label-success'>".__('app.active')."</label>";
                }
            })
            ->editColumn('project_name', function ($row) use($logTimeFor) {
                if($logTimeFor != null && $logTimeFor->log_time_for == 'task') {
                    return '<a href="javascript:;">' . ucfirst($row->project_name) . '</a>';
                }else{
                    return '<a href="' . route('member.projects.show', $row->project_id) . '">' . ucfirst($row->project_name) . '</a>';
                }
            })
            ->editColumn('total_hours', function($row){
                $timeLog = intdiv($row->total_minutes, 60).' hrs ';

                if(($row->total_minutes % 60) > 0){
                    $timeLog.= ($row->total_minutes % 60).' mins';
                }

                return $timeLog;
            })
            ->rawColumns(['end_time', 'action', 'project_name'])
            ->removeColumn('project_id')
            ->removeColumn('task_id')
            ->removeColumn('total_minutes')
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
        $view = view('member.time-log.active-timers', $this->data)->render();
        $buttonHtml = '';
        if($timeLog->user_id == $this->user->id){
            $buttonHtml = '<div class="nav navbar-top-links navbar-right pull-right m-t-10">
                        <a class="btn btn-rounded btn-default timer-modal" href="javascript:;">'.__("modules.timeLogs.startTimer").' <i class="fa fa-check-circle text-success"></i></a>
                    </div>';
        }
        return Reply::successWithData(__('messages.timerStoppedSuccessfully'), ['html' => $view, 'buttonHtml' => $buttonHtml, 'activeTimers' => count($this->activeTimers)]);
    }


    public function store(StoreTimeLog $request) {
        $timeLog = new ProjectTimeLog();

        if($this->logTimeFor != null && $this->logTimeFor->log_time_for == 'task'){
            $timeLog->task_id = $request->task_id;
            $task = Task::findOrFail($request->task_id);
            $timeLog->user_id = $task->user_id;

        }else{
            $timeLog->project_id = $request->project_id;
            $timeLog->user_id = $request->user_id;
        }

        $timeLog->start_time = Carbon::parse($request->start_date)->format('Y-m-d').' '.Carbon::parse($request->start_time)->format('H:i:s');
        $timeLog->start_time = Carbon::createFromFormat('Y-m-d H:i:s', $timeLog->start_time, $this->global->timezone)->setTimezone('UTC');
        $timeLog->end_time = Carbon::parse($request->end_date)->format('Y-m-d').' '.Carbon::parse($request->end_time)->format('H:i:s');
        $timeLog->end_time = Carbon::createFromFormat('Y-m-d H:i:s', $timeLog->end_time, $this->global->timezone)->setTimezone('UTC');
        $timeLog->total_hours = $timeLog->end_time->diff($timeLog->start_time)->format('%d')*24+$timeLog->end_time->diff($timeLog->start_time)->format('%H');
        $timeLog->total_minutes = ($timeLog->total_hours*60)+($timeLog->end_time->diff($timeLog->start_time)->format('%i'));

        $timeLog->memo = $request->memo;
        $timeLog->edited_by_user = $this->user->id;
        $timeLog->save();

        return Reply::success(__('messages.timeLogAdded'));
    }

    public function edit($id) {
        $this->timeLog = ProjectTimeLog::findOrFail($id);
        $this->project = Project::findOrFail($this->timeLog->project_id);
        return view('member.time-log.edit', $this->data);
    }


    public function update(StoreTimeLog $request, $id) {
        $timeLog = ProjectTimeLog::findOrFail($id);

        if($timeLog->task_id != null){
            $task = Task::findOrFail($timeLog->task_id);
            $timeLog->user_id = $task->user_id;
            $usrID = $task->user_id;

        }else{

            $timeLog->user_id = $request->user_id;
            $usrID = $request->user_id;
        }
        $timeLog->start_time = Carbon::parse($request->start_date)->format('Y-m-d').' '.Carbon::parse($request->start_time)->format('H:i:s');
        $timeLog->start_time = Carbon::createFromFormat('Y-m-d H:i:s', $timeLog->start_time, $this->global->timezone)->setTimezone('UTC');
        $timeLog->end_time = Carbon::parse($request->end_date)->format('Y-m-d').' '.Carbon::parse($request->end_time)->format('H:i:s');
        $timeLog->end_time = Carbon::createFromFormat('Y-m-d H:i:s', $timeLog->end_time, $this->global->timezone)->setTimezone('UTC');
        $timeLog->total_hours = $timeLog->end_time->diff($timeLog->start_time)->format('%d')*24+$timeLog->end_time->diff($timeLog->start_time)->format('%H');

        if($timeLog->total_hours == 0){
            $timeLog->total_hours = round(($timeLog->end_time->diff($timeLog->start_time)->format('%i')/60),2);
        }

        $timeLog->memo = $request->memo;
        $timeLog->edited_by_user = $this->user->id;
        $timeLog->save();

        return Reply::successWithData(__('messages.timeLogUpdated'), ['userID' => $usrID]);
    }

    public function membersList($projectId){
        if($this->user->can('add_timelogs')){
            $this->members = ProjectMember::byProject($projectId);
        }
        else{
            $this->members = ProjectMember::where('project_id', $projectId)
                ->where('user_id', $this->user->id)
                ->get();
        }
        $list = view('member.all-tasks.members-list', $this->data)->render();
        return Reply::dataOnly(['html' => $list]);
    }


}
