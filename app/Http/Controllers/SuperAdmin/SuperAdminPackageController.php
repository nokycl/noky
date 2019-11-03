<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Company;
use App\Helper\Reply;

use App\Http\Requests\SuperAdmin\Packages\DeleteRequest;
use App\Http\Requests\SuperAdmin\Packages\StoreRequest;
use App\Http\Requests\SuperAdmin\Packages\UpdateRequest;
use App\Module;
use App\ModuleSetting;
use App\Package;
use Yajra\DataTables\Facades\DataTables;


class SuperAdminPackageController extends SuperAdminBaseController
{
    /**
     * AdminProductController constructor.
     */
    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.packages';
        $this->pageIcon = 'icon-basket';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->totalPackages = Package::count();
        return view('super-admin.packages.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->modules = Module::all();
        return view('super-admin.packages.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $package = new Package();
        $this->storeAndUpdate($package, $request, 'add');

        return Reply::redirect(route('super-admin.packages.index'), 'Package successfully added.');
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
        $this->package = Package::find($id);
        $this->modules = Module::all();

        return view('super-admin.packages.edit', $this->data);
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
        $package = Package::find($id);
        $this->storeAndUpdate($package, $request, 'edit');

        return Reply::redirect(route('super-admin.packages.index'), 'Package updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteRequest $request, $id)
    {
        $companies = Company::where('package_id', $id)->get();
        if($companies){
            $defaultPackage = Package::where('default', 'yes')->first();
            if($defaultPackage){
                foreach($companies as $company){
                    ModuleSetting::where('company_id', $company->id)->delete();

                    $moduleInPackage = (array)json_decode($defaultPackage->module_in_package);
                    $clientModules = ['projects', 'tickets', 'invoices', 'estimates', 'events', 'tasks', 'messages'];
                    if($moduleInPackage){
                        foreach ($moduleInPackage as $module) {

                            if(in_array($module, $clientModules)){
                                $moduleSetting = new ModuleSetting();
                                $moduleSetting->company_id = $company->id;
                                $moduleSetting->module_name = $module;
                                $moduleSetting->status = 'active';
                                $moduleSetting->type = 'client';
                                $moduleSetting->save();
                            }

                            $moduleSetting = new ModuleSetting();
                            $moduleSetting->company_id = $company->id;
                            $moduleSetting->module_name = $module;
                            $moduleSetting->status = 'active';
                            $moduleSetting->type = 'employee';
                            $moduleSetting->save();

                            $moduleSetting = new ModuleSetting();
                            $moduleSetting->company_id = $company->id;
                            $moduleSetting->module_name = $module;
                            $moduleSetting->status = 'active';
                            $moduleSetting->type = 'admin';
                            $moduleSetting->save();
                        }
                    }
                    $company->package_id = $defaultPackage->id;
                    $company->save();
                }
            }
        }

        Package::destroy($id);
        return Reply::success('Package deleted successfully.');
    }

    /**
     * @return mixed
     */
    public function data()
    {
        $packages = Package::where('default','!=','trial')->get();
        return Datatables::of($packages)
            ->addColumn('action', function($row){
                $action = '';
                if($row->default == 'no'){
                    $action = ' <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                      data-toggle="tooltip" data-user-id="'.$row->id.'" data-original-title="Delete"><i class="fa fa-times" aria-hidden="true"></i></a>';
                }

                return '<a href="'.route('super-admin.packages.edit', [$row->id]).'" class="btn btn-info btn-circle"
                      data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>'.$action;
            })
            ->editColumn('name', function ($row) {
                    return ucfirst($row->name);
            })
            ->editColumn('module_in_package', function ($row) {
                $modules = json_decode($row->module_in_package);
//                dd($modules);
                $string = '<ul>';
                if ($modules)
                {
                    foreach ($modules as $module) {
                        $string .= '<li>' . $module . '</li>';
                    }
                 }
                else{
                    return 'No module selected';
                }
                $string .= '<ul>';
                return $string;
            })

            ->rawColumns(['action', 'module_in_package'])
            ->make(true);
    }

    public function storeAndUpdate( $package, $request, $type) {

        $package->name = $request->name;
        $package->description = $request->description;
        $package->annual_price = $request->annual_price;
        $package->monthly_price = $request->monthly_price;
        $package->max_employees = $request->max_employees;
        $package->module_in_package = json_encode($request->module_in_package);
        $package->stripe_annual_plan_id = $request->stripe_annual_plan_id;
        $package->stripe_monthly_plan_id = $request->stripe_monthly_plan_id;
        $package->currency_id = $this->global->currency_id;

        $package->save();

        ModuleSetting::whereNull('company_id')->delete();

        if($type == 'edit'){
            if($request->has('module_in_package')){
                $companies = Company::where('package_id', $package->id)->get();

                foreach($companies as $company){
                    ModuleSetting::where('company_id', $company->id)->delete();

                    $moduleInPackage = (array)json_decode($package->module_in_package);
                    $clientModules = ['projects', 'tickets', 'invoices', 'estimates', 'events', 'tasks', 'messages'];
                    foreach ($moduleInPackage as $module) {

                        if(in_array($module, $clientModules)){
                            $moduleSetting = new ModuleSetting();
                            $moduleSetting->company_id = $company->id;
                            $moduleSetting->module_name = $module;
                            $moduleSetting->status = 'active';
                            $moduleSetting->type = 'client';
                            $moduleSetting->save();
                        }

                        $moduleSetting = new ModuleSetting();
                        $moduleSetting->company_id = $company->id;
                        $moduleSetting->module_name = $module;
                        $moduleSetting->status = 'active';
                        $moduleSetting->type = 'employee';
                        $moduleSetting->save();

                        $moduleSetting = new ModuleSetting();
                        $moduleSetting->company_id = $company->id;
                        $moduleSetting->module_name = $module;
                        $moduleSetting->status = 'active';
                        $moduleSetting->type = 'admin';
                        $moduleSetting->save();
                    }
                }
            }
        }

    }
}
