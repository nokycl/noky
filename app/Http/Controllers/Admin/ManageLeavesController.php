<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Reply;
use App\Http\Requests\Leaves\StoreLeave;
use App\Http\Requests\Leaves\UpdateLeave;
use App\Leave;
use App\LeaveType;
use App\Notifications\LeaveStatusApprove;
use App\Notifications\LeaveStatusReject;
use App\Notifications\LeaveStatusUpdate;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ManageLeavesController extends AdminBaseController
{
    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.leaves';
        $this->pageIcon = 'icon-logout';
        $this->middleware(function ($request, $next) {
            if(!in_array('leaves',$this->user->modules)){
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
        $this->leaves = Leave::where('status', '<>', 'rejected')
            ->get();
        $this->pendingLeaves = Leave::where('status', 'pending')
            ->orderBy('leave_date', 'asc')
            ->get();
        return view('admin.leaves.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->employees = User::allEmployees();
        $this->leaveTypes = LeaveType::all();
        return view('admin.leaves.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLeave $request)
    {
        if($request->duration == 'multiple'){
            $dates = explode(',', $request->multi_date);
            foreach($dates as $date){
                $leave = new Leave();
                $leave->user_id = $request->user_id;
                $leave->leave_type_id = $request->leave_type_id;
                $leave->duration = $request->duration;
                $leave->leave_date = Carbon::parse($date)->format('Y-m-d');
                $leave->reason = $request->reason;
                $leave->status = $request->status;
                $leave->save();
            }

            return Reply::redirect(route('admin.leaves.index'), __('messages.leaveAssignSuccess'));
        }
        else{
            $leave = new Leave();
            $leave->user_id = $request->user_id;
            $leave->leave_type_id = $request->leave_type_id;
            $leave->duration = $request->duration;
            $leave->leave_date = Carbon::parse($request->leave_date)->format('Y-m-d');
            $leave->reason = $request->reason;
            $leave->status = $request->status;
            $leave->save();
            return Reply::redirect(route('admin.leaves.index'), __('messages.leaveAssignSuccess'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->leave = Leave::findOrFail($id);
        return view('admin.leaves.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->employees = User::allEmployees();
        $this->leaveTypes = LeaveType::all();
        $this->leave = Leave::findOrFail($id);
        $view = view('admin.leaves.edit', $this->data)->render();
        return Reply::dataOnly(['status' => 'success', 'view' => $view]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLeave $request, $id)
    {
        $leave = Leave::findOrFail($id);
        $oldStatus = $leave->status;

        $leave->user_id = $request->user_id;
        $leave->leave_type_id = $request->leave_type_id;
        $leave->leave_date = Carbon::parse($request->leave_date)->format('Y-m-d');
        $leave->reason = $request->reason;
        $leave->status = $request->status;
        $leave->save();

        if($oldStatus != $request->status){
            //      Send notification to user
            $notifyUser = User::withoutGlobalScope('active')->findOrFail($leave->user_id);
            $notifyUser->notify(new LeaveStatusUpdate($leave));
        }

        return Reply::redirect(route('admin.leaves.index'), __('messages.leaveAssignSuccess'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Leave::destroy($id);
        return Reply::success('messages.leaveDeleteSuccess');
    }

    public function leaveAction(Request $request) {
        $leave = Leave::findOrFail($request->leaveId);
        $leave->status = $request->action;
        if(!empty($request->reason)) {
            $leave->reject_reason = $request->reason;
        }
        $leave->save();

        //      Send notification to user
        $notifyUser = User::withoutGlobalScope('active')->findOrFail($leave->user_id);

        if($request->action == 'approved') {
            $notifyUser->notify(new LeaveStatusApprove($leave));
        } else {
            $notifyUser->notify(new LeaveStatusReject($leave));
        }

        return Reply::success(__('messages.leaveStatusUpdate'));
    }

    public function rejectModal(Request $request)
    {
        $this->leaveAction = $request->leave_action;
        $this->leaveID = $request->leave_id;
        return view('admin.leaves.reject-reason-modal', $this->data);
    }

    public function allLeave()
    {
        $this->employees = User::allEmployees();
        $this->fromDate = Carbon::today()->subDays(30);
        $this->toDate = Carbon::today();
        return view('admin.leaves.all-leaves', $this->data);
    }

    public function data($startDate = null, $endDate = null, $employeeId = null)
    {

        $startDt = '';
        $endDt = '';

        if(!is_null($startDate)){
            $startDt = 'DATE(leaves.`leave_date`) >= '.'"'.$startDate.'"';
        }

        if(!is_null($endDate)){
            $endDt = 'DATE(leaves.`leave_date`) <= '.'"'.$endDate.'"';
        }

        $leavesList = Leave::select('leaves.id', 'users.name', 'leaves.leave_date', 'leaves.status', 'leave_types.type_name', 'leave_types.color')
            ->where('leaves.status', '<>', 'rejected')
            ->whereRaw($startDt)
            ->whereRaw($endDt)
            ->join('users', 'users.id', '=', 'leaves.user_id')
            ->join('leave_types', 'leave_types.id', '=', 'leaves.leave_type_id');

        if($employeeId != 0) {
            $leavesList->where('leaves.user_id', $employeeId);
        }

        $leaves = $leavesList->get();

        return DataTables::of($leaves)
            ->addColumn('employee', function($row) {
                return ucwords($row->name);
            })
            ->addColumn('date', function($row) {
                return $row->leave_date->format('Y-m-d');
            })
            ->addColumn('status', function($row) {
                $label = $row->status == 'pending' ? 'warning' : 'success';
                return '<div class="label label-'.$label.'">'.$row->status.'</div>';
            })
            ->addColumn('leave_type', function($row) {
                return '<div class="label-'.$row->color.' label">'.$row->type_name.'</div>';
            })
            ->addColumn('action', function($row) {
                if ($row->status == 'pending'){
                    return '<a href="javascript:;" data-leave-id="'.$row->id.'" data-leave-action="approved" data-toggle="tooltip" data-original-title="Accept" class="btn btn-info btn-circle leave-action"><i class="fa fa-check"></i></a>
<a href="javascript:;" data-leave-id="'.$row->id.'" data-leave-action="rejected" data-toggle="tooltip" data-original-title="Reject" class="btn btn-danger btn-circle leave-action-reject"><i class="fa fa-times"></i></a>';
                }
                else{
                    return '';
                }
            })
            ->addIndexColumn()
            ->rawColumns(['date', 'status', 'leave_type', 'action'])
            ->make(true);
    }

}
