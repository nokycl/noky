<?php

namespace App\Http\Controllers\Admin;

use App\ClientDetails;
use App\Currency;
use App\Estimate;
use App\EstimateItem;
use App\Helper\Reply;
use App\Http\Requests\StoreEstimate;
use App\InvoiceSetting;
use App\Notifications\NewEstimate;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use App\Tax;
use App\Product;

class ManageEstimatesController extends AdminBaseController
{
    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.estimates';
        $this->pageIcon = 'ti-file';
        $this->middleware(function ($request, $next) {
            if(!in_array('estimates',$this->user->modules)){
                abort(403);
            }
            return $next($request);
        });

    }

    public function index() {
        return view('admin.estimates.index', $this->data);
    }

    public function create() {
        $this->clients = ClientDetails::all();
//        dd($this->clients);
        $this->currencies = Currency::all();
        $this->lastEstimate = Estimate::count()+1;
        $this->invoiceSetting = InvoiceSetting::first();
        $this->zero = '';
        if (strlen($this->lastEstimate) < $this->invoiceSetting->estimate_digit){
            for ($i=0; $i<$this->invoiceSetting->estimate_digit-strlen($this->lastEstimate); $i++){
                $this->zero = '0'.$this->zero;
            }
        }
        $this->taxes = Tax::all();
        $this->products = Product::all();
        return view('admin.estimates.create', $this->data);
    }

    public function store(StoreEstimate $request)
    {
        /*dd($request->all());*/
        DB::beginTransaction();
        $items = $request->input('item_name');
        $itemsSummary = $request->input('item_summary');
        $cost_per_item = $request->input('cost_per_item');
        $quantity = $request->input('quantity');
        $amount = $request->input('amount');
        $tax = $request->input('taxes');

        if (trim($items[0]) == '' || trim($items[0]) == '' || trim($cost_per_item[0]) == '') {
            return Reply::error(__('messages.addItem'));
        }

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

        $estimate = new Estimate();
        $estimate->client_id = $request->client_id;
        $estimate->estimate_number = Estimate::count()+1;
        $estimate->valid_till = Carbon::parse($request->valid_till)->format('Y-m-d');
        $estimate->sub_total = round($request->sub_total, 2);
        $estimate->total = round($request->total, 2);
        $estimate->currency_id = $request->currency_id;
        $estimate->note = $request->note;
        $estimate->discount = round($request->discount_value, 2);
        $estimate->discount_type = $request->discount_type;
        $estimate->status = 'waiting';
        /*dd($estimate->estimate_number);*/
        $estimate->save();

        foreach ($items as $key => $item):
            if (!is_null($item)) {
                EstimateItem::create(
                    [
                        'estimate_id' => $estimate->id,
                        'item_name' => $item,
                        'item_summary' => $itemsSummary[$key],
                        'type' => 'item',
                        'quantity' => $quantity[$key],
                        'unit_price' => round($cost_per_item[$key], 2),
                        'amount' => round($amount[$key], 2),
                        'tax_id' => $tax[$key]
                    ]
                );
            }
        endforeach;

        $this->logSearchEntry($estimate->id, 'Estimate #'.$estimate->id, 'admin.estimates.edit');
        DB::commit();

        // Notify client
        $notifyUser = User::withoutGlobalScopes()->findOrFail($estimate->client_id);
        $notifyUser->notify(new NewEstimate($estimate));

        return Reply::redirect(route('admin.estimates.index'), __('messages.estimateCreated'));

    }

    public function edit($id) {
        $this->estimate = Estimate::findOrFail($id);
        $this->clients = ClientDetails::all();
        $this->currencies = Currency::all();
        $this->taxes = Tax::all();
        $this->products = Product::all();
        return view('admin.estimates.edit', $this->data);
    }

    public function update(StoreEstimate $request, $id)
    {
        $items = $request->input('item_name');
        $itemsSummary = $request->input('item_summary');
        $cost_per_item = $request->input('cost_per_item');
        $quantity = $request->input('quantity');
        $amount = $request->input('amount');
        $tax = $request->input('taxes');


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
                return Reply::error(__('messages.amountNumber'));
            }
        }

        foreach ($items as $itm) {
            if (is_null($itm)) {
                return Reply::error(__('messages.itemBlank'));
            }
        }


        $estimate = Estimate::findOrFail($id);
        $estimate->client_id = $request->client_id;
        $estimate->valid_till = Carbon::parse($request->valid_till)->format('Y-m-d');
        $estimate->sub_total = round($request->sub_total, 2);
        $estimate->total = round($request->total, 2);
        $estimate->currency_id = $request->currency_id;
        $estimate->status = $request->status;
        $estimate->discount = round($request->discount_value, 2);
        $estimate->discount_type = $request->discount_type;
        $estimate->note = $request->note;
        $estimate->save();

        // delete and create new
        EstimateItem::where('estimate_id', $estimate->id)->delete();

        foreach ($items as $key => $item):
            EstimateItem::create(
                [
                    'estimate_id' => $estimate->id,
                    'item_name' => $item,
                    'item_summary' => $itemsSummary[$key],
                    'quantity' => $quantity[$key],
                    'unit_price' => round($cost_per_item[$key], 2),
                    'amount' => round($amount[$key], 2),
                    'tax_id' => $tax[$key]
                ]
            );
        endforeach;

        // Notify client
        $notifyUser = User::withoutGlobalScopes()->findOrFail($estimate->client_id);
        $notifyUser->notify(new NewEstimate($estimate));

        return Reply::redirect(route('admin.estimates.index'), __('messages.estimateUpdated'));

    }

    public function data(Request $request) {
        $firstEstimate = Estimate::orderBy('id', 'desc')->first();
        $invoices = Estimate::join('client_details', 'estimates.client_id', '=', 'client_details.user_id')
            ->join('currencies', 'currencies.id', '=', 'estimates.currency_id')
            ->select('estimates.id', 'estimates.client_id', 'client_details.company_name as name', 'estimates.total', 'currencies.currency_symbol', 'estimates.status', 'estimates.valid_till', 'estimates.estimate_number');

        if($request->startDate !== null && $request->startDate != 'null' && $request->startDate != ''){
              $invoices = $invoices->where(DB::raw('DATE(estimates.`valid_till`)'), '>=', $request->startDate);
        }

        if($request->endDate !== null && $request->endDate != 'null' && $request->endDate != ''){
            $invoices = $invoices->where(DB::raw('DATE(estimates.`valid_till`)'), '<=', $request->endDate);
        }

        if($request->status != 'all' && !is_null($request->status)){
            $invoices = $invoices->where('estimates.status', '=', $request->status);
        }

        $invoices = $invoices->orderBy('estimates.id', 'desc')->get();

        return DataTables::of($invoices)
            ->addIndexColumn()
            ->addColumn('action', function ($row) use($firstEstimate) {
                $action = '<div class="btn-group m-r-10">
                <button aria-expanded="false" data-toggle="dropdown" class="btn btn-info btn-outline  dropdown-toggle waves-effect waves-light" type="button">Action <span class="caret"></span></button>
                <ul role="menu" class="dropdown-menu">
                  <li><a href="' . route("admin.estimates.download", $row->id) . '" ><i class="fa fa-download"></i> Download</a></li>
                  <li><a href="' . route("admin.estimates.edit", $row->id) . '" ><i class="fa fa-pencil"></i> Edit</a></li>';
                if($firstEstimate->id == $row->id){
                    $action .= '<li><a class="sa-params" href="javascript:;" data-estimate-id="' . $row->id . '"><i class="fa fa-times"></i> Delete</a></li>';
                }
                if ($row->status == 'waiting'){
                    $action .= '<li><a href="'.route("admin.all-invoices.convert-estimate", $row->id) .'" ><i class="ti-receipt"></i> Create Invoice</a></li>';
                }
                $action .= '</ul>
              </div>
              ';
                return $action;
            })
            ->editColumn('name', function ($row) {
                return '<a href="' . route('admin.clients.projects', $row->client_id) . '">' . ucwords($row->name) . '</a>';
            })
            ->editColumn('status', function ($row) {
                if($row->status == 'waiting'){
                    return '<label class="label label-warning">'.strtoupper($row->status).'</label>';
                }
                if($row->status == 'declined'){
                    return '<label class="label label-danger">'.strtoupper($row->status).'</label>';
                }else{
                    return '<label class="label label-success">'.strtoupper($row->status).'</label>';
                }
            })
            ->editColumn('total', function ($row) {
                return $row->currency_symbol . $row->total;
            })
            ->editColumn(
                'valid_till',
                function ($row) {
                    return Carbon::parse($row->valid_till)->format($this->global->date_format);
                }
            )
            ->rawColumns(['name', 'action', 'status'])
            ->removeColumn('currency_symbol')
            ->removeColumn('client_id')
            ->make(true);
    }

    public function destroy($id) {
        $firstEstimate = Estimate::orderBy('id', 'desc')->first();
        if ($firstEstimate->id == $id)
        {
            Estimate::destroy($id);
            return Reply::success(__('messages.estimateDeleted'));
        }
        else{
            return Reply::error(__('messages.estimateCanNotDeleted'));
        }
    }


    public function download($id) {
//        header('Content-type: application/pdf');

        $this->estimate = Estimate::findOrFail($id);
//        dd($this->estimate->client->client[0]->company_name or ucwords($this->estimate->client->name));
        $this->discount = EstimateItem::where('type', 'discount')
            ->where('estimate_id', $this->estimate->id)
            ->sum('amount');
        $this->taxes = EstimateItem::where('type', 'tax')
            ->where('estimate_id', $this->estimate->id)
            ->get();

        $this->settings = $this->company;

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.estimates.estimate-pdf', $this->data);
        $filename = $this->estimate->estimate_number;
    //    return $pdf->stream();
        return $pdf->download($filename . '.pdf');
    }

    public function export($startDate, $endDate, $status) {

        $invoices = Estimate::join('client_details', 'estimates.client_id', '=', 'client_details.user_id')
            ->join('currencies', 'currencies.id', '=', 'estimates.currency_id')
            ->select('estimates.id', 'client_details.company_name as name', 'estimates.total', 'currencies.currency_symbol', 'estimates.status', 'estimates.valid_till');

        if($startDate !== null && $startDate != 'null' && $startDate != ''){
            $invoices = $invoices->where(DB::raw('DATE(estimates.`valid_till`)'), '>=', $startDate);
        }

        if($endDate !== null && $endDate != 'null' && $endDate != ''){
            $invoices = $invoices->where(DB::raw('DATE(estimates.`valid_till`)'), '<=', $endDate);
        }

        if($status != 'all' && !is_null($status)){
            $invoices = $invoices->where('estimates.status', '=', $status);
        }

        $attributes =  ['total', 'currency_symbol', 'valid_till'];

        $invoices = $invoices->orderBy('estimates.id', 'desc')->get()->makeHidden($attributes);

        // Initialize the array which will be passed into the Excel
        // generator.
        $exportArray = [];

        // Define the Excel spreadsheet headers
        $exportArray[] = ['ID', 'Client','Status','Total', 'Valid Date'];

        // Convert each member of the returned collection into an array,
        // and append it to the payments array.
        foreach ($invoices as $row) {
            $exportArray[] = $row->toArray();
        }

        // Generate and return the spreadsheet
        Excel::create('estimate', function($excel) use ($exportArray) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Estimate');
            $excel->setCreator('Worksuite')->setCompany($this->companyName);
            $excel->setDescription('estimate file');

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('sheet1', function($sheet) use ($exportArray) {
                $sheet->fromArray($exportArray, null, 'A1', false, false);

                $sheet->row(1, function($row) {

                    // call row manipulation methods
                    $row->setFont(array(
                        'bold'       =>  true
                    ));

                });

            });

        })->download('xlsx');
    }

}
