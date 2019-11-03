<?php

namespace App\Http\Controllers\Member;

use App\ClientDetails;
use App\Currency;
use App\Estimate;
use App\EstimateItem;
use App\Helper\Reply;
use App\Http\Controllers\Member\MemberBaseController;
use App\Http\Requests\StoreEstimate;
use App\Notifications\NewEstimate;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Tax;
use App\Product;
use App\InvoiceSetting;

class MemberEstimatesController extends MemberBaseController
{
    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.estimates';
        $this->pageIcon = 'ti-file';
        $this->middleware(function ($request, $next) {
            if (!in_array('estimates',$this->user->modules)) {
                abort(403);
            }
            return $next($request);
        });
    }

    public function index() {
        if(!$this->user->can('view_estimates')){
            abort(403);
        }
        return view('member.estimates.index', $this->data);
    }

    public function create() {
        if (!$this->user->can('add_estimates')) {
            abort(403);
        }
        $this->clients = ClientDetails::all();
        $this->currencies = Currency::all();
        $this->lastEstimate = Estimate::count()+1;
        $this->invoiceSetting = InvoiceSetting::first();
        $this->zero = '';
        if (strlen($this->lastEstimate) < $this->invoiceSetting->estimate_digit) {
            for ($i = 0; $i < $this->invoiceSetting->estimate_digit - strlen($this->lastEstimate); $i++) {
                $this->zero = '0' . $this->zero;
            }
        }
        $this->taxes = Tax::all();
        $this->products = Product::all();
        return view('member.estimates.create', $this->data);
    }

    public function store(StoreEstimate $request)
    {
//        dd($request->all());
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
            if (!is_numeric($qty)) {
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
//        dd([round($request->sub_total,2), round($request->total, 2)]);
        $estimate = new Estimate();
        $estimate->client_id = $request->client_id;
        $estimate->valid_till = Carbon::parse($request->valid_till)->format('Y-m-d');
        $estimate->sub_total = round($request->sub_total, 2);
        $estimate->total = round($request->total, 2);
        $estimate->currency_id = $request->currency_id;
        $estimate->note = $request->note;
        $estimate->discount = round($request->discount_value, 2);
        $estimate->discount_type = $request->discount_type;
        $estimate->status = 'waiting';
        $lastEstimate = Estimate::count();
        $estimate->estimate_number = $lastEstimate+1;

        $estimate->status = 'waiting';
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

        // Notify client
        $notifyUser = User::withoutGlobalScopes()->findOrFail($estimate->client_id);
        $notifyUser->notify(new NewEstimate($estimate));

        return Reply::redirect(route('member.estimates.index'), __('messages.estimateCreated'));

    }

    public function edit($id) {
        if (!$this->user->can('edit_estimates')) {
            abort(403);
        }
        $this->estimate = Estimate::findOrFail($id);
        $this->clients = ClientDetails::all();
        $this->currencies = Currency::all();
        $this->taxes = Tax::all();
        $this->products = Product::all();
        return view('member.estimates.edit', $this->data);
    }

    public function update(StoreEstimate $request, $id)
    {
        $items = $request->input('item_name');
        $cost_per_item = $request->input('cost_per_item');
        $itemsSummary = $request->input('item_summary');
        $quantity = $request->input('quantity');
        $amount = $request->input('amount');
        $type = $request->input('type');
        $tax = $request->input('taxes');

        if (trim($items[0]) == '' || trim($items[0]) == '' || trim($cost_per_item[0]) == '') {
            return Reply::error(__('messages.addItem'));
        }

        foreach ($quantity as $qty) {
            if (!is_numeric($qty)) {
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
        $estimate->discount = round($request->discount_value, 2);
        $estimate->discount_type = $request->discount_type;
        $estimate->status = $request->status;
        $estimate->note = $request->note;
        $estimate->save();

        // Notify client
        $notifyUser = User::withoutGlobalScopes()->findOrFail($estimate->client_id);
        $notifyUser->notify(new NewEstimate($estimate));

        // delete and create new
        EstimateItem::where('estimate_id', $estimate->id)->delete();

        foreach ($items as $key => $item):
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
        endforeach;

        return Reply::redirect(route('member.estimates.index'), __('messages.estimateUpdated'));

    }

    public function data(Request $request) {
        $invoices = Estimate::join('users', 'estimates.client_id', '=', 'users.id')
            ->join('currencies', 'currencies.id', '=', 'estimates.currency_id')
            ->select('estimates.id', 'estimates.client_id', 'users.name', 'estimates.total', 'currencies.currency_symbol', 'estimates.status', 'estimates.valid_till');

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
            ->addColumn('action', function ($row) {
                $action = '<div class="btn-group m-r-10">
                <button aria-expanded="false" data-toggle="dropdown" class="btn btn-info btn-outline  dropdown-toggle waves-effect waves-light" type="button">Action <span class="caret"></span></button>
                <ul role="menu" class="dropdown-menu">';
                if($this->user->can('view_estimates')){
                    $action.= '<li><a href="' . route("member.estimates.download", $row->id) . '" ><i class="fa fa-download"></i> Download</a></li>';
                }

                if($this->user->can('edit_estimates')) {
                    $action .= '<li><a href="' . route("member.estimates.edit", $row->id) . '" ><i class="fa fa-pencil"></i> Edit</a></li>';
                }

                if($this->user->can('delete_estimates')){
                    $action.= '<li><a class="sa-params" href="javascript:;" data-estimate-id="' . $row->id . '"><i class="fa fa-times"></i> Delete</a></li>';
                }

                if($this->user->can('add_invoices')){
                    $action.= '<li><a href="'.route("member.all-invoices.convert-estimate", $row->id) .'" ><i class="ti-receipt"></i> Create Invoice</a></li>';
                }
                $action.= '</ul></div>';

                return $action;
            })
            ->editColumn('name', function ($row) {
                return '<a href="' . route('member.clients.projects', $row->client_id) . '">' . ucwords($row->name) . '</a>';
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
                    return Carbon::parse($row->valid_till)->format('d F, Y');
                }
            )
            ->rawColumns(['name', 'action', 'status'])
            ->removeColumn('currency_symbol')
            ->removeColumn('client_id')
            ->make(true);
    }

    public function destroy($id) {
        Estimate::destroy($id);
        return Reply::success(__('messages.estimateDeleted'));
    }


    public function download($id) {
//        header('Content-type: application/pdf');

        $this->estimate = Estimate::findOrFail($id);
        $this->discount = EstimateItem::where('type', 'discount')
            ->where('estimate_id', $this->estimate->id)
            ->sum('amount');
        $this->taxes = EstimateItem::where('type', 'tax')
            ->where('estimate_id', $this->estimate->id)
            ->get();

        $this->settings = $this->global;

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('member.estimates.estimate-pdf', $this->data);
        $filename = 'estimate-'.$this->estimate->id;
//        return $pdf->stream();
        return $pdf->download($filename . '.pdf');
    }

}
