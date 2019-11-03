<?php

namespace App\Http\Controllers\Admin;

use App\Attendance;
use App\AttendanceSetting;
use App\Helper\Reply;
use App\Holiday;
use App\Http\Requests\Attendance\StoreAttendance;
use App\Leave;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ManageAttendanceController extends AdminBaseController
{

    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.attendance';
        $this->pageIcon = 'icon-clock';
        $this->middleware(function ($request, $next) {
            if(!in_array('attendance',$this->user->modules)){
                abort(403);
            }
            return $next($request);
        });


        // Getting Attendance setting data
        $this->attendanceSettings = AttendanceSetting::first();

        //Getting Maximum Check-ins in a day
        $this->maxAttandenceInDay = $this->attendanceSettings->clockin_in_day;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $openDays = json_decode($this->attendanceSettings->office_open_days);
        $this->startDate = Carbon::today()->timezone($this->global->timezone)->startOfMonth();
        $this->endDate = Carbon::today()->timezone($this->global->timezone);
        $this->employees = User::allEmployees();
        $this->userId = User::first()->id;

        $this->totalWorkingDays = $this->startDate->diffInDaysFiltered(function(Carbon $date) use ($openDays){
            foreach($openDays as $day){
                if($date->dayOfWeek == $day){
                    return $date;
                }
            }
        }, $this->endDate);
        $this->daysPresent = Attendance::countDaysPresentByUser($this->startDate, $this->endDate, $this->userId);
        $this->daysLate = Attendance::countDaysLateByUser($this->startDate, $this->endDate, $this->userId);
        $this->halfDays = Attendance::countHalfDaysByUser($this->startDate, $this->endDate, $this->userId);
        $this->holidays = Count(Holiday::getHolidayByDates($this->startDate->format('Y-m-d'), $this->endDate->format('Y-m-d')));

        return view('admin.attendance.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.attendance.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttendance $request)
    {
        $date = Carbon::createFromFormat('m/d/Y', $request->date)->format('Y-m-d');
        $clockIn = Carbon::createFromFormat('h:i A', $request->clock_in_time, $this->global->timezone);
        $clockIn->setTimezone('UTC');
        $clockIn = $clockIn->format('H:i:s');
        if($request->clock_out_time != ''){
            $clockOut = Carbon::createFromFormat('h:i A', $request->clock_out_time, $this->global->timezone);
            $clockOut->setTimezone('UTC');
            $clockOut = $clockOut->format('H:i:s');
            $clockOut = $date.' '.$clockOut;
        }
        else{
            $clockOut = null;
        }

        $attendance = Attendance::where('user_id', $request->user_id)
            ->where(DB::raw('DATE(`clock_in_time`)'), $date)
            ->whereNull('clock_out_time')
            ->first();

        $clockInCount = Attendance::getTotalUserClockIn($date, $request->user_id);

        if(!is_null($attendance)){
            $attendance->update([
                'user_id' => $request->user_id,
                'clock_in_time' => $date.' '.$clockIn,
                'clock_in_ip' => $request->clock_in_ip,
                'clock_out_time' => $clockOut,
                'clock_out_ip' => $request->clock_out_ip,
                'working_from' => $request->working_from,
                'late' => $request->late,
                'half_day' => $request->half_day
            ]);
        }else{

            // Check maximum attendance in a day
            if($clockInCount < $this->attendanceSettings->clockin_in_day)
            {
                Attendance::create([
                    'user_id' => $request->user_id,
                    'clock_in_time' => $date.' '.$clockIn,
                    'clock_in_ip' => $request->clock_in_ip,
                    'clock_out_time' => $clockOut,
                    'clock_out_ip' => $request->clock_out_ip,
                    'working_from' => $request->working_from,
                    'late' => $request->late,
                    'half_day' => $request->half_day
                ]);
            }
            else{
                return Reply::error(__('messages.maxColckIn'));
            }
        }

        return Reply::success(__('messages.attendanceSaveSuccess'));
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Attendance::destroy($id);
        return Reply::success(__('messages.attendanceDelete'));
    }

    public function data(Request $request){

        $date = Carbon::createFromFormat('m/d/Y', $request->date)->format('Y-m-d');
        $attendances = Attendance::attendanceByDate($date);

        return DataTables::of($attendances)
            ->editColumn('id', function ($row) {
                return view('admin.attendance.attendance_list', ['row' => $row, 'global' => $this->global, 'maxAttandenceInDay' => $this->maxAttandenceInDay])->render();
            })
            ->rawColumns(['id'])
            ->removeColumn('name')
            ->removeColumn('clock_in_time')
            ->removeColumn('clock_out_time')
            ->removeColumn('image')
            ->removeColumn('attendance_id')
            ->removeColumn('working_from')
            ->removeColumn('late')
            ->removeColumn('half_day')
            ->removeColumn('clock_in_ip')
            ->removeColumn('job_title')
            ->removeColumn('total_clock_in')
            ->removeColumn('clock_in')
            ->make();
    }

    public function refreshCount($startDate = null, $endDate = null, $userId = null){

        $openDays = json_decode($this->attendanceSettings->office_open_days);
        $startDate = Carbon::createFromFormat('!Y-m-d', $startDate);
        $endDate = Carbon::createFromFormat('!Y-m-d', $endDate)->addDay(1); //addDay(1) is hack to include end date

        $totalWorkingDays = $startDate->diffInDaysFiltered(function(Carbon $date) use ($openDays){
            foreach($openDays as $day){
                if($date->dayOfWeek == $day){
                    return $date;
                }
            }
        }, $endDate);
        $daysPresent = Attendance::countDaysPresentByUser($startDate, $endDate, $userId);
        $daysLate = Attendance::countDaysLateByUser($startDate, $endDate, $userId);
        $halfDays = Attendance::countHalfDaysByUser($startDate, $endDate, $userId);
        $daysAbsent = (($totalWorkingDays - $daysPresent) < 0) ? '0' : ($totalWorkingDays - $daysPresent);
        $holidays = Count(Holiday::getHolidayByDates($startDate->format('Y-m-d'), $endDate->format('Y-m-d')));

        return Reply::dataOnly(['daysPresent' => $daysPresent, 'daysLate' => $daysLate, 'halfDays' => $halfDays, 'totalWorkingDays' => $totalWorkingDays, 'absentDays' => $daysAbsent, 'holidays' => $holidays]);

    }

    public function employeeData($startDate = null, $endDate = null, $userId = null){
        $ant = []; // Array For attendance Data indexed by similar date
        $dateWiseData = []; // Array For Combine Data

        $attendances = Attendance::userAttendanceByDate($startDate, $endDate, $userId);// Getting Attendance Data
        $holidays = Holiday::getHolidayByDates($startDate, $endDate); // Getting Holiday Data

        // Getting Leaves Data
        $leavesDates = Leave::where('user_id', $userId)
            ->where('leave_date', '>=', $startDate)
            ->where('leave_date', '<=', $endDate)
            ->where('status', 'approved')
            ->select('leave_date', 'reason')
            ->get()->keyBy('date')->toArray();

        $holidayData = $holidays->keyBy('holiday_date');
        $holidayArray = $holidayData->toArray();

        // Set Date as index for same date clock-ins
        foreach($attendances as $attand){
            $ant[$attand->clock_in_date][] = $attand; // Set attendance Data indexed by similar date
        }

        $endDate = Carbon::parse($endDate);
        $startDate = Carbon::parse($startDate)->subDay();

        // Set All Data in a single Array
        for($date = $endDate; $date->diffInDays($startDate) > 0; $date->subDay()){

            // Set default array for record
            $dateWiseData[$date->toDateString()] = [
                'holiday' =>false,
                'attendance' =>false,
                'leave' =>false
            ];

            // Set Holiday Data
            if(array_key_exists($date->toDateString(), $holidayArray)){
                $dateWiseData[$date->toDateString()]['holiday'] = $holidayData[$date->toDateString()];
            }

            // Set Attendance Data
            if(array_key_exists($date->toDateString(), $ant)){
                $dateWiseData[$date->toDateString()]['attendance'] = $ant[$date->toDateString()];
            }

            // Set Leave Data
            if(array_key_exists($date->toDateString(), $leavesDates)){
                $dateWiseData[$date->toDateString()]['leave'] = $leavesDates[$date->toDateString()];
            }
        }

        // Getting View data
        $view = view('admin.attendance.user_attendance',['dateWiseData' => $dateWiseData,'global' => $this->global])->render();

        return Reply::dataOnly(['status' => 'success', 'data' => $view]);
    }

    public function attendanceByDate(){
        return view('admin.attendance.by_date', $this->data);
    }


    public function byDateData(Request $request){
        $date = Carbon::createFromFormat('m/d/Y', $request->date)->format('Y-m-d');
        $attendances = Attendance::attendanceDate($date)->get();

        return DataTables::of($attendances)
            ->editColumn('id', function ($row) {
                return view('admin.attendance.attendance_date_list', ['row' => $row, 'global' => $this->global])->render();
            })
            ->rawColumns(['id'])
            ->removeColumn('name')
            ->removeColumn('clock_in_time')
            ->removeColumn('clock_out_time')
            ->removeColumn('image')
            ->removeColumn('attendance_id')
            ->removeColumn('working_from')
            ->removeColumn('late')
            ->removeColumn('half_day')
            ->removeColumn('clock_in_ip')
            ->removeColumn('job_title')
            ->make();
    }

    public function dateAttendanceCount(Request $request){
        $date = Carbon::createFromFormat('m/d/Y', $request->date)->format('Y-m-d');
        $checkHoliday = Holiday::checkHolidayByDate($date);
        $totalPresent = 0;
        $totalAbsent  = 0;
        $holiday  = 0;
        $holidayReason  = '';
        $totalEmployees = count(User::allEmployees());

        if(!$checkHoliday){
            $totalPresent = Attendance::where(DB::raw('DATE(`clock_in_time`)'), '=', $date)->count();
            $totalAbsent = ($totalEmployees-$totalPresent);
        }
        else{
            $holiday = 1;
            $holidayReason = $checkHoliday->occassion;
        }

        return Reply::dataOnly(['status' => 'success', 'totalEmployees' => $totalEmployees, 'totalPresent' => $totalPresent, 'totalAbsent' => $totalAbsent, 'holiday' => $holiday, 'holidayReason' => $holidayReason]);
    }

    public function checkHoliday(Request $request){
        $date = Carbon::createFromFormat('m/d/Y', $request->date)->format('Y-m-d');
        $checkHoliday = Holiday::checkHolidayByDate($date);
        return Reply::dataOnly(['status' => 'success', 'holiday' => $checkHoliday]);
    }

    // Attendance Detail Show
    public function attendanceDetail(Request $request){

        // Getting Attendance Data By User And Date
        $this->attendances =  Attendance::attedanceByUserAndDate($request->date, $request->userID);
        return view('admin.attendance.attendance-detail', $this->data)->render();
    }

    public function export($startDate = null, $endDate = null, $employee = null) {
       //
    }

}
