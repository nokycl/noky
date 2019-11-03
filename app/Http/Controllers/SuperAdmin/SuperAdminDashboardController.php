<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Company;
use App\Package;
use App\PaypalInvoice;
use App\StripeInvoice;
use App\Traits\CurrencyExchange;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\SmtpSetting;



class SuperAdminDashboardController extends SuperAdminBaseController
{
    use CurrencyExchange;

    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.dashboard';
        $this->pageIcon = 'icon-speedometer';
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function index() {
        $this->totalCompanies = Company::all()->count();
        $this->totalPackages = Package::all()->count();
        $this->activeCompanies = Company::where('status', '=', 'active')->count();

        $this->inactiveCompanies = Company::where('status', '=', 'inactive')->count();

        $expiredCompanies =  Company::with('package')->where('status', 'license_expired')->get();
        $this->expiredCompanies = $expiredCompanies->count();;

        // Collect recent 5 licence expired companies detail
        $this->recentExpired = $expiredCompanies->sortBy('updated_at')->take(5);

        // Collect data for earning chart
        $months = [
            '1' => 'jan',
            '2' => 'Feb',
            '3' => 'Mar',
            '4' => 'Apr',
            '5' => 'May',
            '6' => 'Jun',
            '7' => 'Jul',
            '8' => 'Aug',
            '9' => 'Sep',
            '10' => 'Oct',
            '11' => 'Nov',
            '12' => 'Dec',
        ];

        $invoices = StripeInvoice::selectRaw('SUM(amount) as amount,YEAR(pay_date) as year, MONTH(pay_date) as month')->havingRaw('year = ?', [Carbon::now()->year])->groupBy('month')->get()->groupBy('month')->toArray();
        $paypalInvoices = PaypalInvoice::selectRaw('SUM(total) as total,YEAR(paid_on) as year, MONTH(paid_on) as month')->havingRaw('year = ?', [Carbon::now()->year])->groupBy('month')->get()->groupBy('month')->toArray();

        $chartData = [];
        foreach($months as $key => $month) {
            if(key_exists($key, $invoices)) {
                foreach($invoices[$key] as $amount) {
                    $chartData[] = ['month' => $month, 'amount' => $amount['amount']];
                }
            }
            else{
                $chartData[] = ['month' => $month, 'amount' => 0];
            }
            if(key_exists($key, $paypalInvoices)) {
                foreach($paypalInvoices[$key] as $amount) {
                    $chartData[] = ['month' => $month, 'amount' => $amount['total']];
                }
            }
            else{
                $chartData[] = ['month' => $month, 'amount' => 0];
            }
        }

        $this->chartData = json_encode($chartData);

        // Collect data of recent registered 5 companies
        $this->recentRegisteredCompanies = Company::with('package')->take(5)->latest()->get();


        $stripe = DB::table("stripe_invoices")
            ->join('packages', 'packages.id', 'stripe_invoices.package_id')
            ->join('companies', 'companies.id', 'stripe_invoices.company_id')
            ->selectRaw('stripe_invoices.id ,companies.company_name, packages.name, companies.package_type,"Stripe" as method, stripe_invoices.pay_date as paid_on, "" as end_on ,stripe_invoices.next_pay_date, stripe_invoices.created_at')
            ->whereNotNull('stripe_invoices.pay_date');

        $allInvoices = DB::table("paypal_invoices")
            ->join('packages', 'packages.id', 'paypal_invoices.package_id')
            ->join('companies', 'companies.id', 'paypal_invoices.company_id')
            ->selectRaw('paypal_invoices.id,companies.company_name, packages.name, companies.package_type, "Paypal" as method, paypal_invoices.paid_on, paypal_invoices.end_on,paypal_invoices.next_pay_date,paypal_invoices.created_at')
            ->where('paypal_invoices.status', 'paid')
            ->union($stripe)
            ->get();

        $this->recentSubscriptions = $allInvoices->sortByDesc(function ($temp, $key) {
            return Carbon::parse($temp->created_at)->getTimestamp();
        })->take(5);

        try {
            $client = new Client();
            $res = $client->request('GET', config('froiden_envato.updater_file_path'), ['verify' => false]);
            $lastVersion = $res->getBody();
            $lastVersion = json_decode($lastVersion, true);

            if ($lastVersion['version'] > File::get(public_path().'version.txt')) {
                $this->lastVersion = $lastVersion['version'];
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        $this->progressPercent = $this->progressbarPercent();

        return view('super-admin.dashboard.index', $this->data);
    }

    private function progressbarPercent()
    {
        $this->smtpSetting = SmtpSetting::first();
        $totalItems = 4;
        $completedItem = 1;
        $progress = [];
        $progress['progress_completed'] = false;

        if ($this->global->company_email != 'company@email.com') {
            $completedItem++;
            $progress['company_setting_completed'] = true;
        }

        if ($this->smtpSetting->verified !== 0 || $this->smtpSetting->mail_driver == 'mail') {
            $progress['smtp_setting_completed'] = true;

            $completedItem++;
        }

        if ($this->user->email != 'superadmin@example.com') {
            $progress['profile_setting_completed'] = true;

            $completedItem++;
        }
       

        if ($totalItems == $completedItem) {
            $progress['progress_completed'] = true;
        }

        $this->progress = $progress;


        return ($completedItem / $totalItems) * 100;

    }

}
