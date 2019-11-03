<?php

namespace App\Http\Controllers\Member;

use App\ClientDetails;
use App\Helper\Reply;
use App\Http\Requests\Admin\Client\StoreClientRequest;
use App\Http\Requests\Admin\Client\UpdateClientRequest;
use App\Invoice;
use App\Notifications\NewUser;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class MemberClientsController extends MemberBaseController
{
    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.clients';
        $this->pageIcon = 'icon-people';

        $this->middleware(function ($request, $next) {
            if (!in_array('clients',$this->user->modules)) {
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
        if(!$this->user->can('view_clients')){
            abort(403);
        }
        $this->clients = User::allClients();

        return view('member.clients.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!$this->user->can('add_clients')){
            abort(403);
        }
        $client = new ClientDetails();
        $this->fields = $client->getCustomFieldGroupsWithFields()->fields;
        return view('member.clients.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClientRequest $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->mobile = $request->input('mobile');
        $user->save();

        if($user->id){
            $client = new ClientDetails();
            $client->user_id = $user->id;
            $client->company_name = $request->company_name;
            $client->address = $request->address;
            $client->website = $request->website;
            $client->note = $request->note;
            $client->skype = $request->skype;
            $client->facebook = $request->facebook;
            $client->twitter = $request->twitter;
            $client->linkedin = $request->linkedin;
            $client->gst_number = $request->gst_number;
            $client->save();
        }

        // To add custom fields data
        if ($request->get('custom_fields_data')) {
            $client->updateCustomFieldData($request->get('custom_fields_data'));
        }

        $user->attachRole(3);


        if($this->emailSetting[0]->send_email == 'yes'){
            //send welcome email notification
            $user->notify(new NewUser($request->input('password')));
        }

        //log search
        $this->logSearchEntry($user->id, $user->name, 'admin.clients.edit');
        $this->logSearchEntry($user->id, $user->email, 'admin.clients.edit');
        if(!is_null($client->company_name)){
            $this->logSearchEntry($user->id, $client->company_name, 'admin.clients.edit');
        }

        return Reply::redirect(route('member.clients.index'),__('messages.clientAdded'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!$this->user->can('view_clients')){
            abort(403);
        }

        $this->client = User::withoutGlobalScope('active')->findOrFail($id);
        return view('member.clients.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!$this->user->can('edit_clients')){
            abort(403);
        }

        $this->userDetail = User::withoutGlobalScope('active')->findOrFail($id);
        $this->clientDetail = ClientDetails::where('user_id', '=', $this->userDetail->id)->first();

        if(!is_null($this->clientDetail)){
            $this->clientDetail = $this->clientDetail->withCustomFields();
            $this->fields = $this->clientDetail->getCustomFieldGroupsWithFields()->fields;
        }

        return view('member.clients.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientRequest $request, $id)
    {
        $user = User::withoutGlobalScope('active')->findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if($request->password != ''){
            $user->password = Hash::make($request->input('password'));
        }
        $user->mobile = $request->input('mobile');
        $user->save();

        $client = ClientDetails::where('user_id', '=', $user->id)->first();
        if(empty($client)){
            $client = new ClientDetails();
            $client->user_id = $user->id;
        }
        $client->company_name = $request->company_name;
        $client->address = $request->address;
        $client->website = $request->website;
        $client->note = $request->note;
        $client->skype = $request->skype;
        $client->facebook = $request->facebook;
        $client->twitter = $request->twitter;
        $client->linkedin = $request->linkedin;
        $client->gst_number = $request->gst_number;
        $client->save();

        // To add custom fields data
        if ($request->get('custom_fields_data')) {
            $client->updateCustomFieldData($request->get('custom_fields_data'));
        }

        return Reply::redirect(route('member.clients.index'),__('messages.clientUpdated'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return Reply::success(__('messages.clientDeleted'));
    }

    public function data(Request $request)
    {
        $users = User::withoutGlobalScope('active')->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->leftJoin('client_details', 'users.id', '=', 'client_details.user_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select('users.id', 'users.name', 'client_details.company_name', 'users.email', 'users.created_at')
            ->where('roles.name', 'client')
            ->groupBy('users.id');
        if($request->startDate !== null && $request->startDate != 'null' && $request->startDate != ''){
            $users = $users->where(DB::raw('DATE(users.`created_at`)'), '>=', $request->startDate);
        }

        if($request->endDate !== null && $request->endDate != 'null' && $request->endDate != ''){
            $users = $users->where(DB::raw('DATE(users.`created_at`)'), '<=', $request->endDate);
        }
        if($request->client != 'all' && $request->client != ''){
            $users = $users->where('users.id', $request->client);
        }

        $users = $users->get();

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $action = '';
                if($this->user->can('edit_clients')){
                    $action.= '<a href="'.route('member.clients.edit', [$row->id]).'" class="btn btn-info btn-circle"
                      data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                }

                if($this->user->can('view_clients')){
                    $action.= ' <a href="' . route('member.clients.projects', [$row->id]) . '" class="btn btn-success btn-circle"
                      data-toggle="tooltip" data-original-title="View Client Details"><i class="fa fa-search" aria-hidden="true"></i></a>';
                }

                if($this->user->can('delete_clients')){
                    $action.= ' <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                      data-toggle="tooltip" data-user-id="'.$row->id.'" data-original-title="Delete"><i class="fa fa-times" aria-hidden="true"></i></a>';
                }

                return $action;

            })
            ->editColumn(
                'name',
                function ($row) {
                    return '<a href="'.route('member.clients.projects', $row->id).'">'.ucfirst($row->name).'</a>';
                }
            )
            ->editColumn(
                'created_at',
                function ($row) {
                    return Carbon::parse($row->created_at)->format($this->global->date_format);
                }
            )
            ->rawColumns(['name', 'action'])
            ->make(true);
    }

    public function showProjects($id) {


        $this->client = User::withoutGlobalScope('active')->findOrFail($id);
        return view('member.clients.projects', $this->data);
    }

    public function showInvoices($id) {
        if(!$this->user->can('view_invoices')){
            abort(403);
        }
        $this->client = User::withoutGlobalScope('active')->findOrFail($id);
        $this->invoices = Invoice::join('projects', 'projects.id', '=', 'invoices.project_id')
            ->join('currencies', 'currencies.id', '=', 'invoices.currency_id')
            ->join('users', 'users.id', '=', 'projects.client_id')
            ->select('invoices.invoice_number', 'invoices.total', 'currencies.currency_symbol', 'invoices.issue_date', 'invoices.id')
            ->where('projects.client_id', $id)
            ->get();

        return view('member.clients.invoices', $this->data);
    }

    public function export() {
        $rows = User::leftJoin('client_details', 'users.id', '=', 'client_details.user_id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.mobile',
                'client_details.company_name',
                'client_details.address',
                'client_details.website',
                'users.created_at'
            )
            ->get();

        // Initialize the array which will be passed into the Excel
        // generator.
        $exportArray = [];

        // Define the Excel spreadsheet headers
        $exportArray[] = ['ID', 'Name','Email','Mobile','Company Name', 'Address', 'Website', 'Created at'];

        // Convert each member of the returned collection into an array,
        // and append it to the payments array.
        foreach ($rows as $row) {
            $exportArray[] = $row->toArray();
        }

        // Generate and return the spreadsheet
        Excel::create('clients', function($excel) use ($exportArray) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Clients');
            $excel->setCreator('Worksuite')->setCompany($this->companyName);
            $excel->setDescription('clients file');

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
