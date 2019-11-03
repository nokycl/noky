<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Helper\Reply;
use App\LanguageSetting;
use Illuminate\Http\Request;

class SuperAdminLanguageSettingsController extends SuperAdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.settings';
        $this->pageIcon = 'icon-settings';
    }

    public function index(){
        $this->languages = LanguageSetting::all();
        $this->languages = LanguageSetting::all();
        return view('super-admin.language-settings.index', $this->data);
    }

    public function update(Request $request,$id){
        $setting = LanguageSetting::findOrFail($request->id);
        $setting->status = $request->status;
        $setting->save();

        return Reply::success(__('messages.settingsUpdated'));
    }
}
