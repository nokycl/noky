<?php

namespace App\Http\Controllers\Admin;

use App\EmployeeDetails;
use App\EmployeeDocs;
use App\EmployeeSkill;
use App\Helper\Reply;
use App\Http\Requests\Admin\User\StoreUser;
use App\Http\Requests\Admin\User\UpdateEmployee;
use App\Leave;
use App\LeaveType;
use App\Notifications\NewUser;
use App\Project;
use App\ProjectMember;
use App\ProjectTimeLog;
use App\Role;
use App\RoleUser;
use App\Skill;
use App\Task;
use App\User;
use App\UserActivity;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use App\TaskboardColumn;

class ManageEmployeesController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.employees';
        $this->pageIcon = 'icon-user';
        $this->middleware(function ($request, $next) {
            if (!in_array('employees', $this->user->modules)) {
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
        $this->employees = User::allEmployees();
        $this->skills = Skill::all();
        $this->totalEmployees = count($this->employees);
        $this->roles = Role::where('roles.name', '<>', 'client')->get();
        $whoseProjectCompleted = ProjectMember::join('projects', 'projects.id', '=', 'project_members.project_id')
            ->join('users', 'users.id', '=', 'project_members.user_id')
            ->select('users.*')
            ->groupBy('project_members.user_id')
            ->havingRaw("min(projects.completion_percent) = 100 and max(projects.completion_percent) = 100")
            ->orderBy('users.id')
            ->get();

        $notAssignedProject = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select('users.id', 'users.name')->whereNotIn('users.id', function ($query) {

                $query->select('user_id as id')->from('project_members');
            })
            ->where('roles.name', '<>', 'client')
            ->get();

        $this->freeEmployees = $whoseProjectCompleted->merge($notAssignedProject)->count();

        return view('admin.employees.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employee = new EmployeeDetails();
        $this->fields = $employee->getCustomFieldGroupsWithFields()->fields;
        $this->skills = Skill::all()->pluck('name')->toArray();
        return view('admin.employees.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {
        $company = company();

        if ($company->employees->count() >= $company->package->max_employees) {
            return Reply::error(__('messages.upgradePackageForAddEmployees', ['employeeCount' => company()->employees->count(), 'maxEmployees' => $company->package->max_employees]));
        }

        if ($company->package->max_employees < $company->employees->count()) {
            return Reply::error(__('messages.downGradePackageForAddEmployees', ['employeeCount' => company()->employees->count(), 'maxEmployees' => $company->package->max_employees]));
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->mobile = $request->input('mobile');
        $user->gender = $request->input('gender');
        $user->login = $request->login;

        if ($request->hasFile('image')) {

            $image = $request->image->hashName();
            $user->image = $image;
            $request->image->store('user-uploads/avatar');

            // resize the image to a width of 300 and constrain aspect ratio (auto height)
            $img = Image::make('user-uploads/avatar/' . $image);
            $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save();
        }

        $user->save();

        $tags = json_decode($request->tags);
        if (!empty($tags)) {
            foreach ($tags as $tag) {
                // check or store skills
                $skillData = Skill::firstOrCreate(['name' => strtolower($tag->value)]);

                // Store user skills
                $skill = new EmployeeSkill();
                $skill->user_id = $user->id;
                $skill->skill_id = $skillData->id;
                $skill->save();
            }
        }

        if ($user->id) {
            $employee = new EmployeeDetails();
            $employee->user_id = $user->id;
            $employee->job_title = $request->job_title;
            $employee->address = $request->address;
            $employee->hourly_rate = $request->hourly_rate;
            $employee->slack_username = $request->slack_username;
            $employee->joining_date = Carbon::parse($request->joining_date)->format('Y-m-d');
            $employee->last_date = Carbon::parse($request->last_date)->format('Y-m-d');
            $employee->save();
        }

        // To add custom fields data
        if ($request->get('custom_fields_data')) {
            $employee->updateCustomFieldData($request->get('custom_fields_data'));
        }


        $role = Role::where('name', 'employee')->first();
        $user->attachRole($role->id);

        // Notify User
        $user->notify(new NewUser($request->input('password')));

        $this->logSearchEntry($user->id, $user->name, 'admin.employees.show');

        return Reply::redirect(route('admin.employees.index'), __('messages.employeeAdded'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->employee = User::withoutGlobalScope('active')->findOrFail($id);
        $this->employeeDetail = EmployeeDetails::where('user_id', '=', $this->employee->id)->first();
        $this->employeeDocs = EmployeeDocs::where('user_id', '=', $this->employee->id)->get();

        if (!is_null($this->employeeDetail)) {
            $this->employeeDetail = $this->employeeDetail->withCustomFields();
            $this->fields = $this->employeeDetail->getCustomFieldGroupsWithFields()->fields;
        }

        $completedTaskColumn = TaskboardColumn::where('slug', 'completed')->first();

        $this->taskCompleted = Task::where('user_id', $id)
            ->where('board_column_id', $completedTaskColumn->id)
            ->count();

        $hoursLogged = ProjectTimeLog::where('user_id', $id)->sum('total_minutes');

        $timeLog = intdiv($hoursLogged, 60) . ' hrs ';

        if (($hoursLogged % 60) > 0) {
            $timeLog .= ($hoursLogged % 60) . ' mins';
        }

        $this->hoursLogged = $timeLog;

        $this->activities = UserActivity::where('user_id', $id)->orderBy('id', 'desc')->get();
        $this->projects = Project::select('projects.id', 'projects.project_name', 'projects.deadline', 'projects.completion_percent')
            ->join('project_members', 'project_members.project_id', '=', 'projects.id')
            ->where('project_members.user_id', '=', $id)
            ->get();
        $this->leaves = Leave::byUser($id);

        $this->leaveTypes = LeaveType::byUser($id);
        $this->allowedLeaves = LeaveType::sum('no_of_leaves');

        return view('admin.employees.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->userDetail = User::withoutGlobalScope('active')->findOrFail($id);
        $this->employeeDetail = EmployeeDetails::where('user_id', '=', $this->userDetail->id)->first();
        $this->skills = Skill::all()->pluck('name')->toArray();
        if (!is_null($this->employeeDetail)) {
            $this->employeeDetail = $this->employeeDetail->withCustomFields();
            $this->fields = $this->employeeDetail->getCustomFieldGroupsWithFields()->fields;
        }

        return view('admin.employees.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployee $request, $id)
    {
        $user = User::withoutGlobalScope('active')->findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->password != '') {
            $user->password = Hash::make($request->input('password'));
        }
        $user->mobile = $request->input('mobile');
        $user->gender = $request->input('gender');
        $user->status = $request->input('status');
        $user->login = $request->login;

        if ($request->hasFile('image')) {
            File::delete('user-uploads/avatar/' . $user->image);

            $user->image = $request->image->hashName();
            $request->image->store('user-uploads/avatar');

            // resize the image to a width of 300 and constrain aspect ratio (auto height)
            $img = Image::make('user-uploads/avatar/' . $user->image);
            $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save();
        }

        $user->save();

        $tags = json_decode($request->tags);
        if (!empty($tags)) {
            EmployeeSkill::where('user_id', $user->id)->delete();
            foreach ($tags as $tag) {
                // check or store skills
                $skillData = Skill::firstOrCreate(['name' => strtolower($tag->value)]);

                // Store user skills
                $skill = new EmployeeSkill();
                $skill->user_id = $user->id;
                $skill->skill_id = $skillData->id;
                $skill->save();
            }
        }


        $employee = EmployeeDetails::where('user_id', '=', $user->id)->first();
        if (empty($employee)) {
            $employee = new EmployeeDetails();
            $employee->user_id = $user->id;
        }
        $employee->job_title = $request->job_title;
        $employee->address = $request->address;
        $employee->hourly_rate = $request->hourly_rate;
        $employee->slack_username = $request->slack_username;
        $employee->joining_date = Carbon::parse($request->joining_date)->format('Y-m-d');
        $employee->last_date = Carbon::parse($request->last_date)->format('Y-m-d');
        $employee->save();

        // To add custom fields data
        if ($request->get('custom_fields_data')) {
            $employee->updateCustomFieldData($request->get('custom_fields_data'));
        }

        return Reply::redirect(route('admin.employees.index'), __('messages.employeeUpdated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::withoutGlobalScope('active')->findOrFail($id);

        if ($user->id == 1) {
            return Reply::error(__('messages.adminCannotDelete'));
        }

        User::destroy($id);
        return Reply::success(__('messages.employeeDeleted'));
    }

    public function data(Request $request)
    {
        if ($request->role != 'all' && $request->role != '') {
            $userRoles = Role::findOrFail($request->role);
        }

        $users = User::with('role')
            ->withoutGlobalScope('active')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select('users.id', 'users.name', 'users.email', 'users.created_at', 'roles.name as roleName', 'roles.id as roleId', 'users.image', 'users.status', \DB::raw("(select user_roles.role_id from role_user as user_roles where user_roles.user_id = users.id ORDER BY user_roles.role_id DESC limit 1) as `current_role`"))
            ->where('roles.name', '<>', 'client');

        if ($request->status != 'all' && $request->status != '') {
            $users = $users->where('users.status', $request->status);
        }

        if ($request->employee != 'all' && $request->employee != '') {
            $users = $users->where('users.id', $request->employee);
        }

        if ($request->role != 'all' && $request->role != '' && $userRoles) {
            if ($userRoles->name == 'admin') {
                $users = $users->where('roles.id', $request->role);
            } elseif ($userRoles->name == 'employee') {
                $users =  $users->where(\DB::raw("(select user_roles.role_id from role_user as user_roles where user_roles.user_id = users.id ORDER BY user_roles.role_id DESC limit 1)"), $request->role)
                    ->having('roleName', '<>', 'admin');
            } else {
                $users = $users->where(\DB::raw("(select user_roles.role_id from role_user as user_roles where user_roles.user_id = users.id ORDER BY user_roles.role_id DESC limit 1)"), $request->role);
            }
        }
        if ($request->skill != 'all' && $request->skill != '' && $request->skill != null && $request->skill != 'null') {
            $users =  $users->join('employee_skills', 'employee_skills.user_id', '=', 'users.id')
                ->whereIn('employee_skills.skill_id', explode(',', $request->skill));
        }

        $users = $users->groupBy('users.id')->get();
        $roles = Role::where('name', '<>', 'client')->get();
        $firstAdmin = User::firstAdmin();
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('role', function ($row) use ($roles, $firstAdmin) {
                $roleRow = '';
                if ($row->id != $firstAdmin->id) {

                    $flag = 0;
                    foreach ($roles as $role) {

                        $roleRow .= '<div class="radio radio-info">
                              <input type="radio" name="role_' . $row->id . '" class="assign_role" data-user-id="' . $row->id . '"';

                        foreach ($row->role as $urole) {

                            if ($role->id == $urole->role_id && $flag == 0) {
                                $roleRow .= ' checked ';

                                if ($role->name == 'admin') {
                                    $flag = 1; //do not check any other role for user if is admin
                                }
                            }
                        }

                        if ($role->id <= 3) {
                            $roleRow .= 'id="none_role_' . $row->id . $role->id . '" data-role-id="' . $role->id . '" value="' . $role->id . '"> <label for="none_role_' . $row->id . $role->id . '" data-role-id="' . $role->id . '" data-user-id="' . $row->id . '">' . __('app.' . $role->name) . '</label></div>';
                        } else {
                            $roleRow .= 'id="none_role_' . $row->id . $role->id . '" data-role-id="' . $role->id . '" value="' . $role->id . '"> <label for="none_role_' . $row->id . $role->id . '" data-role-id="' . $role->id . '" data-user-id="' . $row->id . '">' . ucwords($role->name) . '</label></div>';
                        }

                        $roleRow .= '<br>';
                    }
                    return $roleRow;
                } else {
                    return __('messages.roleCannotChange');
                }
            })
            ->addColumn('action', function ($row) {
                return '<a href="' . route('admin.employees.edit', [$row->id]) . '" class="btn btn-info btn-circle"
                      data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                      <a href="' . route('admin.employees.show', [$row->id]) . '" class="btn btn-success btn-circle"
                      data-toggle="tooltip" data-original-title="View Employee Details"><i class="fa fa-search" aria-hidden="true"></i></a>

                      <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                      data-toggle="tooltip" data-user-id="' . $row->id . '" data-original-title="Delete"><i class="fa fa-times" aria-hidden="true"></i></a>';
            })
            ->editColumn(
                'created_at',
                function ($row) {
                    return Carbon::parse($row->created_at)->format($this->global->date_format);
                }
            )
            ->editColumn(
                'email',
                function ($row) {
                    return $row->email;
                }
            )
            ->editColumn(
                'status',
                function ($row) {
                    if ($row->status == 'active') {
                        return '<label class="label label-success">' . __('app.active') . '</label>';
                    } else {
                        return '<label class="label label-danger">' . __('app.inactive') . '</label>';
                    }
                }
            )
            ->editColumn('name', function ($row) use ($roles) {
                $image = ($row->image) ? '<img src="' . asset('user-uploads/avatar/' . $row->image) . '"
                                                            alt="user" class="img-circle" width="30"> ' : '<img src="' . asset('default-profile-2.png') . '"
                                                            alt="user" class="img-circle" width="30"> ';
                if ($row->hasRole('admin')) {

                    return '<a href="' . route('admin.employees.show', $row->id) . '">' . $image . ' ' . ucwords($row->name) . '</a><br><br> <label class="label label-danger">' . __('app.admin') . '</label>';
                } else {
                    foreach ($roles as $role) {
                        foreach ($row->role as $urole) {

                            if ($role->id == $urole->role_id && $role->id != 2) {
                                return '<a href="' . route('admin.employees.show', $row->id) . '">' . $image . ' ' . ucwords($row->name) . '</a><br><br> <label class="label label-info">' . ucwords($role->name) . '</label>';
                            }
                        }
                    }
                    return '<a href="' . route('admin.employees.show', $row->id) . '">' . $image . ' ' . ucwords($row->name) . '</a><br><br> <label class="label label-warning">' . __('app.employee') . '</label>';
                }
                return '<a href="' . route('admin.employees.show', $row->id) . '">' . $image . ' ' . ucwords($row->name) . '</a>';
            })
            ->rawColumns(['name', 'action', 'role', 'status'])
            ->removeColumn('roleId')
            ->removeColumn('roleName')
            ->removeColumn('current_role')
            ->make(true);
    }

    public function tasks($userId, $hideCompleted)
    {
        $taskBoardColumn = TaskboardColumn::where('slug', 'incomplete')->first();

        $tasks = Task::leftJoin('projects', 'projects.id', '=', 'tasks.project_id')
            ->join('taskboard_columns', 'taskboard_columns.id', '=', 'tasks.board_column_id')
            ->select('tasks.id', 'projects.project_name', 'tasks.heading', 'tasks.due_date', 'tasks.status', 'tasks.project_id', 'taskboard_columns.column_name', 'taskboard_columns.label_color')
            ->where('tasks.user_id', $userId);

        if ($hideCompleted == '1') {
            $tasks->where('tasks.board_column_id', $taskBoardColumn->id);
        }

        $tasks->get();

        return DataTables::of($tasks)
            ->editColumn('due_date', function ($row) {
                if ($row->due_date->isPast()) {
                    return '<span class="text-danger">' . $row->due_date->format($this->global->date_format) . '</span>';
                }
                return '<span class="text-success">' . $row->due_date->format($this->global->date_format) . '</span>';
            })
            ->editColumn('heading', function ($row) {
                return ucfirst($row->heading);
            })
            ->editColumn('column_name', function($row){
                return '<label class="label" style="background-color: '.$row->label_color.'">'.$row->column_name.'</label>';
             })
            ->editColumn('project_name', function ($row) {
                if (!is_null($row->project_name)) {
                    return '<a href="' . route('admin.projects.show', $row->project_id) . '">' . ucfirst($row->project_name) . '</a>';
                }
            })
            ->rawColumns(['column_name', 'project_name', 'due_date'])
            ->removeColumn('project_id')
            ->make(true);
    }

    public function timeLogs($userId)
    {
        $timeLogs = ProjectTimeLog::join('projects', 'projects.id', '=', 'project_time_logs.project_id')
            ->select('project_time_logs.id', 'projects.project_name', 'project_time_logs.start_time', 'project_time_logs.end_time', 'project_time_logs.total_hours', 'project_time_logs.memo', 'project_time_logs.project_id', 'project_time_logs.total_minutes')
            ->where('project_time_logs.user_id', $userId);
        $timeLogs->get();

        return DataTables::of($timeLogs)
            ->editColumn('start_time', function ($row) {
                return $row->start_time->timezone($this->global->timezone)->format($this->global->date_format . ' ' . $this->global->time_format);
            })
            ->editColumn('end_time', function ($row) {
                if (!is_null($row->end_time)) {
                    return $row->end_time->timezone($this->global->timezone)->format($this->global->date_format . ' ' . $this->global->time_format);
                } else {
                    return "<label class='label label-success'>Active</label>";
                }
            })
            ->editColumn('project_name', function ($row) {
                return '<a href="' . route('admin.projects.show', $row->project_id) . '">' . ucfirst($row->project_name) . '</a>';
            })
            ->editColumn('total_hours', function ($row) {
                $timeLog = intdiv($row->total_minutes, 60) . ' hrs ';

                if (($row->total_minutes % 60) > 0) {
                    $timeLog .= ($row->total_minutes % 60) . ' mins';
                }

                return $timeLog;
            })
            ->rawColumns(['end_time', 'project_name'])
            ->removeColumn('project_id')
            ->make(true);
    }

    public function export($status, $employee, $role)
    {
        if ($role != 'all' && $role != '') {
            $userRoles = Role::findOrFail($role);
        }
        $rows = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->withoutGlobalScope('active')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->where('roles.name', '<>', 'client')
            ->leftJoin('employee_details', 'users.id', '=', 'employee_details.user_id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.mobile',
                'employee_details.job_title',
                'employee_details.address',
                'employee_details.hourly_rate',
                'users.created_at',
                'roles.name as roleName'
            );
        if ($status != 'all' && $status != '') {
            $rows = $rows->where('users.status', $status);
        }

        if ($employee != 'all' && $employee != '') {
            $rows = $rows->where('users.id', $employee);
        }

        if ($role != 'all' && $role != '' && $userRoles) {
            if ($userRoles->name == 'admin') {
                $rows = $rows->where('roles.id', $role);
            } elseif ($userRoles->name == 'employee') {
                $rows =  $rows->where(\DB::raw("(select user_roles.role_id from role_user as user_roles where user_roles.user_id = users.id ORDER BY user_roles.role_id DESC limit 1)"), $role)
                    ->having('roleName', '<>', 'admin');
            } else {
                $rows = $rows->where(\DB::raw("(select user_roles.role_id from role_user as user_roles where user_roles.user_id = users.id ORDER BY user_roles.role_id DESC limit 1)"), $role);
            }
        }
        $attributes =  ['roleName'];
        $rows = $rows->groupBy('users.id')->get()->makeHidden($attributes);

        // Initialize the array which will be passed into the Excel
        // generator.
        $exportArray = [];

        // Define the Excel spreadsheet headers
        $exportArray[] = ['ID', 'Name', 'Email', 'Mobile', 'Job Title', 'Address', 'Hourly Rate', 'Created at', 'Role'];

        // Convert each member of the returned collection into an array,
        // and append it to the payments array.
        foreach ($rows as $row) {
            $exportArray[] = [
                "id" => $row->id,
                "name" => $row->name,
                "email" => $row->email,
                "mobile" => $row->mobile,
                "job_title" => $row->job_title,
                "address" => $row->address,
                "hourly_rate" => $row->hourly_rate,
                "created_at" => $row->created_at->format('Y-m-d h:i:s a'),
                "roleName" => $row->roleName
            ];
        }

        // Generate and return the spreadsheet
        Excel::create('Employees', function ($excel) use ($exportArray) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Employees');
            $excel->setCreator('Worksuite')->setCompany($this->companyName);
            $excel->setDescription('Employees file');

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('sheet1', function ($sheet) use ($exportArray) {
                $sheet->fromArray($exportArray, null, 'A1', false, false);

                $sheet->row(1, function ($row) {

                    // call row manipulation methods
                    $row->setFont(array(
                        'bold' => true
                    ));
                });
            });
        })->download('xlsx');
    }

    public function assignRole(Request $request)
    {
        $userId = $request->userId;
        $roleId = $request->role;
        $employeeRole = Role::where('name', 'employee')->first();
        $user = User::findOrFail($userId);

        RoleUser::where('user_id', $user->id)->delete();
        $user->roles()->attach($employeeRole->id);
        if ($employeeRole->id != $roleId) {
            $user->roles()->attach($roleId);
        }

        return Reply::success(__('messages.roleAssigned'));
    }

    public function assignProjectAdmin(Request $request)
    {
        $userId = $request->userId;
        $projectId = $request->projectId;
        $project = Project::findOrFail($projectId);
        $project->project_admin = $userId;
        $project->save();

        return Reply::success(__('messages.roleAssigned'));
    }

    public function docsCreate(Request $request, $id)
    {
        $this->employeeID = $id;
        return view('admin.employees.docs-create', $this->data);
    }

    public function freeEmployees()
    {
        if (\request()->ajax()) {

            $whoseProjectCompleted = ProjectMember::join('projects', 'projects.id', '=', 'project_members.project_id')
                ->join('users', 'users.id', '=', 'project_members.user_id')
                ->select('users.*')
                ->groupBy('project_members.user_id')
                ->havingRaw("min(projects.completion_percent) = 100 and max(projects.completion_percent) = 100")
                ->orderBy('users.id')
                ->get();

            $notAssignedProject = User::join('role_user', 'role_user.user_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->select('users.*')
                ->whereNotIn('users.id', function ($query) {

                    $query->select('user_id as id')->from('project_members');
                })
                ->where('roles.name', '<>', 'client')
                ->get();

            $freeEmployees = $whoseProjectCompleted->merge($notAssignedProject);

            return DataTables::of($freeEmployees)
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('admin.employees.edit', [$row->id]) . '" class="btn btn-info btn-circle"
                      data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                      <a href="' . route('admin.employees.show', [$row->id]) . '" class="btn btn-success btn-circle"
                      data-toggle="tooltip" data-original-title="View Employee Details"><i class="fa fa-search" aria-hidden="true"></i></a>

                      <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                      data-toggle="tooltip" data-user-id="' . $row->id . '" data-original-title="Delete"><i class="fa fa-times" aria-hidden="true"></i></a>';
                })
                ->editColumn(
                    'created_at',
                    function ($row) {
                        return Carbon::parse($row->created_at)->format($this->global->date_format);
                    }
                )
                ->editColumn(
                    'status',
                    function ($row) {
                        if ($row->status == 'active') {
                            return '<label class="label label-success">' . __('app.active') . '</label>';
                        } else {
                            return '<label class="label label-danger">' . __('app.inactive') . '</label>';
                        }
                    }
                )
                ->editColumn('name', function ($row) {
                    $image = ($row->image) ? '<img src="' . asset('user-uploads/avatar/' . $row->image) . '"
                                                            alt="user" class="img-circle" width="30"> ' : '<img src="' . asset('default-profile-2.png') . '"
                                                            alt="user" class="img-circle" width="30"> ';
                    return '<a href="' . route('admin.employees.show', $row->id) . '">' . $image . ' ' . ucwords($row->name) . '</a>';
                })
                ->rawColumns(['name', 'action', 'role', 'status'])
                ->removeColumn('roleId')
                ->removeColumn('roleName')
                ->removeColumn('current_role')
                ->make(true);
        }

        return view('admin.employees.free_employees', $this->data);
    }
}
