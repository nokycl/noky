<?php

namespace App\Http\Controllers\Front;

use App\Feature;
use App\Helper\Reply;
use App\Http\Requests\Front\ContactUs\ContactUsRequest;
use App\Invoice;
use App\InvoiceItems;
use App\Notifications\ContactUsMail;
use App\Package;
use App\Setting;
use App\User;
use Illuminate\Support\Facades\Notification;
use App\Module;
use App\InvoiceSetting;
use App\OfflinePaymentMethod;
use App\PaymentGatewayCredentials;

class HomeController extends FrontBaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            \Illuminate\Support\Facades\DB::connection()->getPdo();
        } catch (\Exception $e) {
            return redirect('install');
        }
        
        $this->pageTitle = 'Home';
        $this->packages = Package::where('default', 'no')->get();

        $features = Feature::all();
        $this->featureWithImages = $features->filter(function ($value, $key) {
            return $value->type == 'image';
        });

        $this->featureWithIcons = $features->filter(function ($value, $key) {
            return $value->type == 'icon';
        });
        $this->packageFeatures = Module::get()->pluck('module_name')->toArray();

        return view('front.home', $this->data);
    }

    public function contactUs(ContactUsRequest $request) {

        $this->pageTitle = 'Contact Us';
        $superAdmins = User::where('super_admin', '1')->get();

        $this->table = '<table><tbody style="color:#0000009c;">
        <tr>
            <td><p>Name : </p></td>
            <td><p>'.ucwords($request->name).'</p></td>
        </tr>
        <tr>
            <td style="font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box;min-width: 98px;vertical-align: super;"><p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Message : </p></td>
            <td><p>'.$request->message.'</p></td>
        </tr>
</tbody>
        
</table><br>';

        Notification::route('mail', $this->detail->email)
            ->notify(new ContactUsMail($this->data, $request->email));


        return Reply::success('Thanks for contacting us. We will catch you soon.');
    }

    public function invoice($id)
    {
        $this->pageTitle = __('app.menu.clients');
        $this->pageIcon = 'icon-people';

        $this->invoice = Invoice::whereRaw('md5(id) = ?', $id)->firstOrFail();
        $this->paidAmount = $this->invoice->getPaidAmount();

        if($this->invoice->discount > 0){
            if($this->invoice->discount_type == 'percent'){
                $this->discount = (($this->invoice->discount/100)*$this->invoice->sub_total);
            }
            else{
                $this->discount = $this->invoice->discount;
            }
        }
        else{
            $this->discount = 0;
        }

        $taxList = array();

        $items = InvoiceItems::whereNotNull('tax_id')
            ->where('invoice_id', $this->invoice->id)
            ->get();

        foreach ($items as $item){
            if(!isset($taxList[$item->tax->tax_name.': '.$item->tax->rate_percent.'%'])){
                $taxList[$item->tax->tax_name.': '.$item->tax->rate_percent.'%'] = ($item->tax->rate_percent/100)*$item->amount;
            }
            else{
                $taxList[$item->tax->tax_name.': '.$item->tax->rate_percent.'%'] = $taxList[$item->tax->tax_name.': '.$item->tax->rate_percent.'%'] + (($item->tax->rate_percent/100)*$item->amount);
            }
        }

        $this->taxes = $taxList;

        $this->settings = Setting::findOrFail(1);
        $this->credentials = PaymentGatewayCredentials::first();
        $this->methods = OfflinePaymentMethod::activeMethod();
        $this->invoiceSetting = InvoiceSetting::first();

        return view('invoice', [
            'companyName' => $this->settings->company_name,
            'pageTitle' => $this->pageTitle,
            'pageIcon' => $this->pageIcon,
            'global' => $this->settings,
            'setting' => $this->settings,
            'settings' => $this->settings,
            'invoice' => $this->invoice,
            'paidAmount' => $this->paidAmount,
            'discount' => $this->discount,
            'credentials' => $this->credentials,
            'taxes' => $this->taxes,
            'methods' => $this->methods,
            'invoiceSetting' => $this->invoiceSetting,
        ]);
    }

}

