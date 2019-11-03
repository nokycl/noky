<?php

namespace App\Http\Controllers\Client;

use App\Invoice;
use App\InvoiceItems;
use App\InvoiceSetting;
use App\ModuleSetting;
use App\Project;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientProjectInvoicesController extends ClientBaseController
{

    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.projects';
        $this->pageIcon = 'icon-layers';
        $this->middleware(function ($request, $next) {
            if(!in_array('invoices',$this->user->modules)){
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        if($this->project->checkProjectClient()){
            return view('client.project-invoices.show', $this->data);
        }
        else{
            return redirect(route('client.dashboard.index'));
        }
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
        //
    }

    public function download($id) {

        $this->invoice = Invoice::findOrFail($id);
        $this->discount = InvoiceItems::where('type', 'discount')
            ->where('invoice_id', $this->invoice->id)
            ->sum('amount');
        $this->taxes = InvoiceItems::where('type', 'tax')
            ->where('invoice_id', $this->invoice->id)
            ->get();

        $this->settings = $this->global;
        $this->invoiceSetting = InvoiceSetting::first();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('invoices.'.$this->invoiceSetting->template, $this->data);
        $filename = $this->invoice->invoice_number;
        return $pdf->download($filename . '.pdf');
    }
}
