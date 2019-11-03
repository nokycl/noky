<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Helper\Reply;
use App\Http\Requests\SuperAdmin\Stripe\UpdateRequest;
use App\PaypalInvoice;
use App\StripeSetting;
use App\Subscription;
use App\Traits\StripeSettings;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use PayPal\Api\Agreement;
use PayPal\Api\AgreementStateDescriptor;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;


class SuperAdminStripeSettingsController extends SuperAdminBaseController
{
    use StripeSettings;

    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.paymentGatewayCredential';
        $this->pageIcon = 'icon-settings';
    }

    public function index() {
        $this->credentials = StripeSetting::first();
        return view('super-admin.stripe-settings.index', $this->data);
    }

    public function update(UpdateRequest $request) {
        $stripe = StripeSetting::first();
        // Save Stripe Credentials
        $stripe->api_key = $request->api_key;
        $stripe->api_secret = $request->api_secret;
        $stripe->webhook_key = $request->webhook_key;

        // Save Paypal Credentials
        $stripe->paypal_client_id = $request->paypal_client_id;
        $stripe->paypal_secret    = $request->paypal_secret;

        // Save Active Sattus
        if($request->has('paypal_status') && $request->paypal_status == 'on'){
            $stripe->paypal_status = 'active';
        }  else{
            $stripe->paypal_status = 'inactive';
        }

        if($request->has('stripe_status') && $request->stripe_status == 'on'){
            $stripe->stripe_status = 'active';
        }
        else{
            $stripe->stripe_status = 'inactive';
        }

        $stripe->save();

        return Reply::success(__('messages.settingsUpdated'));
    }

    public function changePaymentMethod(UpdateRequest $request) {

        $stripe = StripeSetting::first();
        $type = $request->type;
        $bothUncheck = $request->bothUncheck;

        // Stripe unsubscribe
        if($type == 'stripe'){
            $this->setStripConfigs();
            $subscriptions = Subscription::with('company')
                ->whereNull('ends_at')->get();

            if(sizeof($subscriptions) > 0){
                foreach($subscriptions as $subscription){
                    $company = $subscription->company;
                    $company->subscription('main')->cancel();
                }
            }
        }

        // Paypal unsubscribe
        if($type == 'paypal'){
            $credential = StripeSetting::first();
            $paypal_conf = Config::get('paypal');
            $api_context = new ApiContext(new OAuthTokenCredential($credential->paypal_client_id, $credential->paypal_secret));
            $api_context->setConfig($paypal_conf['settings']);

            $paypalInvoice = PaypalInvoice::with('company')
                ->whereNotNull('transaction_id')
                ->whereNull('end_on')
                ->where('status', 'paid')->get();

            if(sizeof($paypalInvoice) > 0){
                foreach($paypalInvoice as $inv){
                    $agreementId = $inv->transaction_id;
                    $agreement = new Agreement();

                    $agreement->setId($agreementId);
                    $agreementStateDescriptor = new AgreementStateDescriptor();
                    $agreementStateDescriptor->setNote("Cancel the agreement");

                    try {
                        $agreement->cancel($agreementStateDescriptor, $api_context);
                        $cancelAgreementDetails = Agreement::get($agreement->getId(), $api_context);

                        // Set subscription end date
                        $inv->end_on = Carbon::parse($cancelAgreementDetails->agreement_details->final_payment_date)->format('Y-m-d H:i:s');
                        $inv->save();
                    } catch (Exception $ex) {

                    }
                }
            }
        }

        // Save Active Status
        $stripe->stripe_status = ($type === 'stripe') && $bothUncheck == 'false' ? 'active' : 'inactive';
        $stripe->paypal_status = ($type === 'paypal') && $bothUncheck == 'false' ? 'active' : 'inactive';
        $stripe->save();

        return Reply::success(__('messages.settingsUpdated'));
    }

}
