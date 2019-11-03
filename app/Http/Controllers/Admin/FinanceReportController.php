<?php

namespace App\Http\Controllers\Admin;

use App\Currency;
use App\Helper\Reply;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceReportController extends AdminBaseController
{
    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.financeReport';
        $this->pageIcon = 'ti-pie-chart';
    }

    public function index() {

        $this->currencies = Currency::all();
        $this->currentCurrencyId = $this->global->currency_id;

        $symbols = array();
        foreach($this->currencies as $currency){
            $symbols[] = $currency->currency_code;
        }
        $symbols = implode(',', $symbols);

        $client = new Client();
        $res = $client->request('GET', 'http://apilayer.net/api/live?access_key='.env('CURRENCY_EXCHANGE_ACCESS_KEY', '16a1873361ce993889eea414e73cc9a6').'&currencies='.$symbols.'&source='.$this->global->currency->currency_code.'&format=1', ['verify' => false]);

        $conversionRate = $res->getBody();

        $conversionRateArray = json_decode($conversionRate, true);

        $this->fromDate = Carbon::today()->subDays(180);
        $this->toDate = Carbon::today();
        $invoices = DB::table('payments')
            ->join('currencies', 'currencies.id', '=', 'payments.currency_id')
            ->where('paid_on', '>=', $this->fromDate)
            ->where('paid_on', '<=', $this->toDate)
            ->groupBy('year', 'month')
            ->orderBy('paid_on', 'ASC')
            ->get([
                DB::raw('DATE_FORMAT(paid_on,\'%M/%y\') as date'),
                DB::raw('sum(amount) as total'),
                DB::raw('YEAR(paid_on) year, MONTH(paid_on) month'),
                'currencies.currency_code'
            ]);

        $chartData = array();
        foreach($invoices as $chart) {
            if($chart->currency_code != $this->global->currency->currency_code){
                if(isset($conversionRateArray['quotes'])){
                    $chartData[] = ['date' => $chart->date, 'total' => round(floor($chart->total / $conversionRateArray['quotes'][strtoupper($this->global->currency->currency_code.$chart->currency_code)]), 2)];
                }else{
                    $chartData[] = ['date' => $chart->date, 'total' => round(floor($chart->total),2)];
                }

            }
            else{
                $chartData[] = ['date' => $chart->date, 'total' => round($chart->total,2)];
            }
        }

        $this->chartData = json_encode($chartData);

        return view('admin.reports.finance.index', $this->data);
    }

    public function store(Request $request) {
        $this->currentCurrencyId = $request->currencyId;

        $currentCurrency = Currency::findOrFail($request->currencyId);

        $currencies = Currency::all();
        $symbols = array();
        foreach($currencies as $currency){
            $symbols[] = $currency->currency_code;
        }
        $symbols = implode(',', $symbols);

        $client = new Client();
        $res = $client->request('GET', 'http://apilayer.net/api/live?access_key='.env('CURRENCY_EXCHANGE_ACCESS_KEY', '16a1873361ce993889eea414e73cc9a6').'&currencies='.$symbols.'&source='.$currentCurrency->currency_code.'&format=1', ['verify' => false]);

        $conversionRate = $res->getBody();
        $conversionRateArray = json_decode($conversionRate, true);;

        $fromDate = $request->startDate;
        $toDate = $request->endDate;

        $invoices = DB::table('payments')
            ->join('currencies', 'currencies.id', '=', 'payments.currency_id')
            ->where('paid_on', '>=', $fromDate)
            ->where('paid_on', '<=', $toDate)
            ->groupBy('year', 'month')
            ->orderBy('paid_on', 'ASC')
            ->get([
                DB::raw('DATE_FORMAT(paid_on,\'%M/%y\') as date'),
                DB::raw('sum(amount) as total'),
                DB::raw('YEAR(paid_on) year, MONTH(paid_on) month'),
                'currencies.currency_code'
            ]);

        $chartData = array();
        foreach($invoices as $chart) {
            if($chart->currency_code != $currentCurrency->currency_code){
                $chartData[] = ['date' => $chart->date, 'total' => floor($chart->total / $conversionRateArray['quotes'][strtoupper($currentCurrency->currency_code.$chart->currency_code)])];
            }
            else{
                $chartData[] = ['date' => $chart->date, 'total' => $chart->total];
            }
        }

        $chartData = json_encode($chartData);

        return Reply::successWithData(__('messages.reportGenerated'), ['chartData' => $chartData]);
    }

}
