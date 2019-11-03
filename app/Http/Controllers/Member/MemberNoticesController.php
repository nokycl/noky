<?php

namespace App\Http\Controllers\Member;

use App\Helper\Reply;
use App\Http\Requests\Notice\StoreNotice;
use App\Notice;
use App\Notifications\NewNotice;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Yajra\DataTables\Facades\DataTables;

class MemberNoticesController extends MemberBaseController
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

    public function index() {
        if(!$this->user->can('view_notice')){
            abort(403);
        }
        $this->notices = Notice::orderBy('id', 'desc')->limit(10)->get();
        return view('member.notices.index', $this->data);
    }

    public function show($id)
    {
        if(!$this->user->can('view_notice')){
            abort(403);
        }
        $this->notice = Notice::findOrFail($id);
        return view('member.notices.show', $this->data);
    }

    public function create()
    {
        if(!$this->user->can('add_notice')){
            abort(403);
        }
        return view('member.notices.create', $this->data);
    }

    public function store(StoreNotice $request)
    {
        $notice = new Notice();
        $notice->heading = $request->heading;
        $notice->description = $request->description;
        $notice->save();

        $users = User::allEmployees();

        Notification::send($users, new NewNotice($notice));

        $this->logSearchEntry($notice->id, 'Notice: '.$notice->heading, 'admin.notices.edit');

        return Reply::redirect(route('member.notices.index'), __('messages.noticeAdded'));
    }

    public function edit($id)
    {
        if(!$this->user->can('edit_notice')){
            abort(403);
        }
        $this->notice = Notice::findOrFail($id);
        return view('member.notices.edit', $this->data);
    }

    public function update(StoreNotice $request, $id)
    {
        $notice = Notice::findOrFail($id);
        $notice->heading = $request->heading;
        $notice->description = $request->description;
        $notice->save();

        Notification::send(User::allEmployees(), new NewNotice($notice));

        return Reply::redirect(route('member.notices.index'), __('messages.noticeUpdated'));
    }

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
                $action = '';

                if($this->user->can('view_notice')){
                    $action.= '<a href="javascript:;" class="btn btn-success btn-circle noticeShow"
                      data-toggle="tooltip" data-notice-id="' . $row->id . '" data-original-title="View"><i class="fa fa-search" aria-hidden="true"></i></a> ';
                }

                if($this->user->can('edit_notice')){
                    $action.= '<a href="'.route('member.notices.edit', [$row->id]).'" class="btn btn-info btn-circle"
                      data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                }

                if($this->user->can('delete_notice')) {
                    $action .= ' <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                      data-toggle="tooltip" data-user-id="' . $row->id . '" data-original-title="Delete"><i class="fa fa-times" aria-hidden="true"></i></a>';
                }
                return $action;
            })
            ->editColumn(
                'created_at',
                function ($row) {
                    return Carbon::parse($row->created_at)->format($this->global->date_format);
                }
            )
            ->make(true);
    }
}
