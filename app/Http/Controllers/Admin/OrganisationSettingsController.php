<?php

namespace App\Http\Controllers\Admin;

use App\Currency;
use App\GlobalSetting;
use App\Helper\Reply;
use App\Http\Requests\Settings\UpdateOrganisationSettings;
use App\Setting;
use App\Traits\CurrencyExchange;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrganisationSettingsController extends AdminBaseController
{

    use CurrencyExchange;

    public function __construct() {
        parent:: __construct();
        $this->pageTitle = 'app.menu.accountSettings';
        $this->pageIcon = 'icon-settings';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->timezones = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);
        $setting          = Setting::where('id', company()->id)->first();
        $this->currencies = Currency::all();
        $this->dateObject = Carbon::now();

        if(!$setting){
            abort(404);
        }

        return view('admin.settings.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrganisationSettings $request, $id)
    {
        config(['filesystems.default' => 'local']);

        $setting = Setting::findOrFail($id);
        $setting->company_name = $request->input('company_name');
        $setting->company_email = $request->input('company_email');
        $setting->company_phone = $request->input('company_phone');
        $setting->website = $request->input('website');
        $setting->address = $request->input('address');
        $setting->currency_id = $request->input('currency_id');
        $setting->timezone = $request->input('timezone');
        $setting->locale = $request->input('locale');
        $setting->date_format = $request->input('date_format');
        $setting->time_format = $request->input('time_format');

        if ($request->hasFile('logo')) {
            $setting->logo = $request->logo->hashName();
            $request->logo->store('user-uploads/app-logo');
        }
        $setting->last_updated_by = $this->user->id;

        $setting->save();

        try {
            $this->updateExchangeRates();
        } catch (\Throwable $th) {
            //throw $th;
        }

        return Reply::redirect(route('admin.settings.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function changeLanguage(Request $request) {
        $setting = Setting::where('id', company()->id)->first();
        $setting->locale = $request->input('lang');

        $setting->last_updated_by = $this->user->id;
        $setting->save();

        return Reply::success('Language changed successfully.');
    }
}
