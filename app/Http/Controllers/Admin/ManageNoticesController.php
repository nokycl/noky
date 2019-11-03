<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Reply;
use App\Http\Requests\Notice\StoreNotice;
use App\Notice;
use App\Notifications\NewNotice;
use App\Team;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ManageNoticesController extends AdminBaseController
{

    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.noticeBoard';
        $this->pageIcon = 'ti-layout-media-overlay';
        $this->middleware(function ($request, $next) {
            if (!in_array('notices',$this->user->modules)) {
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
        return view('admin.notices.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->teams = Team::all();
        return view('admin.notices.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNotice $request)
    {
        $notice = new Notice();
        $notice->heading = $request->heading;
        $notice->description = $request->description;
        $notice->save();

        if($request->team_id != ''){
            $users = User::teamUsers($request->team_id);
        }
        else{
            $users = User::allEmployees();
        }

        Notification::send($users, new NewNotice($notice));

        $this->logSearchEntry($notice->id, 'Notice: '.$notice->heading, 'admin.notices.edit');

        return Reply::redirect(route('admin.notices.index'), __('messages.noticeAdded'));
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
        $this->notice = Notice::findOrFail($id);
        return view('admin.notices.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreNotice $request, $id)
    {
        $notice = Notice::findOrFail($id);
        $notice->heading = $request->heading;
        $notice->description = $request->description;
        $notice->save();

        Notification::send(User::allEmployees(), new NewNotice($notice));

        return Reply::redirect(route('admin.notices.index'), __('messages.noticeUpdated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Notice::destroy($id);
        return Reply::success(__('messages.noticeDeleted'));
    }

    public function data(Request $request)
    {
        $notice = Notice::select('id','heading', 'created_at');
        if($request->startDate !== null && $request->startDate != 'null' && $request->startDate != ''){
            $notice = $notice->where(DB::raw('DATE(notices.`created_at`)'), '>=', $request->startDate);
        }

        if($request->endDate !== null && $request->endDate != 'null' && $request->endDate != ''){
            $notice = $notice->where(DB::raw('DATE(notices.`created_at`)'), '<=', $request->endDate);
        }

        $notice = $notice->get();

        return DataTables::of($notice)
            ->addColumn('action', function($row){
                return '<a href="'.route('admin.notices.edit', [$row->id]).'" class="btn btn-info btn-circle"
                      data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                      <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                      data-toggle="tooltip" data-user-id="'.$row->id.'" data-original-title="Delete"><i class="fa fa-times" aria-hidden="true"></i></a>';
            })
            ->editColumn(
                'created_at',
                function ($row) {
                    return Carbon::parse($row->created_at)->format($this->global->date_format);
                }
            )
            ->make(true);
    }

    public function export($startDate, $endDate) {

        $notice = Notice::select('id','heading', 'created_at');
        if($startDate !== null && $startDate != 'null' && $startDate != ''){
            $notice = $notice->where(DB::raw('DATE(notices.`created_at`)'), '>=', $startDate);
        }

        if($endDate !== null && $endDate != 'null' && $endDate != ''){
            $notice = $notice->where(DB::raw('DATE(notices.`created_at`)'), '<=', $endDate);
        }

        $attributes =  ['created_at'];

        $notice = $notice->get()->makeHidden($attributes);

        // Initialize the array which will be passed into the Excel
        // generator.
        $exportArray = [];

        // Define the Excel spreadsheet headers
        $exportArray[] = ['ID', 'Notice','Date'];

        // Convert each member of the returned collection into an array,
        // and append it to the payments array.
        foreach ($notice as $row) {
            $exportArray[] = $row->toArray();
        }

        // Generate and return the spreadsheet
        Excel::create('notice', function($excel) use ($exportArray) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Notice');
            $excel->setCreator('Worksuite')->setCompany($this->companyName);
            $excel->setDescription('notice file');

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
