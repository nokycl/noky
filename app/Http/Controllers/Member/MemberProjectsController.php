<?php

namespace App\Http\Controllers\Member;

use App\Helper\Reply;
use App\Http\Requests\Project\StoreProject;
use App\Project;
use App\ProjectActivity;
use App\ProjectCategory;
use App\ProjectFile;
use App\ProjectMember;
use App\ProjectTemplate;
use App\ProjectTimeLog;
use App\Task;
use App\Traits\ProjectProgress;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class MemberProjectsController
 * @package App\Http\Controllers\Member
 */
class MemberProjectsController extends MemberBaseController
{
    use ProjectProgress;

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.projects';
        $this->pageIcon = 'icon-layers';
        $this->middleware(function ($request, $next) {
            if(!in_array('projects',$this->user->modules)){
                abort(403);
            }
            return $next($request);
        });

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->clients = User::allClients();
        return view('member.projects.index', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $this->project = Project::findOrFail($id)->withCustomFields();

        if(!$this->project->isProjectAdmin && !$this->user->can('edit_projects')){
            abort(403);
        }

        $this->clients = User::allClients();
        $this->categories = ProjectCategory::all();
        $this->fields = $this->project->getCustomFieldGroupsWithFields()->fields;

        return view('member.projects.edit', $this->data);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $this->userDetail = auth()->user();

        $this->project = Project::findOrFail($id)->withCustomFields();
        $this->fields = $this->project->getCustomFieldGroupsWithFields()->fields;

        $isMember = ProjectMember::checkIsMember($id, $this->user->id);

        // Check authorised user

        if($this->project->isProjectAdmin || $this->user->can('view_projects') || $isMember)
        {
            $this->activeTimers = ProjectTimeLog::projectActiveTimers($this->project->id);

            $this->openTasks = Task::projectOpenTasks($this->project->id, $this->userDetail->id);
            $this->openTasksPercent = (count($this->openTasks) == 0 ? '0' : (count($this->openTasks) / count($this->project->tasks)) * 100);

            // TODO::ProjectDeadline to do
            $this->daysLeft = 0;
            $this->daysLeftFromStartDate = 0;
            $this->daysLeftPercent = 0;

            if($this->project->deadline){
                $this->daysLeft = $this->project->deadline->diff(Carbon::now())->format('%d')+($this->project->deadline->diff(Carbon::now())->format('%m')*30)+($this->project->deadline->diff(Carbon::now())->format('%y')*12);
                $this->daysLeftFromStartDate = $this->project->deadline->diff($this->project->start_date)->format('%d')+($this->project->deadline->diff($this->project->start_date)->format('%m')*30)+($this->project->deadline->diff($this->project->start_date)->format('%y')*12);
                $this->daysLeftPercent = ($this->daysLeftFromStartDate == 0 ? "0" : (($this->daysLeft / $this->daysLeftFromStartDate) * 100));
            }

            $this->hoursLogged = ProjectTimeLog::projectTotalMinuts($this->project->id);
            $minute = 0;
            $hour = intdiv($this->hoursLogged, 60);

            if (($this->hoursLogged % 60) > 0) {
                $minute = ($this->hoursLogged % 60);
                $this->hoursLogged = $hour . 'hrs ' . $minute . ' mins';
            } else {
                $this->hoursLogged = $hour;
            }

            $this->recentFiles = ProjectFile::where('project_id', $this->project->id)->orderBy('id','desc')->limit(10)->get();
            $this->activities = ProjectActivity::getProjectActivities($id, 10, $this->userDetail->id);

            return view('member.projects.show', $this->data);
        }
        else{
            // If not authorised user
            abort(403);
        }


    }

