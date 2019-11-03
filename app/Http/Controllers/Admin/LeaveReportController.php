<?php

namespace App\Http\Controllers\Admin;

use App\Leave;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LeaveReportController extends AdminBaseController
{
    /**
     * LeaveReportController constructor.
     */
    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.leaveReport';
        $this->pageIcon = 'ti-pie-chart';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->employees = User::allEmployees();
        $this->fromDate = Carbon::today()->subDays(30);
        $this->toDate = Carbon::today();

        return view('admin.reports.leave.index', $this->data);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        $this->modalHeader = 'approved';
        $casualLeaves = Leave::join('leave_types', 'leave_types.id', '=', 'leaves.leave_type_id')
            ->where('leave_types.type_name', 'Casual')
            ->where('leaves.status', 'approved')
            ->where('leaves.user_id', $id);

            if($request->startDate !== null && $request->startDate != 'null' && $request->startDate != ''){
                $casualLeaves = $casualLeaves->where(DB::raw('DATE(leaves.`leave_date`)'), '>=', $request->startDate);
            }

            if($request->endDate !== null && $request->endDate != 'null' && $request->endDate != ''){
                $casualLeaves = $casualLeaves->where(DB::raw('DATE(leaves.`leave_date`)'), '<=', $request->endDate);
            }

            $casualLeaves = $casualLeaves ->count();

            $this->casualLeaves = $casualLeaves;

        $sickLeaves = Leave::join('leave_types', 'leave_types.id', '=', 'leaves.leave_type_id')
            ->where('leave_types.type_name', 'Sick')
            ->where('leaves.status', 'approved')
            ->where('leaves.user_id', $id);

            if($request->startDate !== null && $request->startDate != 'null' && $request->startDate != ''){
                $sickLeaves = $sickLeaves->where(DB::raw('DATE(leaves.`leave_date`)'), '>=', $request->startDate);
            }

            if($request->endDate !== null && $request->endDate != 'null' && $request->endDate != ''){
                $sickLeaves = $sickLeaves->where(DB::raw('DATE(leaves.`leave_date`)'), '<=', $request->endDate);
            }

            $sickLeaves = $sickLeaves ->count();

            $this->sickLeaves = $sickLeaves;

        $earnedLeaves = Leave::join('leave_types', 'leave_types.id', '=', 'leaves.leave_type_id')
            ->where('leave_types.type_name', 'Earned')
            ->where('leaves.status', 'approved')
            ->where('leaves.user_id', $id);

            if($request->startDate !== null && $request->startDate != 'null' && $request->startDate != ''){
                $earnedLeaves = $earnedLeaves->where(DB::raw('DATE(leaves.`leave_date`)'), '>=', $request->startDate);
            }

            if($request->endDate !== null && $request->endDate != 'null' && $request->endDate != ''){
                $earnedLeaves = $earnedLeaves->where(DB::raw('DATE(leaves.`leave_date`)'), '<=', $request->endDate);
            }

            $earnedLeaves = $earnedLeaves->count();

            $this->earnedLeaves = $earnedLeaves;

        $leaves = Leave::join('leave_types', 'leave_types.id', '=', 'leaves.leave_type_id')
            ->select('leave_types.type_name', 'leaves.leave_date', 'leaves.reason')
            ->where('leaves.status', 'approved')
            ->where('leaves.user_id', $id);

            if($request->startDate !== null && $request->startDate != 'null' && $request->startDate != ''){
                $leaves = $leaves->where(DB::raw('DATE(leaves.`leave_date`)'), '>=', $request->startDate);
            }

            if($request->endDate !== null && $request->endDate != 'null' && $request->endDate != ''){
                $leaves = $leaves->where(DB::raw('DATE(leaves.`leave_date`)'), '<=', $request->endDate);
            }

            $leaves = $leaves->get();

            $this->leaves = $leaves;

        return view('admin.reports.leave.leave-detail', $this->data);
    }

    /**
     * @param null $startDate
     * @param null $endDate
     * @param null $employeeId
     * @return mixed
     */
    public function data($startDate = null, $endDate = null, $employeeId = null)
    {

        $startDt = '';
        $endDt = '';

        if(!is_null($startDate)){
            $startDt = 'and DATE(leaves.`leave_date`) >= '.'"'.$startDate.'"';
        }

        if(!is_null($endDate)){
            $endDt = 'and DATE(leaves.`leave_date`) <= '.'"'.$endDate.'"';
        }

        $leavesList = User::selectRaw(
            'users.id, users.name, 
                ( select count("id") from leaves where user_id = users.id and leaves.status = \'approved\' '.$startDt.' '.$endDt.' ) as count_approved_leaves,
                ( select count("id") from leaves where user_id = users.id and leaves.status = \'pending\' '.$startDt.' '.$endDt.') as count_pending_leaves, 
                ( select count("id") from leaves where user_id = users.id and leaves.leave_date > "'.Carbon::now()->format('Y-m-d').'" and leaves.status != \'rejected\' '.$startDt.' '.$endDt.') as count_upcoming_leaves'
        )->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->where('roles.name', '<>', 'client');

        if($employeeId != 0) {
            $leavesList->where('users.id', $employeeId);
        }

        $leaves = $leavesList->groupBy('users.id')->get();

        return DataTables::of($leaves)
            ->addColumn('employee', function($row) {
                return ucwords($row->name);
            })
            ->addColumn('approve', function($row) {
                return '<div class="label-success label">'.$row->count_approved_leaves.'</div>
                <a href="javascript:;" class="view-approve" data-pk="'.$row->id.'">View</a>';
            })
            ->addColumn('pending', function($row) {
                return '<div class="label-warning label">'.$row->count_pending_leaves.'</div>
                <a href="javascript:;" data-pk="'.$row->id.'" class="view-pending">View</a>';
            })
            ->addColumn('upcoming', function($row) {
                return '<div class="label-info label">'.$row->count_upcoming_leaves.'</div>
                <a href="javascript:;" data-pk="'.$row->id.'" class="view-upcoming">View</a>';
            })
            ->addColumn('action', function($row) {
                return '<a  href="javascript:;" data-pk="'.$row->id.'"  class="btn btn-info btn-sm exportUserData"
                      data-toggle="tooltip" data-original-title="Export to excel"><i class="ti-export" aria-hidden="true"></i> Export</a>';
            })
            ->addIndexColumn()
            ->rawColumns(['approve', 'upcoming', 'pending', 'action'])
            ->make(true);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pendingLeaves(Request $request, $id)
    {

        $this->modalHeader = 'pending';
        $casualLeaves = Leave::join('leave_types', 'leave_types.id', '=', 'leaves.leave_type_id')
            ->where('leave_types.type_name', 'Casual')
            ->where('leaves.status', 'pending')
            ->where('leaves.user_id', $id);

             if($request->startDate !== null && $request->startDate != 'null' && $request->startDate != ''){
                 $casualLeaves = $casualLeaves->where(DB::raw('DATE(leaves.`leave_date`)'), '>=', $request->startDate);
             }

             if($request->endDate !== null && $request->endDate != 'null' && $request->endDate != ''){
                $casualLeaves = $casualLeaves->where(DB::raw('DATE(leaves.`leave_date`)'), '<=', $request->endDate);
             }

            $casualLeaves = $casualLeaves->count();

        $this->casualLeaves = $casualLeaves;

        $sickLeaves = Leave::join('leave_types', 'leave_types.id', '=', 'leaves.leave_type_id')
            ->where('leave_types.type_name', 'Sick')
            ->where('leaves.status', 'pending')
            ->where('leaves.user_id', $id);

            if($request->startDate !== null && $request->startDate != 'null' && $request->startDate != ''){
                $sickLeaves = $sickLeaves->where(DB::raw('DATE(leaves.`leave_date`)'), '>=', $request->startDate);
            }

            if($request->endDate !== null && $request->endDate != 'null' && $request->endDate != ''){
                $sickLeaves = $sickLeaves->where(DB::raw('DATE(leaves.`leave_date`)'), '<=', $request->endDate);
            }

            $sickLeaves = $sickLeaves->count();

            $this->sickLeaves = $sickLeaves;

        $earnedLeaves = Leave::join('leave_types', 'leave_types.id', '=', 'leaves.leave_type_id')
            ->where('leave_types.type_name', 'Earned')
            ->where('leaves.status', 'pending')
            ->where('leaves.user_id', $id);

            if($request->startDate !== null && $request->startDate != 'null' && $request->startDate != ''){
                $earnedLeaves = $earnedLeaves->where(DB::raw('DATE(leaves.`leave_date`)'), '>=', $request->startDate);
            }

            if($request->endDate !== null && $request->endDate != 'null' && $request->endDate != ''){
                $earnedLeaves = $earnedLeaves->where(DB::raw('DATE(leaves.`leave_date`)'), '<=', $request->endDate);
            }

            $earnedLeaves = $earnedLeaves->count();

            $this->earnedLeaves = $earnedLeaves;

        $leaves = Leave::join('leave_types', 'leave_types.id', '=', 'leaves.leave_type_id')
            ->select('leave_types.type_name', 'leaves.leave_date', 'leaves.reason')
            ->where('leaves.status', 'pending')
            ->where('leaves.user_id', $id);

            if($request->startDate !== null && $request->startDate != 'null' && $request->startDate != ''){
                $leaves = $leaves->where(DB::raw('DATE(leaves.`leave_date`)'), '>=', $request->startDate);
            }

            if($request->endDate !== null && $request->endDate != 'null' && $request->endDate != ''){
                $leaves = $leaves->where(DB::raw('DATE(leaves.`leave_date`)'), '<=', $request->endDate);
            }

            $leaves = $leaves->get();

            $this->leaves = $leaves;


        return view('admin.reports.leave.leave-detail', $this->data);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function upcomingLeaves(Request $request, $id)
    {
        $this->modalHeader = 'upcoming';
        $casualLeaves = Leave::join('leave_types', 'leave_types.id', '=', 'leaves.leave_type_id')
            ->where('leave_types.type_name', 'Casual')
            ->where(function($q) {
                $q ->where('leaves.status', 'pending')
                    ->orWhere('leaves.status', 'approved');
            })
            ->where('leaves.leave_date','>', Carbon::now()->format('Y-m-d'))
            ->where('leaves.user_id', $id);
            if($request->startDate !== null && $request->startDate != 'null' && $request->startDate != ''){
                $casualLeaves = $casualLeaves->where(DB::raw('DATE(leaves.`leave_date`)'), '>=', $request->startDate);
            }

            if($request->endDate !== null && $request->endDate != 'null' && $request->endDate != ''){
                $casualLeaves = $casualLeaves->where(DB::raw('DATE(leaves.`leave_date`)'), '<=', $request->endDate);
            }

            $casualLeaves = $casualLeaves ->count();

            $this->casualLeaves = $casualLeaves;

        $sickLeaves = Leave::join('leave_types', 'leave_types.id', '=', 'leaves.leave_type_id')
            ->where('leave_types.type_name', 'Sick')
            ->where(function($q) {
                $q ->where('leaves.status', 'pending')
                    ->orWhere('leaves.status', 'approved');
            })
            ->where('leaves.leave_date','>', Carbon::now()->format('Y-m-d'))
            ->where('leaves.user_id', $id);

            if($request->startDate !== null && $request->startDate != 'null' && $request->startDate != ''){
                $sickLeaves = $sickLeaves->where(DB::raw('DATE(leaves.`leave_date`)'), '>=', $request->startDate);
            }

            if($request->endDate !== null && $request->endDate != 'null' && $request->endDate != ''){
                $sickLeaves = $sickLeaves->where(DB::raw('DATE(leaves.`leave_date`)'), '<=', $request->endDate);
            }

            $sickLeaves = $sickLeaves ->count();

            $this->sickLeaves = $sickLeaves;

        $earnedLeaves = Leave::join('leave_types', 'leave_types.id', '=', 'leaves.leave_type_id')
            ->where('leave_types.type_name', 'Earned')
            ->where(function($q) {
                $q ->where('leaves.status', 'pending')
                    ->orWhere('leaves.status', 'approved');
            })
            ->where('leaves.leave_date','>', Carbon::now()->format('Y-m-d'))
            ->where('leaves.user_id', $id);

            if($request->startDate !== null && $request->startDate != 'null' && $request->startDate != ''){
                $earnedLeaves = $earnedLeaves->where(DB::raw('DATE(leaves.`leave_date`)'), '>=', $request->startDate);
            }

            if($request->endDate !== null && $request->endDate != 'null' && $request->endDate != ''){
                $earnedLeaves = $earnedLeaves->where(DB::raw('DATE(leaves.`leave_date`)'), '<=', $request->endDate);
            }

            $earnedLeaves = $earnedLeaves ->count();

            $this->earnedLeaves = $earnedLeaves;

        $leaves = Leave::join('leave_types', 'leave_types.id', '=', 'leaves.leave_type_id')
            ->select('leave_types.type_name', 'leaves.leave_date', 'leaves.reason')
            ->where(function($q) {
                $q ->where('leaves.status', 'pending')
                    ->orWhere('leaves.status', 'approved');
            })
            ->where('leaves.leave_date','>', Carbon::now()->format('Y-m-d'))
            ->where('leaves.user_id', $id);

            if($request->startDate !== null && $request->startDate != 'null' && $request->startDate != ''){
                $leaves = $leaves->where(DB::raw('DATE(leaves.`leave_date`)'), '>=', $request->startDate);
            }

            if($request->endDate !== null && $request->endDate != 'null' && $request->endDate != ''){
                $leaves = $leaves->where(DB::raw('DATE(leaves.`leave_date`)'), '<=', $request->endDate);
            }

            $leaves = $leaves ->get();

            $this->leaves = $leaves;

        return view('admin.reports.leave.leave-detail', $this->data);
    }

    public function export($id, $startDate= null, $endDate = null) {
        $employees = User::find($id);
        $rows = Leave::join('leave_types', 'leave_types.id', '=', 'leaves.leave_type_id')
            ->where('leaves.user_id', $id)
            ->select(
                'leave_types.type_name',
                'leaves.leave_date',
                'leaves.reason',
                'leaves.status',
                'leaves.reject_reason'
            );

        if($startDate !== null && $startDate != 'null' && $startDate != ''){
            $rows = $rows->where(DB::raw('DATE(leaves.`leave_date`)'), '>=', $startDate);
        }

        if($endDate !== null && $endDate != 'null' && $endDate != ''){
            $rows = $rows->where(DB::raw('DATE(leaves.`leave_date`)'), '<=', $endDate);
        }


        $rows = $rows->get();

        // Initialize the array which will be passed into the Excel
        // generator.
        $exportArray = [];

        // Define the Excel spreadsheet headers
        $exportArray[] = ['Leave Type', 'Date', 'Reason', 'Status', 'Reject Reason'];

        // Convert each member of the returned collection into an array,
        // and append it to the payments array.
        foreach ($rows as $row) {
            $exportArray[] = $row->toArray();
        }

        // Generate and return the spreadsheet
        Excel::create($employees->name.' Leaves', function ($excel) use ($employees, $exportArray) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle($employees->name.' Leaves');
            $excel->setCreator('Worksuite')->setCompany($this->companyName);
            $excel->setDescription('Leaves file');

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
}
