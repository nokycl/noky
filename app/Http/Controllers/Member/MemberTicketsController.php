<?php

namespace App\Http\Controllers\Member;

use App\Helper\Reply;
use App\Http\Requests\Tickets\StoreTicket;
use App\Http\Requests\Tickets\StoreTicketRequest;
use App\Http\Requests\Tickets\UpdateTicket;
use App\Http\Requests\Tickets\UpdateTicketRequest;
use App\Notifications\NewTicket;
use App\Ticket;
use App\TicketAgentGroups;
use App\TicketChannel;
use App\TicketGroup;
use App\TicketReply;
use App\TicketReplyTemplate;
use App\TicketTag;
use App\TicketTagList;
use App\TicketType;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Yajra\DataTables\Facades\DataTables;

class MemberTicketsController extends MemberBaseController
{

    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.tickets';
        $this->pageIcon = 'ti-ticket';
        $this->middleware(function ($request, $next) {
            if(!in_array('tickets',$this->user->modules)){
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
        $this->isAgent = TicketAgentGroups::where('agent_id', $this->user->id)->first();

        if($this->user->can('view_tickets')){
            $this->startDate = Carbon::today()->subWeek(1)->timezone($this->global->timezone)->format('m/d/Y');
            $this->endDate = Carbon::today()->timezone($this->global->timezone)->format('m/d/Y');
            $this->channels = TicketChannel::all();
            $this->groups = TicketGroup::all();
            $this->types = TicketType::all();
            return view('member.tickets.index-admin', $this->data);
        }
        return view('member.tickets.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if($this->user->can('add_tickets')){
            $this->groups = TicketGroup::all();
            $this->types = TicketType::all();
            $this->channels = TicketChannel::all();
            $this->templates = TicketReplyTemplate::all();
            $this->requesters = User::all();
            $this->lastTicket = Ticket::orderBy('id', 'desc')->first();
            return view('member.tickets.create-admin', $this->data);
        }
        return view('member.tickets.create', $this->data);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicketRequest $request)
    {
        $ticket = new Ticket();
        $ticket->subject = $request->subject;
        $ticket->user_id = $this->user->id;
        $ticket->save();

        //save first message
        $reply = new TicketReply();
        $reply->message = $request->description;
        $reply->ticket_id = $ticket->id;
        $reply->user_id = $this->user->id; //current logged in user
        $reply->save();


        //send admin notification
        Notification::send(User::allAdmins(), new NewTicket($ticket));

        return Reply::redirect(route('member.tickets.index'), __('messages.ticketAddSuccess'));
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
        if($this->user->can('add_tickets')){
            $this->ticket = Ticket::findOrFail($id);
            $this->groups = TicketGroup::all();
            $this->types = TicketType::all();
            $this->channels = TicketChannel::all();
            $this->templates = TicketReplyTemplate::all();
            return view('member.tickets.edit-admin', $this->data);
        }
        $this->ticket = Ticket::findOrFail($id);
        return view('member.tickets.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTicketRequest $request, $id)
    {
        $reply = new TicketReply();
        $reply->message = $request->message;
        $reply->ticket_id = $id;
        $reply->user_id = $this->user->id; //current logged in user
        $reply->save();
        $this->reply = $reply;
        $lastMessage = view('member.tickets.last-message', $this->data)->render();

        return Reply::successWithData(__('messages.ticketReplySuccess'), ['lastMessage' => $lastMessage]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        Ticket::destroy($id);
        return Reply::success(__('messages.ticketDeleteSuccess'));
    }

    public function data() {
        $tickets = Ticket::where('user_id', $this->user->id)->get();

        return DataTables::of($tickets)
            ->addColumn('action', function($row){
                return '<a href="' . route("member.tickets.edit", $row->id) . '" class="btn btn-info" ><i class="fa fa-eye"></i> '.__('modules.client.viewDetails').'</a>';
            })
            ->editColumn('subject', function($row){
                return ucfirst($row->subject);
            })
            ->editColumn('agent_id', function($row){
                if(!is_null($row->agent_id)){
                    return ucwords($row->agent->name);
                }
            })
            ->editColumn('status', function($row){
                if($row->status == 'open'){
                    return'<label class="label label-danger">'.$row->status.'</label>';
                }
                elseif($row->status == 'pending'){
                    return'<label class="label label-warning">'.$row->status.'</label>';
                }
                elseif($row->status == 'resolved'){
                    return'<label class="label label-info">'.$row->status.'</label>';
                }
                elseif($row->status == 'closed'){
                    return'<label class="label label-success">'.$row->status.'</label>';
                }
            })
            ->editColumn('created_at', function($row){
                return $row->created_at->format($this->global->date_format);
            })
            ->editColumn('updated_at', function($row){
                return $row->updated_at->format($this->global->date_format);
            })
            ->rawColumns(['action', 'status'])
            ->removeColumn('user_id')
            ->removeColumn('channel_id')
            ->removeColumn('type_id')
            ->removeColumn('deleted_at')
            ->make(true);
    }

    public function closeTicket($id){
        $ticket = Ticket::findOrFail($id);
        $ticket->status = 'closed';
        $ticket->save();

        $reply = new TicketReply();
        $reply->message = 'Ticket <strong>closed</strong> by '.ucwords($this->user->name);
        $reply->ticket_id = $id;
        $reply->user_id = $this->user->id; //current logged in user
        $reply->save();

        return Reply::redirect(route('member.tickets.index'), __('messages.ticketReplySuccess'));
    }

    public function reopenTicket($id){
        $ticket = Ticket::findOrFail($id);
        if(is_null($ticket->agent_id)){
            $ticket->status = 'open';
        }
        else{
            $ticket->status = 'pending';
        }
        $ticket->save();

        $reply = new TicketReply();
        $reply->message = 'Ticket <strong>reopend</strong> by '.ucwords($this->user->name);
        $reply->ticket_id = $id;
        $reply->user_id = $this->user->id; //current logged in user
        $reply->save();

        return Reply::redirect(route('member.tickets.index'), __('messages.ticketReplySuccess'));
    }

    public function adminData($startDate = null, $endDate = null, $agentId = null, $status = null, $priority = null, $channelId = null, $typeId = null) {
        $tickets = Ticket::select('*');

        if($startDate != 0){
            $tickets->where(DB::raw('DATE(`created_at`)'), '>=', $startDate);
        }

        if($endDate != 0){
            $tickets->where(DB::raw('DATE(`created_at`)'), '<=', $endDate);
        }

        if($agentId != 0){
            $tickets->where('agent_id', '=', $agentId);
        }

        if($status){
            $tickets->where('status', '=', $status);
        }

        if($priority){
            $tickets->where('priority', '=', $priority);
        }

        if($channelId != 0){
            $tickets->where('channel_id', '=', $channelId);
        }

        if($typeId != 0){
            $tickets->where('type_id', '=', $typeId);
        }

        $tickets->get();

        return DataTables::of($tickets)
            ->addColumn('action', function($row){
                $action = '<div class="btn-group m-r-10">
                <button aria-expanded="false" data-toggle="dropdown" class="btn btn-info btn-outline  dropdown-toggle waves-effect waves-light" type="button">Action <span class="caret"></span></button>
                <ul role="menu" class="dropdown-menu">';

                if($this->user->can('edit_tickets')){
                    $action.= '<li><a href="' . route("member.tickets.edit", $row->id) . '" ><i class="fa fa-pencil"></i> Edit</a></li>';
                }

                if($this->user->can('delete_tickets')){
                  $action.= '<li><a href="javascript:;" class="sa-params" data-ticket-id="' . $row->id . '"><i class="fa fa-times"></i> Delete</a></li>';
                }
                $action.= '</ul></div>';
                return $action;
            })
            ->addColumn('others', function($row){
                $others = '<ul style="list-style: none; padding: 0; font-size: small; line-height: 1.8em;">
                    <li><span class="font-bold">'.__('modules.tickets.agent').'</span>: '.(is_null($row->agent_id) ? "-" : ucwords($row->agent->name)).'</li>';
                if($row->status == 'open'){
                    $others.= '<li><span class="font-bold">'.__('app.status').'</span>: <label class="label label-danger">'.$row->status.'</label></li>';
                }
                elseif($row->status == 'pending'){
                    $others.= '<li><span class="font-bold">'.__('app.status').'</span>: <label class="label label-warning">'.$row->status.'</label></li>';
                }
                elseif($row->status == 'resolved'){
                    $others.= '<li><span class="font-bold">'.__('app.status').'</span>: <label class="label label-info">'.$row->status.'</label></li>';
                }
                elseif($row->status == 'closed'){
                    $others.= '<li><span class="font-bold">'.__('app.status').'</span>: <label class="label label-success">'.$row->status.'</label></li>';
                }
                $others.= '<li><span class="font-bold">'.__('modules.tasks.priority').'</span>: '.$row->priority.'</li>
                </ul>';
                return $others;
            })
            ->editColumn('subject', function($row){
                return ucfirst($row->subject);
            })
            ->editColumn('user_id', function($row){
                return ucwords($row->requester->name);
            })
            ->editColumn('created_at', function($row){
                return $row->created_at->format($this->global->date_format);
            })
            ->rawColumns(['others', 'action'])
            ->removeColumn('agent_id')
            ->removeColumn('channel_id')
            ->removeColumn('type_id')
            ->removeColumn('updated_at')
            ->removeColumn('deleted_at')
            ->make(true);
    }

    public function refreshCount($startDate = null, $endDate = null, $agentId = null, $status = null, $priority = null, $channelId = null, $typeId = null){
        $openTickets = Ticket::select(DB::raw('count(`id`) as total'))
            ->where('status', 'open')
            ->where(DB::raw('DATE(`updated_at`)'), '>=', $startDate)
            ->where(DB::raw('DATE(`updated_at`)'), '<=', $endDate);

        if($agentId != 0){
            $openTickets->where('agent_id', '=', $agentId);
        }

        if($status){
            $openTickets->where('status', '=', $status);
        }

        if($priority){
            $openTickets->where('priority', '=', $priority);
        }

        if($channelId != 0){
            $openTickets->where('channel_id', '=', $channelId);
        }

        if($typeId != 0){
            $openTickets->where('type_id', '=', $typeId);
        }

        $openTickets = $openTickets->first();

        $pendingTickets = Ticket::select(DB::raw('count(`id`) as total'))
            ->where('status', 'pending')
            ->where(DB::raw('DATE(`updated_at`)'), '>=', $startDate)
            ->where(DB::raw('DATE(`updated_at`)'), '<=', $endDate);

        if($agentId != 0){
            $pendingTickets->where('agent_id', '=', $agentId);
        }

        if($status){
            $pendingTickets->where('status', '=', $status);
        }

        if($priority){
            $pendingTickets->where('priority', '=', $priority);
        }

        if($channelId != 0){
            $pendingTickets->where('channel_id', '=', $channelId);
        }

        if($typeId != 0){
            $pendingTickets->where('type_id', '=', $typeId);
        }

        $pendingTickets = $pendingTickets->first();

        $resolvedTickets = Ticket::select(DB::raw('count(`id`) as total'))
            ->where('status', 'resolved')
            ->where(DB::raw('DATE(`updated_at`)'), '>=', $startDate)
            ->where(DB::raw('DATE(`updated_at`)'), '<=', $endDate);

        if($agentId != 0){
            $resolvedTickets->where('agent_id', '=', $agentId);
        }

        if($status){
            $resolvedTickets->where('status', '=', $status);
        }

        if($priority){
            $resolvedTickets->where('priority', '=', $priority);
        }

        if($channelId != 0){
            $resolvedTickets->where('channel_id', '=', $channelId);
        }

        if($typeId != 0){
            $resolvedTickets->where('type_id', '=', $typeId);
        }

        $resolvedTickets = $resolvedTickets->first();

        $closedTickets = Ticket::select(DB::raw('count(`id`) as total'))
            ->where('status', 'closed')
            ->where(DB::raw('DATE(`updated_at`)'), '>=', $startDate)
            ->where(DB::raw('DATE(`updated_at`)'), '<=', $endDate);

        if($agentId != 0){
            $closedTickets->where('agent_id', '=', $agentId);
        }

        if($status){
            $closedTickets->where('status', '=', $status);
        }

        if($priority){
            $closedTickets->where('priority', '=', $priority);
        }

        if($channelId != 0){
            $closedTickets->where('channel_id', '=', $channelId);
        }

        if($typeId != 0){
            $closedTickets->where('type_id', '=', $typeId);
        }

        $closedTickets = $closedTickets->first();

        $totalTickets = Ticket::select(DB::raw('count(`id`) as total'))
            ->where(DB::raw('DATE(`created_at`)'), '>=', $startDate)
            ->where(DB::raw('DATE(`created_at`)'), '<=', $endDate);

        if($agentId != 0){
            $totalTickets->where('agent_id', '=', $agentId);
        }

        if($status){
            $totalTickets->where('status', '=', $status);
        }

        if($priority){
            $totalTickets->where('priority', '=', $priority);
        }

        if($channelId != 0){
            $totalTickets->where('channel_id', '=', $channelId);
        }

        if($typeId != 0){
            $totalTickets->where('type_id', '=', $typeId);
        }

        $totalTickets = $totalTickets->first();

        $chartData = $this->getGraphData($startDate, $endDate, $agentId, $status, $priority, $channelId, $typeId);

        $chartData = json_encode($chartData);

        return Reply::dataOnly(['chartData' => $chartData, 'totalTickets' => $totalTickets->total, 'closedTickets' => $closedTickets->total, 'openTickets' => $openTickets->total, 'pendingTickets' => $pendingTickets->total, 'resolvedTickets' => $resolvedTickets->total]);

    }

    public function getGraphData($fromDate, $toDate, $agentId = null, $status = null, $priority = null, $channelId = null, $typeId = null)
    {
        $graphData = [];

        $total = [];
        $totalTickets = Ticket::where(DB::raw('DATE(`created_at`)'), '>=', $fromDate)
            ->where(DB::raw('DATE(`created_at`)'), '<=', $toDate)
            ->groupBy('created_at')
            ->orderBy('created_at', 'ASC');

        if($agentId != 0){
            $totalTickets->where('agent_id', '=', $agentId);
        }

        if($status){
            $totalTickets->where('status', '=', $status);
        }

        if($priority){
            $totalTickets->where('priority', '=', $priority);
        }

        if($channelId != 0){
            $totalTickets->where('channel_id', '=', $channelId);
        }

        if($typeId != 0){
            $totalTickets->where('type_id', '=', $typeId);
        }

        $totalTickets = $totalTickets->get([
            DB::raw('DATE_FORMAT(created_at,"%Y-%m-%d") as date'),
            DB::raw('count(id) as total')
        ]);

        foreach($totalTickets as $ticket) {
            if(!isset($total[$ticket->date])) {
                $total[$ticket->date] = 0;
            }
            $total[$ticket->date] += $ticket->total;
        }

        $resolved = [];
        $resolvedTickets = Ticket::where(DB::raw('DATE(`updated_at`)'), '>=', $fromDate)
            ->where(DB::raw('DATE(`updated_at`)'), '<=', $toDate)
            ->where(function($query){
                $query->where('status', 'closed');
                $query->orWhere('status', 'resolved');
            })
            ->groupBy('updated_at')
            ->orderBy('updated_at', 'ASC');

        if($agentId != 0){
            $resolvedTickets->where('agent_id', '=', $agentId);
        }

        if($status){
            $resolvedTickets->where('status', '=', $status);
        }

        if($priority){
            $resolvedTickets->where('priority', '=', $priority);
        }

        if($channelId != 0){
            $resolvedTickets->where('channel_id', '=', $channelId);
        }

        if($typeId != 0){
            $resolvedTickets->where('type_id', '=', $typeId);
        }

        $resolvedTickets = $resolvedTickets->get([
            DB::raw('DATE_FORMAT(updated_at,"%Y-%m-%d") as date'),
            DB::raw('count(id) as resolved')
        ]);

        foreach($resolvedTickets as $ticket) {
            if(!isset($resolved[$ticket->date])) {
                $resolved[$ticket->date] = 0;
            }
            $resolved[$ticket->date] += $ticket->resolved;
        }

        $unresolved = [];
        $unresolvedTickets = Ticket::where(DB::raw('DATE(`updated_at`)'), '>=', $fromDate)
            ->where(DB::raw('DATE(`updated_at`)'), '<=', $toDate)
            ->where(function($query){
                $query->where('status','<>', 'closed');
                $query->where('status','<>', 'resolved');
            })
            ->groupBy('updated_at')
            ->orderBy('updated_at', 'ASC');

        if($agentId != 0){
            $unresolvedTickets->where('agent_id', '=', $agentId);
        }

        if($status){
            $unresolvedTickets->where('status', '=', $status);
        }

        if($priority){
            $unresolvedTickets->where('priority', '=', $priority);
        }

        if($channelId != 0){
            $unresolvedTickets->where('channel_id', '=', $channelId);
        }

        if($typeId != 0){
            $unresolvedTickets->where('type_id', '=', $typeId);
        }

        $unresolvedTickets = $unresolvedTickets->get([
            DB::raw('DATE_FORMAT(updated_at,"%Y-%m-%d") as date'),
            DB::raw('count(id) as unresolved')
        ]);

        foreach($unresolvedTickets as $ticket) {
            if(!isset($unresolved[$ticket->date])) {
                $unresolved[$ticket->date] = 0;
            }
            $unresolved[$ticket->date] += $ticket->unresolved;
        }

        $dates = array_keys(array_merge(array_merge($total,$resolved),$unresolved));

        foreach ($dates as $date)
        {
            $graphData[] = [
                'date' =>  $date,
                'total' =>  isset($total[$date]) ? $total[$date] : 0,
                'resolved' =>  isset($resolved[$date]) ? $resolved[$date] : 0,
                'unresolved' =>  isset($unresolved[$date]) ? $unresolved[$date] : 0
            ];
        }

        usort($graphData, function ($a, $b){
            $t1 = strtotime($a['date']);
            $t2 = strtotime($b['date']);
            return $t1 - $t2;
        });

        return $graphData;
    }

    public function storeAdmin(StoreTicket $request) {
        $ticket = new Ticket();
        $ticket->subject = $request->subject;
        $ticket->status = $request->status;
        $ticket->user_id = $request->user_id;
        $ticket->agent_id = $request->agent_id;
        $ticket->type_id = $request->type_id;
        $ticket->priority = $request->priority;
        $ticket->channel_id = $request->channel_id;
        $ticket->save();

        //save first message
        $reply = new TicketReply();
        $reply->message = $request->description;
        $reply->ticket_id = $ticket->id;
        $reply->user_id = $this->user->id; //current logged in user
        $reply->save();

        // save tags
        $tags = $request->tags;

        if($tags){
            TicketTag::where('ticket_id', $ticket->id)->delete();
            foreach ($tags as $tag) {
                $tag = TicketTagList::firstOrCreate([
                    'tag_name' => $tag
                ]);


                TicketTag::create([
                    'tag_id' => $tag->id,
                    'ticket_id' => $ticket->id
                ]);
            }
        }

        //log search
        $this->logSearchEntry($ticket->id, 'Ticket: '.$ticket->subject, 'admin.tickets.edit');

        return Reply::redirect(route('member.tickets.index'), __('messages.ticketAddSuccess'));
    }

    public function updateAdmin(UpdateTicket $request, $id) {
        $ticket = Ticket::findOrFail($id);
        $ticket->status = $request->status;
        $ticket->agent_id = $request->agent_id;
        $ticket->type_id = $request->type_id;
        $ticket->priority = $request->priority;
        $ticket->channel_id = $request->channel_id;
        $ticket->save();

        $lastMessage = null;

        if($request->message != ''){
            //save first message
            $reply = new TicketReply();
            $reply->message = $request->message;
            $reply->ticket_id = $ticket->id;
            $reply->user_id = $this->user->id; //current logged in user
            $reply->save();

            // save tags
            $tags = $request->tags;
            if($tags){
                TicketTag::where('ticket_id', $ticket->id)->delete();

                foreach ($tags as $tag) {
                    $tag = TicketTagList::firstOrCreate([
                        'tag_name' => $tag
                    ]);


                    TicketTag::create([
                        'tag_id' => $tag->id,
                        'ticket_id' => $ticket->id
                    ]);
                }

            }
            $this->reply = $reply;
            $lastMessage = view('member.tickets.last-message', $this->data)->render();
        }

        return Reply::successWithData(__('messages.ticketReplySuccess'), ['lastMessage' => $lastMessage]);
    }



}
