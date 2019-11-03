<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Company;
use App\GlobalSetting;
use App\Helper\Reply;

use App\Http\Requests\SuperAdmin\Companies\DeleteRequest;
use App\Invoice;
use App\Traits\StripeSettings;
use App\PaypalInvoice;
use App\StripeInvoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SuperAdminInvoiceController extends SuperAdminBaseController
{
    use StripeSettings;
    /**
     * SuperAdminInvoiceController constructor.
     */
    public function __construct() {

        parent::__construct();
        $this->pageTitle = 'Invoices';
        $this->pageIcon = 'icon-layers';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stripeInvoices = StripeInvoice::count();
        $PaypalInvoices = PaypalInvoice::count();
        $this->totalInvoices = ($stripeInvoices + $PaypalInvoices);
        return view('super-admin.invoices.index', $this->data);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteRequest $request, $id)
    {
        Company::destroy($id);
        return Reply::success('Company deleted successfully.');
    }

    /**
     * @return mixed
     */
    public function data()
    {
        $stripe = DB::table("stripe_invoices")
            ->join('packages', 'packages.id', 'stripe_invoices.package_id')
            ->join('companies', 'companies.id', 'stripe_invoices.company_id')
            ->selectRaw('stripe_invoices.id, stripe_invoices.invoice_id ,companies.company_name as company, 
            packages.name as package, stripe_invoices.transaction_id, "Stripe" as method,stripe_invoices.amount, 
            stripe_invoices.pay_date as paid_on ,stripe_invoices.next_pay_date')
            ->whereNotNull('stripe_invoices.pay_date');

        $paypal = DB::table("paypal_invoices")
            ->join('packages', 'packages.id', 'paypal_invoices.package_id')
            ->join('companies', 'companies.id', 'paypal_invoices.company_id')
            ->selectRaw('paypal_invoices.id,"" as invoice_id, companies.company_name as company, 
                packages.name as package, paypal_invoices.transaction_id,
             "Paypal" as method , paypal_invoices.total as amount, paypal_invoices.paid_on,
             paypal_invoices.next_pay_date')
            ->where('paypal_invoices.status', 'paid')
            ->union($stripe)
            ->get()->sortByDesc('paid_on');



        return Datatables::of($paypal)

            ->editColumn('company', function ($row) {
                    return ucfirst($row->company);
            })
            ->editColumn('package', function ($row) {
                return ucfirst($row->package);
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
            ->editColumn('transaction_id', function ($row) {
                if(!is_null($row->transaction_id)) {
                    return $row->transaction_id;
                }
                return '-';
            })
            ->addColumn('action', function ($row) {
                if($row->method == 'Stripe' && $row->invoice_id){
                    return '<a href="'.route('super-admin.stripe.invoice-download', $row->invoice_id).'" class="btn btn-primary btn-circle waves-effect" data-toggle="tooltip" data-original-title="Download"><span></span> <i class="fa fa-download"></i></a>';
                }
                if($row->method == 'Paypal'){
                    return '<a href="'.route('super-admin.paypal.invoice-download', $row->id).'" class="btn btn-primary btn-circle waves-effect" data-toggle="tooltip" data-original-title="Download"><span></span> <i class="fa fa-download"></i></a>';
                }

                return '';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function paypalInvoiceDownload($id)
    {
        $this->invoice = PaypalInvoice::with(['company','currency','package'])->findOrFail($id);
        $this->superadmin = GlobalSetting::with('currency')->first();
        $this->global = $this->company = Company::with('currency')->withoutGlobalScope('active')->where('id', $this->invoice->company->id)->first();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('paypal-invoice.invoice-1', $this->data);
        $filename = $this->invoice->paid_on->format($this->global->date_format).'-'.$this->invoice->next_pay_date->format($this->global->date_format);
        return $pdf->download($filename . '.pdf');
    }

    public function download(Request $request, $invoiceId) {
        $invoice = StripeInvoice::where('invoice_id', $invoiceId)->first();
        $this->global = $this->company = Company::with('currency')->withoutGlobalScope('active')->where('id', $invoice->company_id)->first();
        $this->setStripConfigs();
        return $this->company->downloadInvoice($invoiceId, [
            'vendor'  => $this->company->company_name,
            'product' => $this->company->package->name,
            'global' => GlobalSetting::first(),
            'logo' => $this->company->logo,
        ]);
    }

}
