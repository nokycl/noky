<?php

namespace App\Http\Controllers\Admin;

use App\CreditNotes;
use App\Currency;
use App\Estimate;
use App\Helper\Reply;
use App\Http\Requests\InvoiceFileStore;
use App\Http\Requests\Invoices\StoreInvoice;
use App\Invoice;
use App\InvoiceItems;
use App\InvoiceSetting;
use App\Notifications\NewInvoice;
use App\Product;
use App\Project;
use App\Proposal;
use App\Tax;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Invoices\UpdateInvoice;
use App\ProjectMilestone;

class ManageAllInvoicesController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.invoices';
        $this->pageIcon = 'ti-receipt';
        $this->middleware(function ($request, $next) {
            if (!in_array('invoices', $this->user->modules)) {
                abort(403);
            }
            return $next($request);
        });
    }

    public function index()
    {
        $this->projects = Project::all();
        $this->clients = User::allClients();
        return view('admin.invoices.index', $this->data);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function data(Request $request)
    {
        $firstInvoice = Invoice::orderBy('id', 'desc')->first();
        $invoices = Invoice::with(['project:id,project_name,client_id', 'currency:id,currency_symbol,currency_code', 'project.client'])
            ->join('projects', 'projects.id', '=', 'invoices.project_id')
            ->select('invoices.id', 'invoices.project_id', 'invoices.invoice_number', 'invoices.currency_id', 'invoices.total', 'invoices.status', 'invoices.issue_date', 'invoices.credit_note');

        if ($request->startDate !== null && $request->startDate != 'null' && $request->startDate != '') {
            $invoices = $invoices->where(DB::raw('DATE(invoices.`issue_date`)'), '>=', $request->startDate);
        }

        if ($request->endDate !== null && $request->endDate != 'null' && $request->endDate != '') {
            $invoices = $invoices->where(DB::raw('DATE(invoices.`issue_date`)'), '<=', $request->endDate);
        }

        if ($request->status != 'all' && !is_null($request->status)) {
            $invoices = $invoices->where('invoices.status', '=', $request->status);
        }

        if ($request->projectID != 'all' && !is_null($request->projectID)) {
            $invoices = $invoices->where('invoices.project_id', '=', $request->projectID);
        }

        if ($request->clientID != 'all' && !is_null($request->clientID)) {
            $invoices = $invoices->where('projects.client_id', '=', $request->clientID);
        }
        
        $invoices = $invoices->orderBy('invoices.id', 'desc')->get();

        return DataTables::of($invoices)
            ->addIndexColumn()
            ->addColumn('action', function ($row)  use ($firstInvoice) {
                $action = '<div class="btn-group m-r-10">
                <button aria-expanded="false" data-toggle="dropdown" class="btn btn-info btn-outline  dropdown-toggle waves-effect waves-light" type="button">Action <span class="caret"></span></button>
                <ul role="menu" class="dropdown-menu">
                    <li><a href="' . route("admin.all-invoices.download", $row->id) . '"><i class="fa fa-download"></i> Download</a></li>';
                if ($row->status == 'paid') {
                    $action .= ' <li><a href="javascript:" data-invoice-id="' . $row->id . '" class="invoice-upload" data-toggle="modal" data-target="#invoiceUploadModal"><i class="fa fa-upload"></i> Upload </a></li>';
                }

                if ($row->status != 'paid') {
                    $action .= '<li><a href="' . route("admin.all-invoices.edit", $row->id) . '"><i class="fa fa-pencil"></i> Edit</a></li>';
                    if (in_array('payments', $this->user->modules) && $row->credit_note == 0) {
                        $action .= '<li><a href="' . route("admin.payments.payInvoice", [$row->id]) . '" data-toggle="tooltip" ><i class="fa fa-plus"></i> ' . __('modules.payments.addPayment') . '</a></li>';
                    }
                }
                $action .= '<li><a href="' . route("front.invoice", [md5($row->id)]) . '" target="_blank" data-toggle="tooltip" ><i class="fa fa-link"></i> ' . __('modules.payments.paymentLink') . '</a></li>';
                if ($firstInvoice->id == $row->id) {
                    $action .= '<li><a href="javascript:;" data-toggle="tooltip"  data-invoice-id="' . $row->id . '" class="sa-params"><i class="fa fa-times"></i> Delete</a></li>';
                }

                if ($row->status != 'paid' && $row->credit_note == 0) {
                    $action .= '<li><a href="' . route('admin.all-credit-notes.convert-invoice', $row->id) . '" data-toggle="tooltip"  data-invoice-id="' . $row->id . '" class="addCreditNote"><i class="fa fa-plus"></i> Add Credit Note</a></li>';
                }

                $action .= '</ul>
              </div>
              ';

                return $action;
            })
            ->editColumn('project_name', function ($row) {
                return '<a href="' . route('admin.projects.show', $row->project_id) . '">' . ucfirst($row->project->project_name) . '</a>';
            })
            ->editColumn('client', function ($row) {
                return '<a href="' . route('admin.clients.projects', $row->project->client->user_id) . '">' . ucfirst($row->project->client->company_name) . '</a>';
            })
            ->editColumn('invoice_number', function ($row) {
                return '<a href="' . route('admin.all-invoices.show', $row->id) . '">' . ucfirst($row->invoice_number) . '</a>';
            })
            ->editColumn('status', function ($row) {
                if ($row->credit_note) {
                    return '<label class="label label-warning">' . __('app.credit-note') . '</label>';
                } else {
                    if ($row->status == 'unpaid') {
                        return '<label class="label label-danger">' . strtoupper($row->status) . '</label>';
                    } elseif ($row->status == 'paid') {
                        return '<label class="label label-success">' . strtoupper($row->status) . '</label>';
                    } else {
                        return '<label class="label label-info">' . __('modules.invoices.partial') . '</label>';
                    }
                }
            })
            ->editColumn('total', function ($row) {
                return $row->currency->currency_symbol . $row->total . ' (' . $row->currency->currency_code . ')';
            })
            ->editColumn(
                'issue_date',
                function ($row) {
                    return $row->issue_date->timezone($this->global->timezone)->format($this->global->date_format);
                }
            )
            ->rawColumns(['project_name', 'client', 'action', 'status', 'invoice_number'])
            ->removeColumn('currency_symbol')
            ->removeColumn('currency_code')
            ->removeColumn('project_id')
            ->make(true);
    }

    public function download($id)
    {
        //        header('Content-type: application/pdf');

        $this->invoice = Invoice::findOrFail($id);
        $this->paidAmount = $this->invoice->getPaidAmount();
        $this->creditNote = 0;
        if ($this->invoice->credit_note) {
            $this->creditNote = CreditNotes::where('invoice_id', $id)
                ->select('cn_number')
                ->first();
        }
        //        dd($this->creditNote->cn_number);

        // Download file uploaded
        if ($this->invoice->file != null) {
            return response()->download(storage_path('app/public/invoice-files') . '/' . $this->invoice->file);
        }

        if ($this->invoice->discount > 0) {
            if ($this->invoice->discount_type == 'percent') {
                $this->discount = (($this->invoice->discount / 100) * $this->invoice->sub_total);
            } else {
                $this->discount = $this->invoice->discount;
            }
        } else {
            $this->discount = 0;
        }

        $taxList = array();

        $items = InvoiceItems::whereNotNull('tax_id')
            ->where('invoice_id', $this->invoice->id)
            ->get();

        foreach ($items as $item) {
            if (!isset($taxList[$item->tax->tax_name . ': ' . $item->tax->rate_percent . '%'])) {
                $taxList[$item->tax->tax_name . ': ' . $item->tax->rate_percent . '%'] = ($item->tax->rate_percent / 100) * $item->amount;
            } else {
                $taxList[$item->tax->tax_name . ': ' . $item->tax->rate_percent . '%'] = $taxList[$item->tax->tax_name . ': ' . $item->tax->rate_percent . '%'] + (($item->tax->rate_percent / 100) * $item->amount);
            }
        }

        $this->taxes = $taxList;

        $this->settings = $this->company;

        $this->invoiceSetting = InvoiceSetting::first();
        //        return view('invoices.'.$this->invoiceSetting->template, $this->data);

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('invoices.' . $this->invoiceSetting->template, $this->data);
        $filename = $this->invoice->invoice_number;
        //       return $pdf->stream();
        return $pdf->download($filename . '.pdf');
    }

    public function destroy($id)
    {
        $firstInvoice = Invoice::orderBy('id', 'desc')->first();
        if ($firstInvoice->id == $id) {
            if (CreditNotes::where('invoice_id', $id)->exists()) {
                CreditNotes::where('invoice_id', $id)->update(['invoice_id' => null]);
            }
            Invoice::destroy($id);
            return Reply::success(__('messages.invoiceDeleted'));
        } else {
            return Reply::error(__('messages.invoiceCanNotDeleted'));
        }
    }

    public function create()
    {
        $this->projects = Project::all();
        $this->currencies = Currency::all();
        $this->lastInvoice = Invoice::count() + 1;
        $this->invoiceSetting = InvoiceSetting::first();
        $this->zero = '';
        if (strlen($this->lastInvoice) < $this->invoiceSetting->invoice_digit) {
            for ($i = 0; $i < $this->invoiceSetting->invoice_digit - strlen($this->lastInvoice); $i++) {
                $this->zero = '0' . $this->zero;
            }
        }
        $this->taxes = Tax::all();
        $this->products = Product::all();
        return view('admin.invoices.create', $this->data);
    }

    public function store(StoreInvoice $request)
    {
        //        dd($request->all());
        $items = $request->input('item_name');
        $itemsSummary = $request->input('item_summary');
        $cost_per_item = $request->input('cost_per_item');
        $quantity = $request->input('quantity');
        $amount = $request->input('amount');
        $tax = $request->input('taxes');

        foreach ($quantity as $qty) {
            if (!is_numeric($qty) && (intval($qty) < 1)) {
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
                return Reply::error(__('messages.amountNumber'));
            }
        }

        foreach ($items as $itm) {
            if (is_null($itm)) {
                return Reply::error(__('messages.itemBlank'));
            }
        }

        $invoice = new Invoice();
        $invoice->project_id = $request->project_id;
        $invoice->invoice_number = Invoice::count() + 1;
        $invoice->issue_date = Carbon::parse($request->issue_date)->format('Y-m-d');
        $invoice->due_date = Carbon::parse($request->due_date)->format('Y-m-d');
        $invoice->sub_total = round($request->sub_total, 2);
        $invoice->discount = round($request->discount_value, 2);
        $invoice->discount_type = $request->discount_type;
        $invoice->total = round($request->total, 2);
        $invoice->currency_id = $request->currency_id;
        $invoice->recurring = $request->recurring_payment;
        $invoice->billing_frequency = $request->recurring_payment == 'yes' ? $request->billing_frequency : null;
        $invoice->billing_interval = $request->recurring_payment == 'yes' ? $request->billing_interval : null;
        $invoice->billing_cycle = $request->recurring_payment == 'yes' ? $request->billing_cycle : null;
        $invoice->note = $request->note;
        $invoice->save();

        if ($request->estimate_id) {
            $estimate = Estimate::findOrFail($request->estimate_id);
            $estimate->status = 'accepted';
            $estimate->save();
        }


        foreach ($items as $key => $item) :
            if (!is_null($item)) {
                InvoiceItems::create(
                    [
                        'invoice_id' => $invoice->id,
                        'item_name' => $item,
                        'item_summary' => $itemsSummary[$key] ? $itemsSummary[$key] : '',
                        'type' => 'item',
                        'quantity' => $quantity[$key],
                        'unit_price' => round($cost_per_item[$key], 2),
                        'amount' => round($amount[$key], 2),
                        'tax_id' => $tax[$key]
                    ]
                );
            }
        endforeach;

        //set milestone paid if converted milestone to invoice
        if ($request->milestone_id != '') {
            $milestone = ProjectMilestone::findOrFail($request->milestone_id);
            $milestone->invoice_created = 1;
            $milestone->invoice_id = $invoice->id;
            $milestone->save();
        }

        //log search
        $this->logSearchEntry($invoice->id, 'Invoice ' . $invoice->invoice_number, 'admin.all-invoices.show');

        if ($invoice->project->client_id != null) {
            // Notify client
            $notifyUser = User::withoutGlobalScope('active')->findOrFail($invoice->project->client_id);
            $notifyUser->notify(new NewInvoice($invoice));
        }

        return Reply::redirect(route('admin.all-invoices.index'), __('messages.invoiceCreated'));
    }

    public function edit($id)
    {
        $this->invoice = Invoice::findOrFail($id);
        $this->projects = Project::all();
        $this->currencies = Currency::all();

        if ($this->invoice->status == 'paid') {
            abort(403);
        }
        $this->taxes = Tax::all();
        $this->products = Product::all();

        return view('admin.invoices.edit', $this->data);
    }

    public function update(UpdateInvoice $request, $id)
    {
        $items = $request->input('item_name');
        $itemsSummary = $request->input('item_summary');
        $cost_per_item = $request->input('cost_per_item');
        $quantity = $request->input('quantity');
        $amount = $request->input('amount');
        $tax = $request->input('taxes');

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
                return Reply::error(__('messages.amountNumber'));
            }
        }

        foreach ($items as $itm) {
            if (is_null($itm)) {
                return Reply::error(__('messages.itemBlank'));
            }
        }


        $invoice = Invoice::findOrFail($id);

        if ($invoice->status == 'paid') {
            return Reply::error(__('messages.invalidRequest'));
        }

        $invoice->project_id = $request->project_id;
        $invoice->issue_date = Carbon::parse($request->issue_date)->format('Y-m-d');
        $invoice->due_date = Carbon::parse($request->due_date)->format('Y-m-d');
        $invoice->sub_total = round($request->sub_total, 2);
        $invoice->discount = round($request->discount_value, 2);
        $invoice->discount_type = $request->discount_type;
        $invoice->total = round($request->total, 2);
        $invoice->currency_id = $request->currency_id;
        $invoice->status = $request->status;
        $invoice->recurring = $request->recurring_payment;
        $invoice->billing_frequency = $request->recurring_payment == 'yes' ? $request->billing_frequency : null;
        $invoice->billing_interval = $request->recurring_payment == 'yes' ? $request->billing_interval : null;
        $invoice->billing_cycle = $request->recurring_payment == 'yes' ? $request->billing_cycle : null;
        $invoice->note = $request->note;
        $invoice->save();

        // Notify client
        $notifyUser = User::withoutGlobalScope('active')->find($invoice->project->client_id);
        if (!is_null($notifyUser)) {
            $notifyUser->notify(new NewInvoice($invoice));
        }

        // delete and create new
        InvoiceItems::where('invoice_id', $invoice->id)->delete();

        foreach ($items as $key => $item) :
            InvoiceItems::create(
                [
                    'invoice_id' => $invoice->id,
                    'item_name' => $item,
                    'item_summary' => $itemsSummary[$key],
                    'type' => 'item',
                    'quantity' => $quantity[$key],
                    'unit_price' => round($cost_per_item[$key], 2),
                    'amount' => round($amount[$key], 2),
                    'tax_id' => $tax[$key]
                ]
            );
        endforeach;

        return Reply::redirect(route('admin.all-invoices.index'), __('messages.invoiceUpdated'));
    }

    public function show($id)
    {
        $this->invoice = Invoice::findOrFail($id);
        $this->paidAmount = $this->invoice->getPaidAmount();


        if ($this->invoice->discount > 0) {
            if ($this->invoice->discount_type == 'percent') {
                $this->discount = (($this->invoice->discount / 100) * $this->invoice->sub_total);
            } else {
                $this->discount = $this->invoice->discount;
            }
        } else {
            $this->discount = 0;
        }

        $taxList = array();

        $items = InvoiceItems::whereNotNull('tax_id')
            ->where('invoice_id', $this->invoice->id)
            ->get();

        foreach ($items as $item) {
            if (!isset($taxList[$item->tax->tax_name . ': ' . $item->tax->rate_percent . '%'])) {
                $taxList[$item->tax->tax_name . ': ' . $item->tax->rate_percent . '%'] = ($item->tax->rate_percent / 100) * $item->amount;
            } else {
                $taxList[$item->tax->tax_name . ': ' . $item->tax->rate_percent . '%'] = $taxList[$item->tax->tax_name . ': ' . $item->tax->rate_percent . '%'] + (($item->tax->rate_percent / 100) * $item->amount);
            }
        }

        $this->taxes = $taxList;

        $this->settings = $this->company;
        $this->invoiceSetting = InvoiceSetting::first();
        return view('admin.invoices.show', $this->data);
    }

    public function convertEstimate($id)
    {
        $this->estimateId = $id;
        $this->invoice = Estimate::with('items')->findOrFail($id);
        $this->lastInvoice = Invoice::count() + 1;
        $this->invoiceSetting = InvoiceSetting::first();
        $this->projects = Project::all();
        $this->currencies = Currency::all();
        $this->taxes = Tax::all();
        $this->products = Product::all();
        $this->zero = '';
        if (strlen($this->lastInvoice) < $this->invoiceSetting->invoice_digit) {
            for ($i = 0; $i < $this->invoiceSetting->invoice_digit - strlen($this->lastInvoice); $i++) {
                $this->zero = '0' . $this->zero;
            }
        }
        //        foreach ($this->invoice->items as $items)

        $discount = $this->invoice->items->filter(function ($value, $key) {
            return $value->type == 'discount';
        });

        $tax = $this->invoice->items->filter(function ($value, $key) {
            return $value->type == 'tax';
        });

        $this->totalTax = $tax->sum('amount');
        $this->totalDiscount = $discount->sum('amount');

        return view('admin.invoices.convert_estimate', $this->data);
    }

    public function convertProposal($id)
    {
        $this->invoice = Proposal::findOrFail($id);
        $this->lastInvoice = Invoice::withoutGlobalScope('company')->orderBy('id', 'desc')->first();
        $this->invoiceSetting = InvoiceSetting::first();
        $this->projects = Project::all();
        $this->currencies = Currency::all();
        return view('admin.invoices.convert_estimate', $this->data);
    }

    public function addItems(Request $request)
    {
        $this->items = Product::with('tax')->find($request->id);
        $this->taxes = Tax::all();
        $view = view('admin.invoices.add-item', $this->data)->render();
        return Reply::dataOnly(['status' => 'success', 'view' => $view]);
    }


    public function paymentDetail($invoiceID)
    {
        $this->invoice = Invoice::findOrFail($invoiceID);

        return View::make('admin.invoices.payment-detail', $this->data);
    }

    /**
     * @param InvoiceFileStore $request
     * @return array
     */
    public function storeFile(InvoiceFileStore $request)
    {
        $invoiceId = $request->invoice_id;
        $file = $request->file('file');

        $newName = $file->hashName(); // setting hashName name
        // Getting invoice data
        $invoice = Invoice::find($invoiceId);

        if ($invoice != null) {

            if ($invoice->file != null) {
                unlink(storage_path('app/public/invoice-files') . '/' . $invoice->file);
            }

            $file->move(storage_path('app/public/invoice-files'), $newName);

            $invoice->file = $newName;
            $invoice->file_original_name = $file->getClientOriginalName(); // Getting uploading file name;

            $invoice->save();

            return Reply::success(__('messages.fileUploadedSuccessfully'));
        }

        return Reply::error(__('messages.fileUploadIssue'));
    }

    /**
     * @param Request $request
     * @return array
     */
    public function destroyFile(Request $request)
    {
        $invoiceId = $request->invoice_id;

        $invoice = Invoice::find($invoiceId);

        if ($invoice != null) {

            if ($invoice->file != null) {
                unlink(storage_path('app/public/invoice-files') . '/' . $invoice->file);
            }

            $invoice->file = null;
            $invoice->file_original_name = null;

            $invoice->save();
        }

        return Reply::success(__('messages.fileDeleted'));
    }

    /**
     * @param $startDate
     * @param $endDate
     * @param $status
     * @param $projectID
     */
    public function export($startDate, $endDate, $status, $projectID)
    {

        $invoices = Invoice::join('projects', 'projects.id', '=', 'invoices.project_id')
            ->join('currencies', 'currencies.id', '=', 'invoices.currency_id')
            ->select('invoices.id', 'invoices.invoice_number', 'projects.project_name', 'invoices.total', 'currencies.currency_symbol', 'invoices.status', 'invoices.issue_date');

        if ($startDate !== null && $startDate != 'null' && $startDate != '') {
            $invoices = $invoices->where(DB::raw('DATE(invoices.`issue_date`)'), '>=', $startDate);
        }

        if ($endDate !== null && $endDate != 'null' && $endDate != '') {
            $invoices = $invoices->where(DB::raw('DATE(invoices.`issue_date`)'), '<=', $endDate);
        }

        if ($status != 'all' && !is_null($status)) {
            $invoices = $invoices->where('invoices.status', '=', $status);
        }

        if ($projectID != 'all' && !is_null($projectID)) {
            $invoices = $invoices->where('invoices.project_id', '=', $projectID);
        }

        $attributes =  ['total', 'currency_symbol', 'issue_date'];

        $invoices = $invoices->get()->makeHidden($attributes);

        // Initialize the array which will be passed into the Excel
        // generator.
        $exportArray = [];

        // Define the Excel spreadsheet headers
        $exportArray[] = ['ID', 'InvoiceID', 'Project', 'Status', 'Total', 'Invoice Date'];

        // Convert each member of the returned collection into an array,
        // and append it to the payments array.
        foreach ($invoices as $row) {
            $exportArray[] = $row->toArray();
        }

        // Generate and return the spreadsheet
        Excel::create('invoice', function ($excel) use ($exportArray) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Invoice');
            $excel->setCreator('Worksuite')->setCompany($this->companyName);
            $excel->setDescription('invoice file');

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('sheet1', function ($sheet) use ($exportArray) {
                $sheet->fromArray($exportArray, null, 'A1', false, false);

                $sheet->row(1, function ($row) {

                    // call row manipulation methods
                    $row->setFont(array(
                        'bold'       =>  true
                    ));
                });
            });
        })->download('xlsx');
    }

    public function getClient($projectID)
    {
        $companyName = Project::with('client')->first();
        return $companyName->client->company_name;
    }

    public function convertMilestone($id)
    {
        $this->invoice = ProjectMilestone::findOrFail($id);
        $this->lastInvoice = Invoice::orderBy('id', 'desc')->first();
        $this->invoiceSetting = InvoiceSetting::first();
        $this->lastInvoice = Invoice::count()+1;
        $this->projects = Project::all();
        $this->currencies = Currency::all();
        $this->taxes = Tax::all();
        $this->products = Product::all();
        $this->zero = '';
        if (strlen($this->lastInvoice) < $this->invoiceSetting->invoice_digit) {
            for ($i = 0; $i < $this->invoiceSetting->invoice_digit - strlen($this->lastInvoice); $i++) {
                $this->zero = '0' . $this->zero;
            }
        }
        return view('admin.invoices.convert_milestone', $this->data);
    }
}
