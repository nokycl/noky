<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Reply;
use App\ModuleSetting;
use Illuminate\Http\Request;

class ModuleSettingsController extends AdminBaseController
{
    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.moduleSettings';
        $this->pageIcon = 'icon-settings';
    }

    public function index(Request $request) {

        $moduleInPackage = (array)json_decode(company()->package->module_in_package);
        if($request->has('type')){
            if($request->get('type') == 'employee'){
                $this->modulesData = ModuleSetting::where('type', 'employee')->whereIn('module_name', $moduleInPackage)->get();
                $this->type = 'employee';
            }
            elseif($request->get('type') == 'client'){
                $this->modulesData = ModuleSetting::where('type', 'client')->whereIn('module_name', $moduleInPackage)->get();
                $this->type = 'client';
            }
        }
        else{
            $this->modulesData = ModuleSetting::where('type', 'admin')->whereIn('module_name', $moduleInPackage)->get();
            $this->type = 'admin';
        }

        return view('admin.module-settings.index', $this->data);
    }

    public function update(Request $request){
        $setting = ModuleSetting::findOrFail($request->id);
        $setting->status = $request->status;
        $setting->save();

        return Reply::success(__('messages.settingsUpdated'));
    }
}
