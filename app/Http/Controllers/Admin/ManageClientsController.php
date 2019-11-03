<?php

namespace App\Http\Controllers\Admin;

use App\ClientDetails;
use App\Helper\Reply;
use App\Http\Requests\Admin\Client\StoreClientRequest;
use App\Http\Requests\Admin\Client\UpdateClientRequest;
use App\Invoice;
use App\Lead;
use App\Notifications\NewUser;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ManageClientsController extends AdminBaseController
{

    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.clients';
        $this->pageIcon = 'icon-people';
        $this->middleware(function ($request, $next) {
            if(!in_array('clients',$this->user->modules)){
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
        $this->clients = User::allClients();
        $this->totalClients = count($this->clients);

        return view('admin.clients.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($leadID = null)
    {
        if($leadID){
            $this->leadDetail = Lead::findOrFail($leadID);
        }

        $client = new ClientDetails();
        $this->fields = $client->getCustomFieldGroupsWithFields()->fields;
        return view('admin.clients.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClientRequest $request)
    {
        $existing_user = User::withoutGlobalScope('company')->select('id', 'email')->where('email', $request->input('email'))->first();

        // if no user found create new user with random password
        if(!$existing_user) {
            $password = str_random(8);
            // create new user
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($password);
            $user->mobile = $request->input('mobile');

            $user->save();
            
            // attach role
            $role = Role::where('name', 'client')->first();
            $user->attachRole($role->id);

            //log search
            $this->logSearchEntry($user->id, $request->name, 'admin.clients.edit');
            $this->logSearchEntry($user->id, $request->email, 'admin.clients.edit');

            
            if($request->has('lead')){
                $lead = Lead::findOrFail($request->lead);
                $lead->client_id = $user->id;
                $lead->save();
                
                return Reply::redirect(route('admin.leads.index'), __('messages.leadClientChangeSuccess'));
            }
        }
        
        $existing_client_count = ClientDetails::select('id', 'email', 'company_id')->where([
                'email' => $request->input('email')
            ])->count();
        
        if($existing_client_count === 0) {
            $client = new ClientDetails();
            $client->user_id = $existing_user ? $existing_user->id : $user->id;
            $client->name = $request->input('name');
            $client->email = $request->input('email');
            $client->mobile = $request->input('mobile');
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

            // attach role
            if ($existing_user) {
                $role = Role::where('name', 'client')->where('company_id', $client->company_id)->first();
                $existing_user->attachRole($role->id);
            }

            // To add custom fields data
            if ($request->get('custom_fields_data')) {
                $client->updateCustomFieldData($request->get('custom_fields_data'));
            }

            // log search
            if(!is_null($client->company_name)){
                $user_id = $existing_user ? $existing_user->id : $user->id;
                $this->logSearchEntry($user_id, $client->company_name, 'admin.clients.edit');
            }
        }
        else {
            return Reply::error('Provided email is already registered. Try with different email.');
        }

        if(!$existing_user && $this->emailSetting[0]->send_email == 'yes'){
            //send welcome email notification
            $user->notify(new NewUser($password));
        }

        return Reply::redirect(route('admin.clients.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->client = User::withoutGlobalScope('active')->findOrFail($id);
        return view('admin.clients.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->userDetail = ClientDetails::join('users', 'client_details.user_id', '=', 'users.id')
            ->where('client_details.id', $id)
            ->select('client_details.id', 'client_details.name', 'client_details.email', 'client_details.user_id', 'client_details.mobile', 'users.status', 'users.login')
            ->first();

        $this->clientDetail = ClientDetails::where('user_id', '=', $this->userDetail->user_id)->first();
        
        if(!is_null($this->clientDetail)){
            $this->clientDetail = $this->clientDetail->withCustomFields();
            $this->fields = $this->clientDetail->getCustomFieldGroupsWithFields()->fields;
        }

        return view('admin.clients.edit', $this->data);
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
        $client = ClientDetails::find($id);

        // if(empty($client)){
        //     $client = new ClientDetails();
        //     $client->user_id = $user->id;
        // }

        $client->company_name = $request->company_name;
        $client->name = $request->input('name');
        $client->email = $request->input('email');
        $client->mobile = $request->input('mobile');
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

        $user = User::withoutGlobalScopes(['active', 'company'])->findOrFail($client->user_id);
        // if($request->password != ''){
        //     $user->password = Hash::make($request->input('password'));
        // }
        $user->status = $request->input('status');
        $user->save();

        return Reply::redirect(route('admin.clients.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
            $clients_count = ClientDetails::withoutGlobalScope('company')->where('user_id', $id)->count();

            if($clients_count > 1) {
                $client_builder = ClientDetails::where('user_id', $id);
                $client = $client_builder->first();

                $user_builder = User::where('id', $id);
                $user = $user_builder->first();
                if ($user) {
                    $other_client = $client_builder->withoutGlobalScope('company')
                    ->where('company_id', '!=', $client->company_id)
                    ->first();

                    request()->request->add(['company_id' => $other_client->company_id]);
                    
                    $user->save();
                }
                $role = Role::where('name', 'client')->first();
                $user_role = $user_builder->withoutGlobalScope('company')->first();
                $user_role->detachRoles([$role->id]);

                $client->delete();
            }
            else {
                // $client = ClientDetails::where('user_id', $id)->first();
                // $client->delete();

                User::destroy($id);
            }
        DB::commit();
        return Reply::success(__('messages.clientDeleted'));
    }

    public function data(Request $request)
    {
        $users = ClientDetails::join('users', 'client_details.user_id', '=', 'users.id')
            ->select('client_details.id', 'client_details.user_id', 'client_details.name', 'client_details.company_name', 'client_details.email', 'client_details.created_at', 'users.status')->groupBy('client_details.id');

            if($request->startDate !== null && $request->startDate != 'null' && $request->startDate != ''){
                $users = $users->where(DB::raw('DATE(users.`created_at`)'), '>=', $request->startDate);
            }

            if($request->endDate !== null && $request->endDate != 'null' && $request->endDate != ''){
                $users = $users->where(DB::raw('DATE(users.`created_at`)'), '<=', $request->endDate);
            }
            if($request->status != 'all' && $request->status != ''){
                $users = $users->where('users.status', $request->status);
            }

            if($request->client != 'all' && $request->client != ''){
                $users = $users->where('users.id', $request->client);
            }

            $users = $users->get();
//            dd($users);

        return DataTables::of($users)
            ->addColumn('action', function($row){
                return '<a href="'.route('admin.clients.edit', [$row->id]).'" class="btn btn-info btn-circle"
                      data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                      <a href="' . route('admin.clients.projects', [$row->user_id]) . '" class="btn btn-success btn-circle"
                      data-toggle="tooltip" data-original-title="View Client Details"><i class="fa fa-search" aria-hidden="true"></i></a>

                      <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                      data-toggle="tooltip" data-user-id="'.$row->user_id.'" data-original-title="Delete"><i class="fa fa-times" aria-hidden="true"></i></a>';
            })
            ->editColumn(
                'name',
                function ($row) {
                    return '<a href="'.route('admin.clients.projects', $row->user_id).'">'.ucfirst($row->name).'</a>';
                }
            )
            ->editColumn(
                'created_at',
                function ($row) {
                    return Carbon::parse($row->created_at)->format($this->global->date_format);
                }
            )
            ->editColumn(
                'status',
                function ($row) {
                    if($row->status == 'active'){
                        return '<label class="label label-success">'.__('app.active').'</label>';
                    }
                    else{
                        return '<label class="label label-danger">'.__('app.deactive').'</label>';
                    }
                }
            )
            ->addIndexColumn()
            ->rawColumns(['name', 'action', 'status'])
            ->make(true);
    }

    public function showProjects($id) {
//        dd('test');
        $this->client = User::fromQuery('SELECT users.id, client_details.company_id FROM users JOIN client_details ON client_details.user_id = users.id WHERE client_details.user_id = '.$id)->first();
//dd($this->client);
        $this->clientDetail = ClientDetails::where('user_id', '=', $this->client->id)->first();
        
        if(!is_null($this->clientDetail)){
            $this->clientDetail = $this->clientDetail->withCustomFields();
            $this->fields = $this->clientDetail->getCustomFieldGroupsWithFields()->fields;
        }

        return view('admin.clients.projects', $this->data);
    }

    public function showInvoices($id) {
        $this->client = User::fromQuery('SELECT users.id, client_details.company_id FROM users JOIN client_details ON client_details.user_id = users.id WHERE client_details.id = '.$id)->first();

        $this->clientDetail = ClientDetails::where('user_id', '=', $this->client->id)->first();

        if(!is_null($this->clientDetail)){
            $this->clientDetail = $this->clientDetail->withCustomFields();
            $this->fields = $this->clientDetail->getCustomFieldGroupsWithFields()->fields;
        }

        $this->invoices = Invoice::join('projects', 'projects.id', '=', 'invoices.project_id')
            ->join('currencies', 'currencies.id', '=', 'invoices.currency_id')
            ->join('users', 'users.id', '=', 'projects.client_id')
            ->select('invoices.invoice_number', 'invoices.total', 'currencies.currency_symbol', 'invoices.issue_date', 'invoices.id')
            ->where('projects.client_id', $id)
            ->get();
        return view('admin.clients.invoices', $this->data);
    }

    public function export($status, $client) {
        $rows = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->withoutGlobalScope('active')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->where('roles.name', 'client')
            ->where('roles.company_id', company()->id)
            ->leftJoin('client_details', 'users.id', '=', 'client_details.user_id')
            ->select(
                'users.id',
                'client_details.name',
                'client_details.email',
                'client_details.mobile',
                'client_details.company_name',
                'client_details.address',
                'client_details.website',
                'client_details.created_at'
            )
            ->where('client_details.company_id', company()->id);

            if($status != 'all' && $status != ''){
                $rows = $rows->where('users.status', $status);
            }

            if($client != 'all' && $client != ''){
                $rows = $rows->where('users.id', $client);
            }

            $rows = $rows->get()->makeHidden(['image']);

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
