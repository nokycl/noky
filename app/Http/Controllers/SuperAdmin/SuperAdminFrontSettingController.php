<?php

namespace App\Http\Controllers\SuperAdmin;

use App\FrontDetail;
use App\GlobalCurrency;
use App\GlobalSetting;
use App\Helper\Reply;
use App\Http\Requests\SuperAdmin\FrontSetting\UpdateFrontSettings;
use Illuminate\Support\Facades\File;

class SuperAdminFrontSettingController extends SuperAdminBaseController
{
    /**
     * SuperAdminInvoiceController constructor.
     */
    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'Front Settings';
        $this->pageIcon = 'icon-settings';
    }

    /**
     * Display edit form of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->global = GlobalSetting::first();

        $this->frontDetail = FrontDetail::first();
        $this->currencies = GlobalCurrency::all();

        return view('super-admin.front-settings.index', $this->data);
    }

    /**
     * @param UpdateFrontSettings $request
     * @param $id
     * @return array
     */
    public function update(UpdateFrontSettings $request, $id)
    {
        $setting = FrontDetail::findOrFail($id);

        $oldImage = $setting->image;

        $setting->header_title = $request->input('header_title');
        $setting->header_description = $request->input('header_description');
        $setting->feature_title = $request->input('feature_title');
        $setting->feature_description = $request->input('feature_description');
        $setting->price_title = $request->input('price_title');
        $setting->price_description = $request->input('price_description');
        $setting->address = $request->input('address');
        $setting->phone = $request->input('phone');
        $setting->email = $request->input('email');
        $setting->get_started_show = ($request->get_started_show == 'yes') ? 'yes' : 'no';
        $setting->sign_in_show = ($request->sign_in_show == 'yes') ? 'yes' : 'no';

        if ($request->hasFile('image')) {
            $setting->image = $request->image->hashName();
            $request->image->store('front-uploads');
            if($oldImage){ File::delete('front-uploads/'.$oldImage); }
        }

        $setting->save();

        return Reply::success(__('messages.uploadSuccess'));

    }
}
