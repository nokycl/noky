<?php

namespace App\Http\Controllers\Admin;

use App\Currency;
use App\Expense;
use App\Helper\Reply;
use App\Http\Requests\Project\StoreProject;
use App\Payment;
use App\ProjectActivity;
use App\ProjectCategory;
use App\ProjectFile;
use App\ProjectMember;
use App\ProjectTemplate;
use App\ProjectTimeLog;
use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Project;
use App\ProjectMilestone;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\ProjectProgress;

class ManageProjectsController extends AdminBaseController
{

    use ProjectProgress;

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.projects';
        $this->pageIcon = 'icon-layers';
        $this->middleware(function ($request, $next) {
            if (!in_array('projects', $this->user->modules)) {
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
    public function index()
    {
        $this->totalProjects = Project::all()->count();
        $this->completedProjects = Project::completed()->count();
        $this->inProcessProjects = Project::inProcess()->count();
        $this->overdueProjects = Project::overdue()->count();
        $this->clients = User::allClients();
        return view('admin.projects.index', $this->data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function archive()
    {
        $this->totalProjects = Project::onlyTrashed()->count();
        $this->clients = User::allClients();
        return view('admin.projects.archive', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->clients = User::allClients();
        $this->categories = ProjectCategory::all();
        $this->templates = ProjectTemplate::all();
        $this->currencies = Currency::all();

        $project = new Project();
        $this->fields = $project->getCustomFieldGroupsWithFields()->fields;
        return view('admin.projects.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProject $request)
    {
        $memberExistsInTemplate = false;

        $project = new Project();
        $project->project_name = $request->project_name;
        if ($request->project_summary != '') {
            $project->project_summary = $request->project_summary;
        }
        $project->start_date = Carbon::parse($request->start_date)->format('Y-m-d');

        if (!$request->has('without_deadline')) {
            $project->deadline = Carbon::parse($request->deadline)->format('Y-m-d');
        }

        if ($request->notes != '') {
            $project->notes = $request->notes;
        }
        if ($request->category_id != '') {
            $project->category_id = $request->category_id;
        }
        $project->client_id = $request->client_id;

        if ($request->client_view_task) {
            $project->client_view_task = 'enable';
        } else {
            $project->client_view_task = "disable";
        }
        if (($request->client_view_task) && ($request->client_task_notification)) {
            $project->allow_client_notification = 'enable';
        } else {
            $project->allow_client_notification = "disable";
        }

        if ($request->manual_timelog) {
            $project->manual_timelog = 'enable';
        } else {
            $project->manual_timelog = "disable";
        }

        $project->project_budget = $request->project_budget;
        $project->currency_id = $request->currency_id;
        $project->hours_allocated = $request->hours_allocated;

        $project->save();

        if ($request->template_id) {
            $template = ProjectTemplate::findOrFail($request->template_id);
            foreach ($template->members as $member) {
                $projectMember = new ProjectMember();

                $projectMember->user_id    = $member->user_id;
                $projectMember->project_id = $project->id;
                $projectMember->save();

                if($member->user_id == $this->user->id)
                {
                    $memberExistsInTemplate = true;
                }
            }
            foreach ($template->tasks as $task) {
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

        // Assign Self as project member
        if($request->has('default_project_member') && $request->default_project_member == 'true' && !$memberExistsInTemplate)
        {
            $member = new ProjectMember();
            $member->user_id = $this->user->id;
            $member->project_id = $project->id;
            $member->save();

            $this->logProjectActivity($project->id, ucwords($this->user->name).' '.__('messages.isAddedAsProjectMember'));
        }

        $this->logSearchEntry($project->id, 'Project: ' . $project->project_name, 'admin.projects.show');

        $this->logProjectActivity($project->id, ucwords($project->project_name) . ' ' . __("messages.addedAsNewProject"));
        return Reply::redirect(route('admin.projects.index'), __('modules.projects.projectUpdated'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->project = Project::findOrFail($id)->withCustomFields();
        $this->fields = $this->project->getCustomFieldGroupsWithFields()->fields;

        $this->activeTimers = ProjectTimeLog::projectActiveTimers($this->project->id);
        $this->openTasks = Task::projectOpenTasks($this->project->id);
        $this->openTasksPercent = (count($this->openTasks) == 0 ? "0" : (count($this->openTasks) / count($this->project->tasks)) * 100);
        $this->daysLeft = 0;
        $this->daysLeftFromStartDate = 0;
        $this->daysLeftPercent = 0;

        if (is_null($this->project->deadline)) {
            $this->daysLeft = 0;
        } else {
            if ($this->project->deadline->isPast()) {
                $this->daysLeft = 0;
            } else {
                $this->daysLeft = $this->project->deadline->diff(Carbon::now())->format('%d') + ($this->project->deadline->diff(Carbon::now())->format('%m') * 30) + ($this->project->deadline->diff(Carbon::now())->format('%y') * 12);
            }
            
            $this->daysLeftFromStartDate = $this->project->deadline->diff($this->project->start_date)->format('%d') + ($this->project->deadline->diff($this->project->start_date)->format('%m') * 30) + ($this->project->deadline->diff($this->project->start_date)->format('%y') * 12);

            $this->daysLeftPercent = ($this->daysLeftFromStartDate == 0 ? "0" : (($this->daysLeft / $this->daysLeftFromStartDate) * 100));
        }

        
        $this->hoursLogged = ProjectTimeLog::projectTotalMinuts($this->project->id);

        $hour = intdiv($this->hoursLogged, 60);
        $minute = 0;
        if (($this->hoursLogged % 60) > 0) {
            $minute = ($this->hoursLogged % 60);
            $this->hoursLogged = $hour . 'hrs ' . $minute . ' mins';
        } else {
            $this->hoursLogged = $hour;
        }

        $this->recentFiles = ProjectFile::where('project_id', $this->project->id)->orderBy('id', 'desc')->limit(10)->get();
        $this->activities = ProjectActivity::getProjectActivities($id, 10);
        //        $this->completedTasks = Task::projectCompletedTasks($this->project->id);
        $this->earnings = Payment::where('status', 'complete')
            ->where('project_id', $id)
            ->sum('amount');
        $this->expenses = Expense::where(['project_id' => $id, 'status' => 'approved'])->sum('price');
        $this->milestones = ProjectMilestone::with('currency')->where('project_id', $id)->get();

        return view('admin.projects.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->clients = User::allClients();
        $this->categories = ProjectCategory::all();
        $this->project = Project::findOrFail($id)->withCustomFields();
        $this->fields = $this->project->getCustomFieldGroupsWithFields()->fields;
        $this->currencies = Currency::all();
        return view('admin.projects.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProject $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->project_name = $request->project_name;
        if ($request->project_summary != '') {
            $project->project_summary = $request->project_summary;
        }
        $project->start_date = Carbon::parse($request->start_date)->format('Y-m-d');

        if (!$request->has('without_deadline')) {
            $project->deadline = Carbon::parse($request->deadline)->format('Y-m-d');
        }

        if ($request->notes != '') {
            $project->notes = $request->notes;
        }
        if ($request->category_id != '') {
            $project->category_id = $request->category_id;
        }

        if ($request->client_view_task) {
            $project->client_view_task = 'enable';
        } else {
            $project->client_view_task = "disable";
        }
        if (($request->client_view_task) && ($request->client_task_notification)) {
            $project->allow_client_notification = 'enable';
        } else {
            $project->allow_client_notification = "disable";
        }

        if ($request->manual_timelog) {
            $project->manual_timelog = 'enable';
        } else {
            $project->manual_timelog = "disable";
        }

        $project->client_id = ($request->client_id == 'null' || $request->client_id == '') ? null : $request->client_id;
        $project->feedback = $request->feedback;

        if ($request->calculate_task_progress) {
            $project->calculate_task_progress = $request->calculate_task_progress;
            $project->completion_percent = $this->calculateProjectProgress($id);
        } else {
            $project->calculate_task_progress = "false";
            $project->completion_percent = $request->completion_percent;
        }


        $project->project_budget = $request->project_budget;
        $project->currency_id = $request->currency_id;
        $project->hours_allocated = $request->hours_allocated;

        $project->save();

        // To add custom fields data
        if ($request->get('custom_fields_data')) {
            $project->updateCustomFieldData($request->get('custom_fields_data'));
        }

        $this->logProjectActivity($project->id, ucwords($project->project_name) . __('modules.projects.projectUpdated'));
        return Reply::redirect(route('admin.projects.index'), __('messages.projectUpdated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $project = Project::withTrashed()->findOrFail($id);
        $project->forceDelete();

        return Reply::success(__('messages.projectDeleted'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function archiveDestroy($id)
    {

        Project::destroy($id);

        return Reply::success(__('messages.projectArchiveSuccessfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function archiveRestore($id)
    {

        $project = Project::withTrashed()->findOrFail($id);
        $project->restore();

        return Reply::success(__('messages.projectRevertSuccessfully'));
    }

    public function data(Request $request)
    {

        $projects = Project::select('id', 'project_name', 'start_date', 'deadline', 'client_id', 'completion_percent', 'paused');

        if (!is_null($request->status) && $request->status != 'all') {
            if ($request->status == 'incomplete') {
                $projects->where('completion_percent', '<', '100');
            } elseif ($request->status == 'complete') {
                $projects->where('completion_percent', '=', '100');
            }
        }

        if (!is_null($request->client_id) && $request->client_id != 'all') {
            $projects->where('client_id', $request->client_id);
        }

        $projects->get();

        return DataTables::of($projects)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<a href="' . route('admin.projects.edit', [$row->id]) . '" class="btn btn-info btn-circle"
                      data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                      <a href="' . route('admin.projects.show', [$row->id]) . '" class="btn btn-success btn-circle"
                      data-toggle="tooltip" data-original-title="View Project Details"><i class="fa fa-search" aria-hidden="true"></i></a>

                      <a href="javascript:;" class="btn btn-warning  btn-circle archive"
                      data-toggle="tooltip" data-user-id="' . $row->id . '" data-original-title=" Archive"><i class="fa fa-archive" aria-hidden="true"></i></a>
                      
                        <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                      data-toggle="tooltip" data-user-id="' . $row->id . '" data-original-title="Delete"><i class="fa fa-times" aria-hidden="true"></i></a>';
            })
            ->addColumn('members', function ($row) {
                $members = '';

                if (count($row->members) > 0) {
                    foreach ($row->members as $member) {
                        $members .= ($member->user->image) ? '<img data-toggle="tooltip" data-original-title="' . ucwords($member->user->name) . '" src="' . asset('user-uploads/avatar/' . $member->user->image) . '"
                        alt="user" class="img-circle" width="30"> ' : '<img data-toggle="tooltip" data-original-title="' . ucwords($member->user->name) . '" src="' . asset('default-profile-2.png') . '"
                        alt="user" class="img-circle" width="30"> ';
                    }
                } else {
                    $members .= __('messages.noMemberAddedToProject');
                }
                $members .= '<br><br><a class="font-12" href="' . route('admin.project-members.show', $row->id) . '"><i class="fa fa-plus"></i> ' . __('modules.projects.addMemberTitle') . '</a>';
                return $members;
            })
            ->editColumn('project_name', function ($row) {
                $name = '<a href="' . route('admin.projects.show', $row->id) . '">' . ucfirst($row->project_name) . '</a>';

                if ($row->paused) {
                    $name .= '<br><label class="label label-warning">' . __('modules.projects.pause') . '</label>';
                }
                return $name;
            })
            ->editColumn('start_date', function ($row) {
                return $row->start_date->format($this->global->date_format);
            })
            ->editColumn('deadline', function ($row) {
                if ($row->deadline) {
                    return $row->deadline->format($this->global->date_format);
                }

                return '-';
            })
            ->editColumn('client_id', function ($row) {
                if (is_null($row->client_id)) {
                    return "--";
                }
                return ucwords($row->client->name);
            })
            ->editColumn('completion_percent', function ($row) {
                if ($row->completion_percent < 50) {
                    $statusColor = 'danger';
                    $status = __('app.progress');
                } elseif ($row->completion_percent >= 50 && $row->completion_percent < 75) {
                    $statusColor = 'warning';
                    $status = __('app.progress');
                } else {
                    $statusColor = 'success';
                    $status = __('app.progress');

                    if ($row->completion_percent >= 100) {
                        $status = __('app.completed');
                    }
                }

                return '<h5>' . $status . '<span class="pull-right">' . $row->completion_percent . '%</span></h5><div class="progress">
                  <div class="progress-bar progress-bar-' . $statusColor . '" aria-valuenow="' . $row->completion_percent . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $row->completion_percent . '%" role="progressbar"> <span class="sr-only">' . $row->completion_percent . '% Complete</span> </div>
                </div>';
            })
            ->rawColumns(['project_name', 'action', 'completion_percent', 'members'])
            ->removeColumn('project_summary')
            ->removeColumn('notes')
            ->removeColumn('category_id')
            ->removeColumn('feedback')
            ->removeColumn('start_date')
            ->make(true);
    }

    public function archiveData(Request $request)
    {
        $projects = Project::select('id', 'project_name', 'start_date', 'deadline', 'client_id', 'completion_percent');

        if (!is_null($request->status) && $request->status != 'all') {
            if ($request->status == 'incomplete') {
                $projects->where('completion_percent', '<', '100');
            } elseif ($request->status == 'complete') {
                $projects->where('completion_percent', '=', '100');
            }
        }

        if (!is_null($request->client_id) && $request->client_id != 'all') {
            $projects->where('client_id', $request->client_id);
        }

        $projects->onlyTrashed()->get();

        return DataTables::of($projects)
            ->addColumn('action', function ($row) {
                return '
                      <a href="javascript:;" class="btn btn-info btn-circle revert"
                      data-toggle="tooltip" data-user-id="' . $row->id . '" data-original-title="Restore"><i class="fa fa-undo" aria-hidden="true"></i></a>
                       <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                      data-toggle="tooltip" data-user-id="' . $row->id . '" data-original-title="Delete"><i class="fa fa-times" aria-hidden="true"></i></a>';
            })
            ->addColumn('members', function ($row) {
                $members = '';

                if (count($row->members) > 0) {
                    foreach ($row->members as $member) {
                        $members .= ($member->user->image) ? '<img data-toggle="tooltip" data-original-title="' . ucwords($member->user->name) . '" src="' . asset('user-uploads/avatar/' . $member->user->image) . '"
                        alt="user" class="img-circle" width="30"> ' : '<img data-toggle="tooltip" data-original-title="' . ucwords($member->user->name) . '" src="' . asset('default-profile-2.png') . '"
                        alt="user" class="img-circle" width="30"> ';
                    }
                } else {
                    $members .= __('messages.noMemberAddedToProject');
                }
                return $members;
            })
            ->editColumn('project_name', function ($row) {
                return ucfirst($row->project_name);
            })
            ->editColumn('start_date', function ($row) {
                return $row->start_date->format('d M, Y');
            })
            ->editColumn('deadline', function ($row) {
                if ($row->deadline) {
                    return $row->deadline->format($this->global->date_format);
                }

                return '-';
            })
            ->editColumn('client_id', function ($row) {
                if (is_null($row->client_id)) {
                    return "";
                }
                return ucwords($row->client->name);
            })
            ->editColumn('completion_percent', function ($row) {
                if ($row->completion_percent < 50) {
                    $statusColor = 'danger';
                    $status = __('app.progress');
                } elseif ($row->completion_percent >= 50 && $row->completion_percent < 75) {
                    $statusColor = 'warning';
                    $status = __('app.progress');
                } else {
                    $statusColor = 'success';
                    $status = __('app.progress');

                    if ($row->completion_percent >= 100) {
                        $status = __('app.completed');
                    }
                }

                return '<h5>' . $status . '<span class="pull-right">' . $row->completion_percent . '%</span></h5><div class="progress">
                  <div class="progress-bar progress-bar-' . $statusColor . '" aria-valuenow="' . $row->completion_percent . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $row->completion_percent . '%" role="progressbar"> <span class="sr-only">' . $row->completion_percent . '% Complete</span> </div>
                </div>';
            })
            ->removeColumn('project_summary')
            ->removeColumn('notes')
            ->removeColumn('category_id')
            ->removeColumn('feedback')
            ->removeColumn('start_date')
            ->rawColumns(['project_name', 'action', 'completion_percent', 'members'])
            ->make(true);
    }

    public function export($status = null, $clientID = null)
    {
        $projects = Project::leftJoin('users', 'users.id', '=', 'projects.client_id')
            ->leftJoin('project_category', 'project_category.id', '=', 'projects.category_id')
            ->select(
                'projects.id',
                'projects.project_name',
                'users.name',
                'project_category.category_name',
                'projects.start_date',
                'projects.deadline',
                'projects.completion_percent',
                'projects.created_at'
            );
        if (!is_null($status) && $status != 'all') {
            if ($status == 'incomplete') {
                $projects = $projects->where('completion_percent', '<', '100');
            } elseif ($status == 'complete') {
                $projects = $projects->where('completion_percent', '=', '100');
            }
        }

        if (!is_null($clientID) && $clientID != 'all') {
            $projects = $projects->where('client_id', $clientID);
        }

        $projects = $projects->get();

        // Initialize the array which will be passed into the Excel
        // generator.
        $exportArray = [];

        // Define the Excel spreadsheet headers
        $exportArray[] = ['ID', 'Project Name', 'Client Name', 'Category', 'Start Date', 'Deadline', 'Completion Percent', 'Created at'];

        // Convert each member of the returned collection into an array,
        // and append it to the payments array.
        foreach ($projects as $row) {
            $exportArray[] = $row->toArray();
        }

        // Generate and return the spreadsheet
        Excel::create('Projects', function ($excel) use ($exportArray) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Projects');
            $excel->setCreator('Worksuite')->setCompany($this->companyName);
            $excel->setDescription('Projects file');

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('sheet1', function ($sheet) use ($exportArray) {
                $sheet->fromArray($exportArray, null, 'A1', false, false);

                $sheet->row(1, function ($row) {

                    // call row manipulation methods
                    $row->setFont(array(
                        'bold'       =>  true
                    ));
                });
            });
        })->download('xlsx');
    }

    public function gantt()
    {

        $data = array();
        $links = array();

        $projects = Project::select('id', 'project_name', 'start_date', 'deadline')->get();

        $id = 0; //count for gantt ids
        foreach ($projects as $project) {
            $id = $id + 1;
            $projectId = $id;
            // TODO::ProjectDeadline to do
            $projectDuration = 0;
            if ($project->deadline) {
                $projectDuration = $project->deadline->diffInDays($project->start_date);
            }

            $data[] = [
                'id' => $projectId,
                'text' => ucwords($project->project_name),
                'start_date' => $project->start_date->format('Y-m-d H:i:s'),
                'duration' => $projectDuration
            ];

            $tasks = Task::projectOpenTasks($project->id);

            foreach ($tasks as $key => $task) {
                $id = $id + 1;

                $taskDuration = $task->due_date->diffInDays($project->created_at);
                $data[] = [
                    'id' => $id,
                    'text' => ucfirst($task->heading),
                    'start_date' => $task->created_at->format('Y-m-d H:i:s'),
                    'duration' => $taskDuration,
                    'parent' => $projectId,
                    'users' => [
                        ucwords($task->user->name)
                    ]
                ];

                $links[] = [
                    'id' => $id,
                    'source' => $project->id,
                    'target' => $task->id,
                    'type' => 1
                ];
            }

            $ganttData = [
                'data' => $data,
                'links' => $links
            ];
        }
        //        return $ganttData;
        return view('admin.projects.gantt', $this->data);
    }

    public function ganttData()
    {

        $data = array();
        $links = array();

        $projects = Project::select('id', 'project_name', 'start_date', 'deadline')->get();

        $id = 0; //count for gantt ids
        foreach ($projects as $project) {
            $id = $id + 1;
            $projectId = $id;

            // TODO::ProjectDeadline to do
            $projectDuration = 0;
            if ($project->deadline) {
                $projectDuration = $project->deadline->diffInDays($project->start_date);
            }

            $data[] = [
                'id' => $projectId,
                'text' => ucwords($project->project_name),
                'start_date' => $project->start_date->format('Y-m-d H:i:s'),
                'duration' => $projectDuration
            ];

            $tasks = Task::projectOpenTasks($project->id);

            foreach ($tasks as $key => $task) {
                $id = $id + 1;

                $taskDuration = $task->due_date->diffInDays($project->created_at);
                $data[] = [
                    'id' => $id,
                    'text' => ucfirst($task->heading),
                    'start_date' => $task->created_at->format('Y-m-d H:i:s'),
                    'duration' => $taskDuration,
                    'parent' => $projectId,
                    'users' => [
                        ucwords($task->user->name)
                    ]
                ];

                $links[] = [
                    'id' => $id,
                    'source' => $project->id,
                    'target' => $task->id,
                    'type' => 1
                ];
            }

            $ganttData = [
                'data' => $data,
                'links' => $links
            ];
        }

        return response()->json($ganttData);
    }

    public function updateStatus(Request $request, $id)
    {
        $project = Project::find($id)
            ->update([
                $request->status => $request->value
            ]);

        return Reply::dataOnly(['status' => 'success']);
    }
}