    public function data(Request $request)
    {
        $this->userDetail = auth()->user();
        $projects = Project::select('projects.id', 'projects.project_name', 'projects.project_admin', 'projects.project_summary', 'projects.start_date', 'projects.deadline', 'projects.notes', 'projects.category_id', 'projects.client_id', 'projects.feedback', 'projects.completion_percent', 'projects.created_at', 'projects.updated_at');

        if(!$this->user->can('view_projects')){
            $projects = $projects->join('project_members', 'project_members.project_id', '=', 'projects.id');
            $projects = $projects->where('project_members.user_id', '=', $this->userDetail->id);
        }

        if(!is_null($request->status) && $request->status != 'all') {
            if($request->status == 'incomplete') {
                $projects->where('completion_percent', '<','100');
            } elseif ($request->status == 'complete') {
                $projects->where('completion_percent','=', '100');
            }
        }


        if(!is_null($request->client_id) && $request->client_id != 'all') {
            $projects->where('client_id', $request->client_id);
        }

        $projects->get();

        return DataTables::of($projects)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $action = '';

                if($row->project_admin == $this->userDetail->id || $this->user->can('edit_projects')){
                    $action.= '<a href="' . route('member.projects.edit', [$row->id]) . '" class="btn btn-info btn-circle"
                      data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> ';
                }
                $action.= '<a href="'.route('member.projects.show', [$row->id]).'" class="btn btn-success btn-circle"
                      data-toggle="tooltip" data-original-title="View Project Details"><i class="fa fa-search" aria-hidden="true"></i></a>';

                if($this->user->can('delete_projects')){
                    $action.= ' <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                      data-toggle="tooltip" data-user-id="' . $row->id . '" data-original-title="Delete"><i class="fa fa-times" aria-hidden="true"></i></a>';
                }

                return $action;
            })
            ->addColumn('members', function ($row) {
                $members = '';

                if (count($row->members) > 0) {
                    foreach ($row->members as $member) {
                        $members .= ($member->user->image) ? '<img data-toggle="tooltip" data-original-title="' . ucwords($member->user->name) . '" src="' . asset('user-uploads/avatar/' . $member->user->image) . '"
                        alt="user" class="img-circle" width="30"> ' : '<img data-toggle="tooltip" data-original-title="' . ucwords($member->user->name) . '" src="' . asset('default-profile-2.png') . '"
                        alt="user" class="img-circle" width="30"> ';
                    }
                }
                else{
                    $members.= __('messages.noMemberAddedToProject');
                }

                if($this->user->can('add_projects')){
                    $members.= '<br><br><a class="font-12" href="'.route('member.project-members.show', $row->id).'"><i class="fa fa-plus"></i> '.__('modules.projects.addMemberTitle').'</a>';
                }
                return $members;
            })

            ->editColumn('project_name', function($row){
                return '<a href="'.route('member.projects.show', $row->id).'">'.ucfirst($row->project_name).'</a>';
            })
            ->editColumn('start_date', function($row){
                return $row->start_date->format($this->global->date_format);
            })
            ->editColumn('deadline', function($row){
                if($row->deadline){
                    return $row->deadline->format($this->global->date_format);
                }

                return '-';
            })
            ->editColumn('client_id', function($row){
                if(!is_null($row->client_id)){
                    return ucwords($row->client->name);
                }
                else{
                    return '--';
                }
            })
            ->editColumn('completion_percent', function ($row) {
                if ($row->completion_percent < 50) {
                    $statusColor = 'danger';
                    $status = __('app.progress');
                }
                elseif ($row->completion_percent >= 50 && $row->completion_percent < 75) {
                    $statusColor = 'warning';
                    $status = __('app.progress');
                }
                else {
                    $statusColor = 'success';
                    $status = __('app.progress');

                    if($row->completion_percent >= 100){
                        $status = __('app.completed');
                    }
                }

                return '<h5>'.$status.'<span class="pull-right">' . $row->completion_percent . '%</span></h5><div class="progress">
                  <div class="progress-bar progress-bar-' . $statusColor . '" aria-valuenow="' . $row->completion_percent . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $row->completion_percent . '%" role="progressbar"> <span class="sr-only">' . $row->completion_percent . '% Complete</span> </div>
                </div>';
            })
            ->rawColumns(['project_name', 'action', 'members', 'completion_percent'])
            ->removeColumn('project_summary')
            ->removeColumn('notes')
            ->removeColumn('category_id')
            ->removeColumn('feedback')
            ->removeColumn('start_date')
            ->make(true);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProject $request, $id) {
        $project = Project::findOrFail($id);
        $project->project_name = $request->project_name;
        if ($request->project_summary != '') {
            $project->project_summary = $request->project_summary;
        }
        $project->start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        if(!$request->has('without_deadline')){
            $project->deadline = Carbon::parse($request->deadline)->format('Y-m-d');
        }else{
            $project->deadline = null;
        }
        if ($request->notes != '') {
            $project->notes = $request->notes;
        }
        if ($request->category_id != '') {
            $project->category_id = $request->category_id;
        }
        $project->client_id = ($request->client_id == 'null' || $request->client_id == '') ? null : $request->client_id  ;
        $project->feedback = $request->feedback;

        if($request->calculate_task_progress){
            $project->calculate_task_progress = $request->calculate_task_progress;
            $project->completion_percent = $this->calculateProjectProgress($id);
        }
        else{
            $project->calculate_task_progress = "false";
            $project->completion_percent = $request->completion_percent;
        }

        if($request->client_view_task){
            $project->client_view_task = 'enable';
        }
        else{
            $project->client_view_task = "disable";
        }
        if(($request->client_view_task) && ($request->client_task_notification)){
            $project->allow_client_notification = 'enable';
        }
        else{
            $project->allow_client_notification = "disable";
        }

        if($request->manual_timelog){
            $project->manual_timelog = 'enable';
        }
        else{
            $project->manual_timelog = "disable";
        }

        $project->save();

        $this->logProjectActivity($project->id, ucwords($project->project_name) . __('modules.projects.projectUpdated'));
        return Reply::redirect(route('member.projects.edit', $id), __('messages.projectUpdated'));
    }

    public function create() {
        if(!$this->user->can('add_projects')){
            abort(403);
        }

        $this->clients = User::allClients();
        $this->categories = ProjectCategory::all();
        $this->templates = ProjectTemplate::all();

        $project = new Project();
        $this->fields = $project->getCustomFieldGroupsWithFields()->fields;
        return view('member.projects.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProject $request) {
        $project = new Project();
        $project->project_name = $request->project_name;
        if ($request->project_summary != '') {
            $project->project_summary = $request->project_summary;
        }
        $project->start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        if(!$request->has('without_deadline')){
            $project->deadline = Carbon::parse($request->deadline)->format('Y-m-d');
        }

        if ($request->notes != '') {
            $project->notes = $request->notes;
        }
        if ($request->category_id != '') {
            $project->category_id = $request->category_id;
        }
        $project->client_id = $request->client_id;

        if($request->client_view_task){
            $project->client_view_task = 'enable';
        }
        else{
            $project->client_view_task = "disable";
        }
        if(($request->client_view_task) && ($request->client_task_notification)){
            $project->allow_client_notification = 'enable';
        }
        else{
            $project->allow_client_notification = "disable";
        }

        if($request->manual_timelog){
            $project->manual_timelog = 'enable';
        }
        else{
            $project->manual_timelog = "disable";
        }

        $project->save();

        if($request->template_id){
            $template = ProjectTemplate::findOrFail($request->template_id);
            foreach($template->members as $member){
                $projectMember = new ProjectMember();

                $projectMember->user_id    = $member->user_id;
                $projectMember->project_id = $project->id;
                $projectMember->save();
            }
            foreach($template->tasks as $task){
                $projectTask = new Task();

                $projectTask->user_id     = $task->user_id;
                $projectTask->project_id  = $project->id;
                $projectTask->heading     = $task->heading;
                $projectTask->description = $task->description;
                $projectTask->due_date    = Carbon::now()->addDay()->format('Y-m-d');
                $projectTask->status      = 'incomplete';
                $projectTask->save();
            }
        }

        // To add custom fields data
        if ($request->get('custom_fields_data')) {
            $project->updateCustomFieldData($request->get('custom_fields_data'));
        }

        $this->logSearchEntry($project->id, 'Project: '.$project->project_name, 'admin.projects.show');

        $this->logProjectActivity($project->id, ucwords($project->project_name) . ' '. __("messages.addedAsNewProject"));
        return Reply::redirect(route('member.projects.index'), __('modules.projects.projectUpdated'));
    }

    public function destroy($id) {
        Project::destroy($id);
        return Reply::success(__('messages.projectDeleted'));
    }

}
