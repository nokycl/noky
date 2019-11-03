<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Reply;
use App\Http\Requests\CommonRequest;
use App\Http\Requests\Lead\StoreRequest;
use App\Http\Requests\Lead\UpdateRequest;
use App\Lead;
use App\LeadFollowUp;
use App\LeadSource;
use App\LeadStatus;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class LeadController extends AdminBaseController
{
    public function __construct() {
        parent::__construct();
        $this->pageIcon = 'user-follow';
        $this->pageTitle = 'app.menu.lead';
        $this->middleware(function ($request, $next) {
            if(!in_array('leads',$this->user->modules)){
                abort(403);
            }
            return $next($request);
        });

    }

    public function index() {
        $this->totalLeads = Lead::all();

        $this->totalClientConverted = $this->totalLeads->filter(function ($value, $key) {
            return $value->client_id != null;
        });
        $this->totalLeads = Lead::all()->count();
        $this->totalClientConverted = $this->totalClientConverted->count();

        $this->pendingLeadFollowUps = LeadFollowUp::where(\DB::raw('DATE(next_follow_up_date)'), '<=', Carbon::today()->format('Y-m-d'))
            ->join('leads', 'leads.id', 'lead_follow_up.lead_id')
            ->where('leads.next_follow_up', 'yes')
            ->get();
        $this->pendingLeadFollowUps = $this->pendingLeadFollowUps->count();
        return view('admin.lead.index', $this->data);
    }

    public function show($id) {
        $this->lead = Lead::findOrFail($id);
        return view('admin.lead.show', $this->data);
    }

    public function data(CommonRequest $request, $id = null) {
        $currentDate = Carbon::today()->format('Y-m-d');
        $lead = Lead::select('leads.id','leads.client_id','leads.next_follow_up','client_name','company_name','lead_status.type as statusName','status_id', 'leads.created_at', 'lead_sources.type as source', \DB::raw("(select next_follow_up_date from lead_follow_up where lead_id = leads.id and leads.next_follow_up  = 'yes' and DATE(next_follow_up_date) >= {$currentDate} ORDER BY next_follow_up_date desc limit 1) as next_follow_up_date"))
           ->leftJoin('lead_status', 'lead_status.id', 'leads.status_id')
           ->leftJoin('lead_sources', 'lead_sources.id', 'leads.source_id');
            if($request->followUp != 'all' && $request->followUp != ''){
                $lead = $lead->leftJoin('lead_follow_up', 'lead_follow_up.lead_id', 'leads.id')
                    ->where('leads.next_follow_up', 'yes')
                    ->where('lead_follow_up.next_follow_up_date', '<', $currentDate);
            }
            if($request->client != 'all' && $request->client != ''){
                if($request->client == 'lead'){
                    $lead = $lead->whereNull('client_id');
                }
                else{
                    $lead = $lead->whereNotNull('client_id');
                }
            }

        $lead = $lead->GroupBy('leads.id')->get();

        return DataTables::of($lead)
            ->addColumn('action', function($row){

                if($row->client_id == null || $row->client_id == ''){
                    $follow = '<li><a href="'.route('admin.clients.create').'/'.$row->id.'"><i class="fa fa-user"></i> '.__('modules.lead.changeToClient').'</a></li>';
                    if($row->next_follow_up == 'yes'){
                        $follow .= '<li onclick="followUp('.$row->id.')"><a href="javascript:;"><i class="fa fa-thumbs-up"></i> '.__('modules.lead.addFollowUp').'</a></li>';
                    }
                }
                   else{
                       $follow = '';
                   }
                $action = '<div class="btn-group m-r-10">
                <button aria-expanded="false" data-toggle="dropdown" class="btn btn-info btn-outline  dropdown-toggle waves-effect waves-light" type="button">'.__('modules.lead.action').'  <span class="caret"></span></button>
                <ul role="menu" class="dropdown-menu">
                    <li><a href="'.route('admin.leads.show', $row->id).'"><i class="fa fa-search"></i> '.__('modules.lead.view').'</a></li>
                    <li><a href="'.route('admin.leads.edit', $row->id).'"><i class="fa fa-edit"></i> '.__('modules.lead.edit').'</a></li>
                    <li><a href="javascript:;" class="sa-params" data-user-id="'.$row->id.'"><i class="fa fa-trash "></i> '.__('app.delete').'</a></li>
                     '.$follow.'   
                </ul>
              </div>';
               return $action;
            })
            ->addColumn('status', function($row){
                $status = LeadStatus::all();
                $statusLi = '';
                foreach($status as $st) {
                    if($row->status_id == $st->id){
                        $selected = 'selected';
                    }else{
                        $selected = '';
                    }
                    $statusLi .= '<option '.$selected.' value="'.$st->id.'">'.$st->type.'</option>';
                }

                $action = '<select class="form-control" name="statusChange" onchange="changeStatus( '.$row->id.', this.value)">
                    '.$statusLi.'
                </select>';


                return $action;
            })
            ->editColumn('client_name', function($row){
                if($row->client_id != null && $row->client_id != ''){
                    $label = '<label class="label label-success">'.__('app.client').'</label>';
                }
                else{
                    $label = '<label class="label label-info">'.__('app.lead').'</label>';
                }

                return '<a href="'.route('admin.leads.show', $row->id).'">'.$row->client_name.'</a><div class="clearfix"></div> '.$label;   
            })
            ->editColumn('next_follow_up_date', function($row) use($currentDate){
                if($row->next_follow_up_date != null && $row->next_follow_up_date != ''){
                    $date = Carbon::parse($row->next_follow_up_date)->format($this->global->date_format);
                }
                else{
                    $date = '--';
                }
                if($row->next_follow_up_date < $currentDate && $date != '--'){
                    return $date. ' <label class="label label-danger">'.__('app.pending').'</label>';
                }

                return $date;
            })
            ->editColumn('created_at', function($row){
                return $row->created_at->format($this->global->date_format);
            })
            ->removeColumn('status_id')
            ->removeColumn('client_id')
            ->removeColumn('source')
            ->removeColumn('next_follow_up')
            ->removeColumn('statusName')
            ->addIndexColumn()
            ->rawColumns(['status','action','client_name','next_follow_up_date'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->sources = LeadSource::all();
        $this->status = LeadStatus::all();
        return view('admin.lead.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $lead = new Lead();
        $lead->company_name = $request->company_name;
        $lead->website = $request->website;
        $lead->address = $request->address;
        $lead->client_name = $request->client_name;
        $lead->client_email = $request->client_email;
        $lead->mobile = $request->mobile;
        $lead->note = $request->note;
        $lead->next_follow_up = $request->next_follow_up;
        $lead->save();

        //log search
        $this->logSearchEntry($lead->id, $lead->client_name, 'admin.leads.show');
        $this->logSearchEntry($lead->id, $lead->client_email, 'admin.leads.show');
        if(!is_null($lead->company_name)){
            $this->logSearchEntry($lead->id, $lead->company_name, 'admin.leads.show');
        }

        return Reply::redirect(route('admin.leads.index'), __('messages.LeadAddedUpdated'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->lead = Lead::findOrFail($id);
        $this->sources = LeadSource::all();
        $this->status = LeadStatus::all();
        return view('admin.lead.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $lead = Lead::findOrFail($id);
        $lead->company_name = $request->company_name;
        $lead->website = $request->website;
        $lead->address = $request->address;
        $lead->client_name = $request->client_name;
        $lead->client_email = $request->client_email;
        $lead->mobile = $request->mobile;
        $lead->note = $request->note;
        $lead->status_id = $request->status;
        $lead->source_id = $request->source;
        $lead->next_follow_up = $request->next_follow_up;
        $lead->save();

        return Reply::redirect(route('admin.leads.index'), __('messages.LeadUpdated'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Lead::destroy($id);
        return Reply::success(__('messages.LeadDeleted'));
    }

    /**
     * @param CommonRequest $request
     * @return array
     */
    public function changeStatus(CommonRequest $request)
    {
        $lead = Lead::findOrFail($request->leadID);
        $lead->status_id = $request->statusID;
        $lead->save();

        return Reply::success(__('messages.leadStatusChangeSuccess'));
    }

    /**
     * @param $leadID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function followUpCreate($leadID){
        $this->leadID = $leadID;
        return view('admin.lead.follow_up', $this->data);
    }

    /**
     * @param CommonRequest $request
     * @return array
     */
    public function followUpStore(\App\Http\Requests\FollowUp\StoreRequest $request){

        $followUp = new LeadFollowUp();
        $followUp->lead_id = $request->lead_id;
        $followUp->next_follow_up_date = Carbon::parse($request->next_follow_up_date)->format('Y-m-d');;
        $followUp->remark = $request->remark;
        $followUp->save();
        $this->lead = Lead::findOrFail($request->lead_id);

        $view = view('admin.lead.followup.task-list-ajax', $this->data)->render();

        return Reply::successWithData(__('messages.leadFollowUpAddedSuccess'), ['html' => $view]);
    }

    public function followUpShow($leadID){
        $this->leadID = $leadID;
        $this->lead = Lead::findOrFail($leadID);
        return view('admin.lead.followup.show', $this->data);
    }

    public function editFollow($id)
    {
        $this->follow = LeadFollowUp::findOrFail($id);
        $view = view('admin.lead.followup.edit', $this->data)->render();
        return Reply::dataOnly(['html' => $view]);
    }

    public function UpdateFollow(\App\Http\Requests\FollowUp\StoreRequest $request)
    {
        $followUp = LeadFollowUp::findOrFail($request->id);
        $followUp->lead_id = $request->lead_id;
        $followUp->next_follow_up_date = Carbon::parse($request->next_follow_up_date)->format('Y-m-d');;
        $followUp->remark = $request->remark;
        $followUp->save();

        $this->lead = Lead::findOrFail($request->lead_id);

        $view = view('admin.lead.followup.task-list-ajax', $this->data)->render();

        return Reply::successWithData(__('messages.leadFollowUpUpdatedSuccess'), ['html' => $view]);
    }

    public function followUpSort(CommonRequest $request)
    {
        $leadId = $request->leadId;
        $this->sortBy = $request->sortBy;

        $this->lead = Lead::findOrFail($leadId);
        if($request->sortBy == 'next_follow_up_date'){
            $order = "asc";
        }
        else{
            $order = "desc";
        }

        $follow = LeadFollowUp::where('lead_id', $leadId)->orderBy($request->sortBy, $order);


        $this->lead->follow = $follow->get();

        $view = view('admin.lead.followup.task-list-ajax', $this->data)->render();

        return Reply::successWithData(__('messages.followUpFilter'), ['html' => $view]);
    }


    public function export($followUp, $client) {
        $currentDate = Carbon::today()->format('Y-m-d');
        $lead = Lead::select('leads.id','client_name','website','client_email','company_name','lead_status.type as statusName','leads.created_at', 'lead_sources.type as source', \DB::raw("(select next_follow_up_date from lead_follow_up where lead_id = leads.id and leads.next_follow_up  = 'yes' and DATE(next_follow_up_date) >= {$currentDate} ORDER BY next_follow_up_date asc limit 1) as next_follow_up_date"))
            ->leftJoin('lead_status', 'lead_status.id', 'leads.status_id')
            ->leftJoin('lead_sources', 'lead_sources.id', 'leads.source_id');
        if($followUp != 'all' && $followUp != ''){
            $lead = $lead->leftJoin('lead_follow_up', 'lead_follow_up.lead_id', 'leads.id')
                ->where('leads.next_follow_up', 'yes')
                ->where('lead_follow_up.next_follow_up_date', '<', $currentDate);
        }
        if($client != 'all' && $client != ''){
            if($client == 'lead'){
                $lead = $lead->whereNull('client_id');
            }
            else{
                $lead = $lead->whereNotNull('client_id');
            }
        }

        $lead = $lead->GroupBy('leads.id')->get();

        // Initialize the array which will be passed into the Excel
        // generator.
        $exportArray = [];

        // Define the Excel spreadsheet headers
        $exportArray[] = ['ID', 'Client Name', 'Website', 'Email','Company Name','Status','Created On', 'Source', 'Next Follow Up Date'];

        // Convert each member of the returned collection into an array,
        // and append it to the payments array.
        foreach ($lead as $row) {
            $exportArray[] = $row->toArray();
        }

        // Generate and return the spreadsheet
        Excel::create('leads', function($excel) use ($exportArray) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Leads');
            $excel->setCreator('Worksuite')->setCompany($this->companyName);
            $excel->setDescription('leads file');

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
