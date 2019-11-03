<?php

namespace App\Http\Controllers\Admin;

use App\CreditNotes;
use App\Currency;
use App\Helper\Reply;
use App\Http\Requests\Invoices\StoreInvoice;
use App\Invoice;
use App\InvoiceItems;
use App\InvoiceSetting;
use App\Notifications\NewInvoice;
use App\Project;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ManageInvoicesController extends AdminBaseController
{

    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'Project';
        $this->pageIcon = 'layers';
        $this->middleware(function ($request, $next) {
            if (!in_array('invoices',$this->user->modules)) {
                abort(403);
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->project = Project::findOrFail();
        $this->currencies = Currency::all();
        $this->lastInvoice = Invoice::count()+1;
        $this->invoiceSetting = InvoiceSetting::first();
        $this->zero = '';
        if (strlen($this->lastInvoice) < $this->invoiceSetting->invoice_digit){
            for ($i=0; $i<$this->invoiceSetting->invoice_digit-strlen($this->lastInvoice); $i++){
                $this->zero = '0'.$this->zero;
            }
        }

        return view('admin.projects.invoices.create', $this->data);
    }

    public function createInvoice(Request $request)
    {
        $this->project = Project::findOrFail($request->id);
        $this->currencies = Currency::all();
        $this->lastInvoice = Invoice::count()+1;
        $this->invoiceSetting = InvoiceSetting::first();
        $this->zero = '';
        if (strlen($this->lastInvoice) < $this->invoiceSetting->invoice_digit){
            for ($i=0; $i<$this->invoiceSetting->invoice_digit-strlen($this->lastInvoice); $i++){
                $this->zero = '0'.$this->zero;
            }
        }
        return view('admin.projects.invoices.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoice $request)
    {
        $items = $request->input('item_name');
        $cost_per_item = $request->input('cost_per_item');
        $quantity = $request->input('quantity');
        $amount = $request->input('amount');
        $type = $request->input('type');

        if (trim($items[0]) == '' || trim($items[0]) == '' || trim($cost_per_item[0]) == '') {
            return Reply::error(__('messages.addItem'));
        }

        foreach ($quantity as $qty) {
            if (!is_numeric($qty) && $qty < 1) {
                return Reply::error(__('messages.quantityNumber'));
            }
        }

        foreach ($cost_per_item as $rate) {
            if (!is_numeric($rate)) {
                return Reply::error(__('messages.unitPriceNumber'));
            }
        }

        foreach ($amount as $amt) {
            if (!is_numeric($amt)) {
                return Reply::error('Amount should be a number.');
            }
        }

        foreach ($items as $itm) {
            if (is_null($itm)) {
                return Reply::error('Item name cannot be blank.');
            }
        }


        $invoice = new Invoice();
        $invoice->project_id = $request->project_id;
        $invoice->invoice_number = $request->invoice_number;
        $invoice->issue_date = Carbon::parse($request->issue_date)->format('Y-m-d');
        $invoice->due_date = Carbon::parse($request->due_date)->format('Y-m-d');
        $invoice->sub_total = $request->sub_total;
        $invoice->total = $request->total;
        $invoice->currency_id = $request->currency_id;
        $invoice->save();

        // Notify client
        $notifyUser = User::withoutGlobalScope('active')->findOrFail($invoice->project->client_id);
        $notifyUser->notify(new NewInvoice($invoice));

        foreach ($items as $key => $item):
            InvoiceItems::create(['invoice_id' => $invoice->id, 'item_name' => $item, 'type' => $type[$key], 'quantity' => $quantity[$key], 'unit_price' => $cost_per_item[$key], 'amount' => $amount[$key]]);
        endforeach;

        $this->logSearchEntry($invoice->id, 'Invoice #'.$invoice->invoice_number, 'admin.all-invoices.show');

        $this->project = Project::findOrFail($request->project_id);
        $view = view('admin.projects.invoices.invoice-ajax', $this->data)->render();
        return Reply::successWithData(__('messages.invoiceCreated'), ['html' => $view]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->project = Project::findOrFail($id);
        return view('admin.projects.invoices.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        Invoice::destroy($id);
        $this->project = Project::findOrFail($invoice->project_id);
        $view = view('admin.projects.invoices.invoice-ajax', $this->data)->render();
        return Reply::successWithData(__('messages.invoiceDeleted'), ['html' => $view]);
    }

    public function download($id) {
        //header('Content-type: application/pdf');

        $this->invoice = Invoice::findOrFail($id);
        $this->paidAmount = $this->invoice->getPaidAmount();
        $this->creditNote = 0;
        if ($this->invoice->credit_note){
            $this->creditNote = CreditNotes::where('invoice_id', $id)
                ->select('cn_number')
                ->first();
        }

        // Download file uploaded
        if($this->invoice->file != null){
            return response()->download(storage_path('app/public/invoice-files').'/'.$this->invoice->file);
        }

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

        $this->settings = $this->company;

        $this->invoiceSetting = InvoiceSetting::first();
        //        return view('invoices.'.$this->invoiceSetting->template, $this->data);

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('invoices.'.$this->invoiceSetting->template, $this->data);
        $filename = $this->invoice->invoice_number;
        //       return $pdf->stream();
        return $pdf->download($filename . '.pdf');
    }
}
