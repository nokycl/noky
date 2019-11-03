<?php

namespace App\Http\Controllers;

use App\ClientPayment;
use App\Company;
use App\Invoice;
use App\Notifications\CompanyPurchasedPlan;
use App\Notifications\CompanyUpdatedPlan;
use App\Payment;
use App\PaymentGatewayCredentials;
use App\StripeInvoice;
use App\Subscription;
use App\Traits\StripeSettings;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Routing\Controller;
use Stripe\Stripe;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    use StripeSettings;

    public function verifyStripeWebhook(Request $request)
    {
        $this->setStripConfigs();

        $stripeCredentials = PaymentGatewayCredentials::first();

        Stripe::setApiKey(config('services.stripe.secret'));

        // You can find your endpoint's secret in your webhook settings
        $endpoint_secret = $stripeCredentials->stripe_webhook_secret;

        $payload = @file_get_contents("php://input");
        $sig_header = $_SERVER["HTTP_STRIPE_SIGNATURE"];
        $event = null;

        try {
            $event = Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            return response('Invalid Payload', 400);
        } catch(\Stripe\Error\SignatureVerification $e) {
            // Invalid signature
            return response('Invalid signature', 400);
        }

        $payload = json_decode($request->getContent(), true);

        $eventId = $payload['id'];
        $eventCount = ClientPayment::where('event_id', $eventId)->count();

        // Do something with $event
        if ($payload['type'] == 'invoice.payment_succeeded' && $eventCount == 0)
        {
              $planId = $payload['data']['object']['lines']['data'][0]['plan']['id'];
              $customerId = $payload['data']['object']['customer'];
              $amount = $payload['data']['object']['lines']['data'][0]['amount'];
              $transactionId = $payload['data']['object']['lines']['data'][0]['id'];
              $invoiceId = $payload['data']['object']['lines']['data'][0]['plan']['metadata']['invoice_id'];

              $previousClientPayment = ClientPayment::where('plan_id', $planId)
                                                    ->where('transaction_id', $transactionId)
//                                                    ->where('customer_id', $customerId)
                                                    ->whereNull('event_id')
                                                    ->first();
              if($previousClientPayment)
              {
                  $previousClientPayment->event_id = $eventId;
                  $previousClientPayment->save();
              } else {
                  $invoice = Invoice::find($invoiceId);

                  $payment = new Payment();
                  $payment->project_id = $invoice->project_id;
                  $payment->currency_id = $invoice->currency_id;
                  $payment->amount = $amount/100;
                  $payment->event_id = $eventId;
                  $payment->gateway = 'Stripe';
                  $payment->paid_on = Carbon::now();
                  $payment->status = 'complete';
                  $payment->save();
              }
        }

        return response('Webhook Handled', 200);
    }

    public function saveInvoices(Request $request) {
        $this->setStripConfigs();
        $stripeCredentials = config('services.stripe.webhook_secret');

        Stripe::setApiKey(config('services.stripe.secret'));

        // You can find your endpoint's secret in your webhook settings
        $endpoint_secret = $stripeCredentials;

        $payload = @file_get_contents("php://input");
        $sig_header = $_SERVER["HTTP_STRIPE_SIGNATURE"];
        $event = null;

        try {
            $event = Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            return response('Invalid Payload', 400);
        } catch(\Stripe\Error\SignatureVerification $e) {
            // Invalid signature
            return response('Invalid signature', 400);
        }

        $payload = json_decode($request->getContent(), true);
        \Log::debug($payload);
        // Do something with $event
        if ($payload['type'] == 'invoice.payment_succeeded')
        {
            $planId = $payload['data']['object']['lines']['data'][0]['plan']['id'];
            $customerId = $payload['data']['object']['customer'];
            $amount = $payload['data']['object']['amount_paid'];
            $transactionId = $payload['data']['object']['lines']['data'][0]['id'];
//            $invoiceId = $payload['data']['object']['number'];
            $invoiceRealId = $payload['data']['object']['id'];

            $company = Company::where('stripe_id', $customerId)->first();

            $package = \App\Package::where(function ($query) use($planId) {
                $query->where('stripe_annual_plan_id', '=', $planId)
                    ->orWhere('stripe_monthly_plan_id', '=', $planId);
            })->first();

            if($company) {
                // Store invoice details
                $stripeInvoice = new StripeInvoice();
                $stripeInvoice->company_id = $company->id;
                $stripeInvoice->invoice_id = $invoiceRealId;
                $stripeInvoice->transaction_id = $transactionId;
                $stripeInvoice->amount = $amount/100;
                $stripeInvoice->package_id = $package->id;
                $stripeInvoice->pay_date = \Carbon\Carbon::now()->format('Y-m-d');
                $stripeInvoice->next_pay_date = \Carbon\Carbon::createFromTimeStamp($company->upcomingInvoice()->next_payment_attempt)->format('Y-m-d');

                $stripeInvoice->save();

                // Change company status active after payment
                $company->status = 'active';
                $company->save();

//                dd($stripeInvoice);

                $superAdmin = User::whereNull('company_id')->get();
                $lastInvoice = StripeInvoice::where('company_id')->first();

                if($lastInvoice){
                    Notification::send($superAdmin, new CompanyUpdatedPlan($company, $package->id));
                }else{
                    Notification::send($superAdmin, new CompanyPurchasedPlan($company, $package->id));
                }

                return response('Webhook Handled', 200);

            }

            return response('Customer not found', 200);
        }

        elseif ($payload['type'] == 'invoice.payment_failed') {
            $customerId = $payload['data']['object']['customer'];

            $company = Company::where('stripe_id', $customerId)->first();
            $subscription = Subscription::where('comapny_id', $company->id)->first();

            if($subscription){
                $subscription->ends_at = \Carbon\Carbon::createFromTimeStamp($payload['data']['object']['current_period_end'])->format('Y-m-d');
                $subscription->save();
            }

            if($company) {

                $company->licence_expire_on = \Carbon\Carbon::createFromTimeStamp($payload['data']['object']['current_period_end'])->format('Y-m-d');
                $company->save();

                return response('Company subscription canceled', 200);
            }

            return response('Customer not found', 200);
        }
    }
}
