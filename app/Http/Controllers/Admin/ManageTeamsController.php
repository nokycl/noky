<?php

namespace App\Http\Controllers\Admin;

use App\EmployeeTeam;
use App\Helper\Reply;
use App\Http\Requests\Team\StoreTeam;
use App\Team;
use App\User;

class ManageTeamsController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.teams';
        $this->pageIcon = 'icon-user';
        $this->middleware(function ($request, $next) {
            if(!in_array('employees',$this->user->modules)){
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
        $this->groups = Team::all();
        return view('admin.teams.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.teams.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeam $request)
    {
        $group = new Team();
        $group->team_name = $request->team_name;
        $group->save();

        return Reply::redirect(route('admin.teams.index'), 'Group created successfully.');
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
        $this->group = Team::findOrFail($id);
        $this->employees = User::doesntHave('group', 'and', function($query) use ($id){
            $query->where('team_id', $id);
        })
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select('users.id', 'users.name', 'users.email', 'users.created_at')
            ->where('roles.name', '<>', 'client')
            ->groupBy('users.id')
            ->get();
        return view('admin.teams.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTeam $request, $id)
    {
        $group = Team::find($id);
        $group->team_name = $request->team_name;
        $group->save();

        if(!empty($users = $request->user_id)){
            foreach($users as $user){
                $member = new EmployeeTeam();
                $member->user_id = $user;
                $member->team_id = $id;
                $member->save();
            }
        }


        return Reply::redirect(route('admin.teams.index'), __('messages.groupUpdatedSuccessfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Team::destroy($id);
        return Reply::successWithData(__('messages.deleteSuccess'), ['status' => 'success']);
    }
}
