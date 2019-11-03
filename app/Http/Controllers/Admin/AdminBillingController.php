<?php

namespace App\Http\Controllers\Admin;

use App\GlobalSetting;
use App\Helper\Reply;
use App\Http\Requests\StripePayment\PaymentRequest;
use App\Module;
use App\Package;
use App\PaypalInvoice;
use App\StripeSetting;
use App\Subscription;
use App\Traits\StripeSettings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use PayPal\Api\Agreement;
use PayPal\Api\AgreementStateDescriptor;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Yajra\DataTables\Facades\DataTables;
use App\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CompanyUpdatedPlan;

class AdminBillingController extends AdminBaseController
{
    use StripeSettings;

    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.billing';
        $this->setStripConfigs();
        $this->pageIcon = 'icon-speedometer';
    }

    public function index() {
        $this->nextPaymentDate = '-';
        $this->previousPaymentDate = '-';
        $this->stripeSettings = StripeSetting::first();
        $this->subscription = Subscription::where('company_id', company()->id)->first();

        $stripe = DB::table("stripe_invoices")
            ->join('packages', 'packages.id', 'stripe_invoices.package_id')
            ->selectRaw('stripe_invoices.id , "Stripe" as method, stripe_invoices.pay_date as paid_on, "" as end_on ,stripe_invoices.next_pay_date, stripe_invoices.created_at')
            ->whereNotNull('stripe_invoices.pay_date')
            ->where('stripe_invoices.company_id', company()->id);

        $allInvoices = DB::table("paypal_invoices")
            ->join('packages', 'packages.id', 'paypal_invoices.package_id')
            ->selectRaw('paypal_invoices.id, "Paypal" as method, paypal_invoices.paid_on, paypal_invoices.end_on,paypal_invoices.next_pay_date,paypal_invoices.created_at')
            ->where('paypal_invoices.status', 'paid')
            ->where('paypal_invoices.company_id', company()->id)
            ->union($stripe)
            ->get();

        $this->firstInvoice = $allInvoices->sortByDesc(function ($temp, $key) {
            return Carbon::parse($temp->created_at)->getTimestamp();
        })->first();
        if($this->firstInvoice){
            if($this->firstInvoice->next_pay_date)
            {
                if($this->firstInvoice->method == 'Paypal'  && $this->firstInvoice !== null  &&  is_null($this->firstInvoice->end_on)){
                    $this->nextPaymentDate = Carbon::parse($this->firstInvoice->next_pay_date)->toFormattedDateString();
                }
                if($this->firstInvoice->method == 'Stripe' && $this->subscription !== null &&  is_null($this->subscription->ends_at)){
                    $this->nextPaymentDate = Carbon::parse($this->firstInvoice->next_pay_date)->toFormattedDateString();
                }
            }
            if($this->firstInvoice->paid_on)
            {
                $this->previousPaymentDate = Carbon::parse($this->firstInvoice->paid_on)-> toFormattedDateString();
            }
        }
        $this->paypalInvoice = PaypalInvoice::where('company_id', company()->id)->orderBy('created_at', 'desc')->first();

        return view('admin.billing.index', $this->data);

    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function data()
    {
        $stripe = DB::table("stripe_invoices")
            ->join('packages', 'packages.id', 'stripe_invoices.package_id')
            ->selectRaw('stripe_invoices.id ,stripe_invoices.invoice_id , packages.name as name, "Stripe" as method,stripe_invoices.amount, stripe_invoices.pay_date as paid_on ,stripe_invoices.next_pay_date,stripe_invoices.created_at')
            ->whereNotNull('stripe_invoices.pay_date')
            ->where('stripe_invoices.company_id', company()->id);

        $paypal = DB::table("paypal_invoices")
            ->join('packages', 'packages.id', 'paypal_invoices.package_id')
            ->selectRaw('paypal_invoices.id,"" as invoice_id, packages.name as name, "Paypal" as method ,paypal_invoices.total as amount, paypal_invoices.paid_on,paypal_invoices.next_pay_date, paypal_invoices.created_at')
            ->where('paypal_invoices.status', 'paid')
            ->where('paypal_invoices.company_id', company()->id)
             ->union($stripe)
             ->get();

        $paypalData = $paypal->sortByDesc(function ($temp, $key) {
            return Carbon::parse($temp->created_at)->getTimestamp();
        })->all();

        return DataTables::of($paypalData)
            ->editColumn('name', function ($row) {
                return ucfirst($row->name);
            })
            ->editColumn('paid_on', function ($row) {
                if(!is_null($row->paid_on)) {
                    return Carbon::parse($row->paid_on)->format('d-m-Y');
                }
                return '-';
            })
            ->editColumn('next_pay_date', function ($row) {
                if(!is_null($row->next_pay_date)) {
                    return Carbon::parse($row->next_pay_date)->format('d-m-Y');
                }
                return '-';
            })
            ->addColumn('action', function ($row) {
                if($row->method == 'Stripe' && $row->invoice_id){
                    return '<a href="'.route('admin.stripe.invoice-download', $row->invoice_id).'" class="btn btn-primary btn-circle waves-effect" data-toggle="tooltip" data-original-title="Download"><span></span> <i class="fa fa-download"></i></a>';
                }
                if($row->method == 'Paypal'){
                    return '<a href="'.route('admin.paypal.invoice-download', $row->id).'" class="btn btn-primary btn-circle waves-effect" data-toggle="tooltip" data-original-title="Download"><span></span> <i class="fa fa-download"></i></a>';
                }

                return '';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function packages() {
        $this->packages = Package::where('default', 'no')->get();
        $this->modulesData = Module::all();
        $this->stripeSettings = StripeSetting::first();
        $this->pageTitle = 'app.menu.packages';

        return view('admin.billing.package', $this->data);
    }

    public function payment(PaymentRequest $request) {
        $this->setStripConfigs();
        $token = $request->stripeToken;
        $email = $request->stripeEmail;
        $plan = Package::find($request->plan_id);

        $stripe = DB::table("stripe_invoices")
            ->join('packages', 'packages.id', 'stripe_invoices.package_id')
            ->selectRaw('stripe_invoices.id , "Stripe" as method, stripe_invoices.pay_date as paid_on ,stripe_invoices.next_pay_date')
            ->whereNotNull('stripe_invoices.pay_date')
            ->where('stripe_invoices.company_id', company()->id);

        $allInvoices = DB::table("paypal_invoices")
            ->join('packages', 'packages.id', 'paypal_invoices.package_id')
            ->selectRaw('paypal_invoices.id, "Paypal" as method, paypal_invoices.paid_on,paypal_invoices.next_pay_date')
            ->where('paypal_invoices.status', 'paid')
            ->whereNull('paypal_invoices.end_on')
            ->where('paypal_invoices.company_id', company()->id)
            ->union($stripe)
            ->get();

        $firstInvoice = $allInvoices->sortByDesc(function ($temp, $key) {
            return Carbon::parse($temp->paid_on)->getTimestamp();
        })->first();

        $subcriptionCancel = true;

        if(!is_null($firstInvoice) && $firstInvoice->method == 'Paypal'){
            $subcriptionCancel = $this->cancelSubscriptionPaypal();
        }

        if($subcriptionCancel){
            if($plan->max_employees < $this->company->employees->count() ) {
                return back()->withError('You can\'t downgrade package because your employees length is '.$this->company->employees->count().' and package max employees lenght is '.$plan->max_employees)->withInput();
            }

            $company = $this->company;
            $subscription = $company->subscriptions;

            try {
                if ($subscription->count() > 0) {
                    $company->subscription('main')->swap($plan->{'stripe_' . $request->type . '_plan_id'});
                }
                else {
                    $company->newSubscription('main', $plan->{'stripe_'.$request->type.'_plan_id'})->create($token, [
                        'email' => $email,
                    ]);
                }

                $company = $this->company;

                $company->package_id = $plan->id;
                $company->package_type = $request->type;

                // Set company status active
                $company->status = 'active';
                $company->licence_expire_on = null;

                $company->save();

                //send superadmin notification
                $superAdmin = User::whereNull('company_id')->get();
                Notification::send($superAdmin, new CompanyUpdatedPlan($company, $plan->id));

                \Session::flash('success', 'Payment successfully done.');
                return redirect(route('admin.billing'));

            } catch (\Exception $e) {
                return back()->withError($e->getMessage())->withInput();
            }
        }
//        return back()->withError('User not found by ID ' . $request->input('user_id'))->withInput();
    }

    public function download(Request $request, $invoiceId) {
        $this->setStripConfigs();
//        dd('test');
        return $this->company->downloadInvoice($invoiceId, [
            'vendor'  => $this->company->company_name,
            'product' => $this->company->package->name,
            'global' => GlobalSetting::first(),
            'logo' => $this->company->logo,
        ]);
    }

    public function cancelSubscriptionPaypal(){
        $credential = StripeSetting::first();
        $paypal_conf = Config::get('paypal');
        $api_context = new ApiContext(new OAuthTokenCredential($credential->paypal_client_id, $credential->paypal_secret));
        $api_context->setConfig($paypal_conf['settings']);

        $paypalInvoice = PaypalInvoice::whereNotNull('transaction_id')->whereNull('end_on')
            ->where('company_id', company()->id)->where('status', 'paid')->first();

        if($paypalInvoice){
            $agreementId = $paypalInvoice->transaction_id;
            $agreement = new Agreement();

            $agreement->setId($agreementId);
            $agreementStateDescriptor = new AgreementStateDescriptor();
            $agreementStateDescriptor->setNote("Cancel the agreement");

            try {
                $agreement->cancel($agreementStateDescriptor, $api_context);
                $cancelAgreementDetails = Agreement::get($agreement->getId(), $api_context);

                // Set subscription end date
                $paypalInvoice->end_on = Carbon::parse($cancelAgreementDetails->agreement_details->final_payment_date)->format('Y-m-d H:i:s');
                $paypalInvoice->save();

            } catch (Exception $ex) {
                //\Session::put('error','Some error occur, sorry for inconvenient');
                return false;
            }

            return true;
        }
    }

    public function cancelSubscription(Request $request) {
        $type = $request->type;

        if($type == 'paypal'){
            $credential = StripeSetting::first();
            $paypal_conf = Config::get('paypal');
            $api_context = new ApiContext(new OAuthTokenCredential($credential->paypal_client_id, $credential->paypal_secret));
            $api_context->setConfig($paypal_conf['settings']);

            $paypalInvoice = PaypalInvoice::whereNotNull('transaction_id')->whereNull('end_on')
                ->where('company_id', company()->id)->where('status', 'paid')->first();

            if($paypalInvoice){
                $agreementId = $paypalInvoice->transaction_id;
                $agreement = new Agreement();

                $agreement->setId($agreementId);
                $agreementStateDescriptor = new AgreementStateDescriptor();
                $agreementStateDescriptor->setNote("Cancel the agreement");

                try {
                    $agreement->cancel($agreementStateDescriptor, $api_context);
                    $cancelAgreementDetails = Agreement::get($agreement->getId(), $api_context);

                    // Set subscription end date
                    $paypalInvoice->end_on = Carbon::parse($cancelAgreementDetails->agreement_details->final_payment_date)->format('Y-m-d H:i:s');
                    $paypalInvoice->save();
                } catch (Exception $ex) {
                    \Session::put('error','Some error occur, sorry for inconvenient');
                    return Redirect::route('admin.billing.packages');
                }
            }

        }else{
            $this->setStripConfigs();
            $company = company();
            $subscription = Subscription::where('company_id', company()->id)->whereNull('ends_at')->first();
            if($subscription){
                try {
                    $company->subscription('main')->cancel();
                } catch (Exception $ex) {
                    \Session::put('error','Some error occur, sorry for inconvenient');
                    return Redirect::route('admin.billing.packages');
                }
            }
        }

        return Reply::redirect(route('admin.billing'), __('messages.unsubscribeSuccess'));
    }

    public function selectPackage(Request $request, $packageID) {
        $this->setStripConfigs();
        $this->package = Package::findOrFail($packageID);
        $this->comapny = company();
        $this->type    = $request->type;
        $this->stripeSettings = StripeSetting::first();
        if(is_null($this->superadmin->logo)) {
            $this->logo = asset('worksuite-logo.png');
        } else {
            $this->logo = asset('user-uploads/app-logo/'.$this->superadmin->logo) ;
        }
        return View::make('admin.billing.payment-method-show', $this->data);
    }
}
