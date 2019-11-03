<?php

namespace App\Http\Controllers\Admin;

use App\Expense;
use App\Helper\Reply;
use App\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomeVsExpenseReportController extends AdminBaseController
{
    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.incomeVsExpenseReport';
        $this->pageIcon = 'ti-pie-chart';
    }

    public function index() {
        $this->fromDate = Carbon::today()->subDays(30);
        $this->toDate = Carbon::today();

        $this->totalIncomes = $this->getTotalIncome($this->fromDate->format('Y-m-d'), $this->toDate->format('Y-m-d'));
        $this->totalExpenses = $this->getTotalExpense($this->fromDate->format('Y-m-d'), $this->toDate->format('Y-m-d'));
        $this->graphData = $this->getGraphData($this->fromDate->format('Y-m-d'), $this->toDate->format('Y-m-d'));
        return view('admin.reports.income-expense.index', $this->data);
    }

    public function store(Request $request){
        $this->fromDate = $request->startDate;
        $this->toDate = $request->endDate;

        $this->totalIncomes = $this->getTotalIncome($this->fromDate, $this->toDate);
        $this->totalExpenses = $this->getTotalExpense($this->fromDate, $this->toDate);
        $this->graphData = $this->getGraphData($this->fromDate, $this->toDate);
        return Reply::successWithData(__('messages.reportGenerated'), $this->data);
    }

    public function getGraphData($fromDate, $toDate)
    {
        $graphData = [];

        $incomes = [];
        $invoices = Payment::join('currencies', 'currencies.id', '=', 'payments.currency_id')
                        ->where(DB::raw('DATE(`paid_on`)'), '>=', $fromDate)
                        ->where(DB::raw('DATE(`paid_on`)'), '<=', $toDate)
                        ->where('payments.status', 'complete')
                        ->groupBy('year', 'month')
                        ->orderBy('paid_on', 'ASC')
                        ->get([
                            DB::raw('DATE_FORMAT(paid_on,"%M/%y") as date'),
                            DB::raw('YEAR(paid_on) year, MONTH(paid_on) month'),
                            DB::raw('sum(amount) as total'),
                            'currencies.id as currency_id',
                            'currencies.exchange_rate'
                        ]);

        foreach($invoices as $invoice) {
            if(!isset($incomes[$invoice->date]))
            {
                $incomes[$invoice->date] = 0;
            }

            if($invoice->currency_id != $this->global->currency->id){
                $incomes[$invoice->date] += floor($invoice->total / $invoice->exchange_rate);
            }
            else{
                $incomes[$invoice->date] += round($invoice->total, 2);
            }
        }

        $expenses = [];
        $expenseResults = Expense::join('currencies', 'currencies.id', '=', 'expenses.currency_id')
            ->where(DB::raw('DATE(`purchase_date`)'), '>=', $fromDate)
            ->where(DB::raw('DATE(`purchase_date`)'), '<=', $toDate)
            ->where('expenses.status', 'approved')
            ->get([
                'expenses.price',
                'expenses.purchase_Date as date',
                DB::raw('DATE_FORMAT(purchase_date,\'%M/%y\') as date'),
                'currencies.id as currency_id',
                'currencies.exchange_rate'
            ]);

        foreach($expenseResults as $expenseResult) {
            if(!isset($expenses[$expenseResult->date]))
            {
                $expenses[$expenseResult->date] = 0;
            }

            if($expenseResult->currency_id != $this->global->currency->id){
                $expenses[$expenseResult->date] += floor($expenseResult->price / $expenseResult->exchange_rate);
            }
            else{
                $expenses[$expenseResult->date] += round($expenseResult->price, 2);
            }
        }


        $dates = array_keys(array_merge($incomes,$expenses));

        foreach ($dates as $date)
        {
            $graphData[] = [
                'y' =>  $date,
                'a' =>  isset($incomes[$date]) ? round($incomes[$date], 2) : 0,
                'b' =>  isset($expenses[$date]) ? round($expenses[$date], 2) : 0
            ];
        }

        usort($graphData, function ($a, $b){
            $t1 = strtotime($a['y']);
            $t2 = strtotime($b['y']);
            return $t1 - $t2;
        });

        return $graphData;
    }

    public function getTotalIncome($fromDate, $toDate)
    {
        $totalIncome = 0;

        $invoices = Payment::join('currencies', 'currencies.id', '=', 'payments.currency_id')
                            ->where(DB::raw('DATE(`paid_on`)'), '>=', $fromDate)
                            ->where(DB::raw('DATE(`paid_on`)'), '<=', $toDate)
                            ->where('payments.status', 'complete')
                            ->groupBy('year', 'month')
                            ->orderBy('paid_on', 'ASC')
                            ->get([
                                DB::raw('DATE_FORMAT(paid_on,"%M/%y") as date'),
                                DB::raw('YEAR(paid_on) year, MONTH(paid_on) month'),
                                DB::raw('sum(amount) as total'),
                                'currencies.id as currency_id',
                                'currencies.exchange_rate'
                            ]);

        foreach($invoices as $invoice) {
            if($invoice->currency_id != $this->global->currency->id){
                $totalIncome += floor($invoice->total / $invoice->exchange_rate);
            }
            else{
                $totalIncome += $invoice->total;
            }
        }

        return  round($totalIncome,2);
    }

    public function getTotalExpense($fromDate, $toDate)
    {
        $totalExpense = 0;

        $expenses = Expense::join('currencies', 'currencies.id', '=', 'expenses.currency_id')
            ->where(DB::raw('DATE(`purchase_date`)'), '>=', $fromDate)
            ->where(DB::raw('DATE(`purchase_date`)'), '<=', $toDate)
            ->where('expenses.status', 'approved')
            ->get([
                'expenses.price',
                'currencies.id as currency_id',
                'currencies.exchange_rate'
            ]);

        foreach($expenses as $expense) {
            if($expense->currency_id != $this->global->currency->id){
                $totalExpense += floor($expense->price / $expense->exchange_rate);
            }
            else{
                $totalExpense += $expense->price;
            }
        }

        return  round($totalExpense, 2);
    }
}
