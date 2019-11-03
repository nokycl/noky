<?php
namespace App\Http\Controllers\Client;

use App\ClientPayment;
use App\Helper\Reply;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Invoice;
use App\Payment;
use App\PaymentGatewayCredentials;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Stripe\Subscription;
use Validator;
use URL;
use Session;
use Redirect;

use Stripe\Charge;
use Stripe\Customer;
use Stripe\Plan;
use Stripe\Stripe;

class StripeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->pageTitle = 'Stripe';
    }

    /**
     * Store a details of payment with paypal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function paymentWithStripe(Request $request, $invoiceId)
    {
        $redirectRoute = 'client.invoices.show';
        $id = $invoiceId;

        return $this->makeStripePayment($request, $invoiceId, $redirectRoute, $id);
    }

    public function paymentWithStripePublic(Request $request, $invoiceId)
    {
        $redirectRoute = 'front.invoice';
        $id = md5($invoiceId);

        return $this->makeStripePayment($request, $invoiceId, $redirectRoute, $id);
    }

    private function makeStripePayment($request, $invoiceId, $redirectRoute, $id)
    {
        $invoice = Invoice::findOrFail($invoiceId);

        $stripeCredentials = PaymentGatewayCredentials::withoutGlobalScope('company')
                                                      ->where('company_id', $invoice->company_id)
                                                      ->first();

        /** setup Stripe credentials **/
        Stripe::setApiKey($stripeCredentials->stripe_secret);

        $tokenObject  = $request->get('token');
        $token  = $tokenObject['id'];
        $email  = $tokenObject['email'];

        if($invoice->recurring == 'no')
        {
            try {
                $customer = Customer::create(array(
                    'email' => $email,
                    'source'  => $token
                ));

                $charge = Charge::create(array(
                    'customer' => $customer->id,
                    'amount'   => $invoice->total*100,
                    'currency' => $invoice->currency->currency_code
                ));

            } catch (\Exception $ex) {
                \Session::put('error','Some error occur, sorry for inconvenient');
                return Reply::redirect(route($redirectRoute, $id), 'Payment fail');
            }

            $payment = new Payment();
            $payment->project_id = $invoice->project_id;
            $payment->currency_id = $invoice->currency_id;
            $payment->amount = $invoice->total;
            $payment->gateway = 'Stripe';
            $payment->transaction_id = $charge->id;
            $payment->paid_on = Carbon::now();
            $payment->status = 'complete';
            $payment->save();

        } else {


            $plan = Plan::create(array(
                "name" => 'Payment for invoice #'. $invoice->invoice_number,
                "id" => 'plan-'.$invoice->id.'-'.str_random('10'),
                "interval" => $invoice->billing_frequency,
                "interval_count" => $invoice->billing_interval,
                "currency" => $invoice->currency->currency_code,
                "amount" => $invoice->total*100,
                "metadata" => [
                    "invoice_id" => $invoice->id
                ],
            ));

            try {

                $customer = Customer::create(array(
                    'email' => $email,
                    'source'  => $token
                ));

                $subscription = Subscription::create(array(
                    "customer" => $customer->id,
                    "items" => array(
                        array(
                            "plan" => $plan->id,
                        ),
                    ),
                    "metadata" => [
                        "invoice_id" => $invoice->id
                    ],
                ));

            } catch (\Exception $ex) {
                \Session::put('error','Some error occur, sorry for inconvenient');
                return Reply::redirect(route($redirectRoute, $id), 'Payment fail');
            }

            // Save details in database
            $payment = new Payment();
            $payment->project_id = $invoice->project_id;
            $payment->currency_id = $invoice->currency_id;
            $payment->amount = $invoice->total;
            $payment->gateway = 'Stripe';
            $payment->plan_id = $plan->id;
            $payment->transaction_id = $subscription->id;
            $payment->paid_on = Carbon::now();
            $payment->status = 'complete';
            $payment->save();
        }

        $invoice->status = 'paid';
        $invoice->save();

        \Session::put('success','Payment success');
        return Reply::redirect(route($redirectRoute, $id), 'Payment success');
    }
}