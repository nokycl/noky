<?php

namespace App\Http\Controllers\Client;

use App\Estimate;
use App\EstimateItem;
use App\ModuleSetting;
use App\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ClientEstimateController extends ClientBaseController
{
    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.estimates';
        $this->pageIcon = 'icon-doc';
        $this->middleware(function ($request, $next) {
            if(!in_array('estimates',$this->user->modules)){
                abort(403);
            }
            return $next($request);
        });

    }

    public function index() {
        return view('client.estimates.index', $this->data);
    }

    public function create() {
        $invoices = Estimate::join('currencies', 'currencies.id', '=', 'estimates.currency_id')
            ->select('estimates.id', 'estimates.client_id', 'estimates.total', 'currencies.currency_symbol', 'estimates.status', 'estimates.valid_till')
            ->where('estimates.client_id', $this->user->id)
            ->orderBy('estimates.id', 'desc')
            ->get();

        return DataTables::of($invoices)
            ->addColumn('action', function ($row) {
                return '<a href="' . route("client.estimates.download", $row->id) . '" data-toggle="tooltip" data-original-title="Download" class="btn btn-inverse btn-circle"><i class="fa fa-download"></i></a>';
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
            ->rawColumns([ 'action', 'status'])
            ->removeColumn('currency_symbol')
            ->removeColumn('client_id')
            ->make(true);
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
        $pdf->loadView('client.estimates.estimate-pdf', $this->data);
        $filename = 'estimate-'.$this->estimate->id;
//        return $pdf->stream();
        return $pdf->download($filename . '.pdf');
    }

}
