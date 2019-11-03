@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang("app.menu.home")</a></li>
                <li><a href="{{ route('admin.all-invoices.index') }}">@lang("app.menu.invoices")</a></li>
                <li class="active">@lang('app.invoice')</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">

<style>
    .ribbon-wrapper {
        background: #ffffff !important;
    }
</style>
@endpush

@section('content')

    <div class="row">
        <div class="col-md-3">
            <div class="white-box bg-inverse">
                <h3 class="box-title text-white">@lang('modules.payments.totalAmount')</h3>
                <ul class="list-inline two-part">
                    <li><i class="fa fa-money text-white"></i></li>
                    <li class="text-right"><span class="counter text-white">{{ $invoice->currency->currency_symbol}} {{ $invoice->total }}</span></li>
                </ul>
            </div>
        </div>
        <div class="col-md-3">
            <div class="white-box bg-success">
                <h3 class="box-title text-white">@lang('modules.payments.totalPaid')</h3>
                <ul class="list-inline two-part">
                    <li><i class="fa fa-money text-white"></i></li>
                    <li class="text-right"><span class="counter text-white">{{ $invoice->currency->currency_symbol}} @if($invoice->status == 'paid' && $paidAmount == 0){{ $invoice->total }} @else {{ $paidAmount }} @endif</span></li>
                </ul>
            </div>
        </div>
        <div class="col-md-3">
            <div class="white-box bg-danger">
                <h3 class="box-title text-white">@lang('modules.payments.totalDue')</h3>
                <ul class="list-inline two-part">
                    <li><i class="fa fa-money text-white"></i></li>
                    <li class="text-right"><span class="counter text-white">{{ $invoice->currency->currency_symbol}} @if($invoice->status == 'paid' && $paidAmount == 0) 0 @else {{ max(($invoice->total-$paidAmount),0) }} @endif</span></li>
                </ul>
            </div>
        </div>
        <div class="col-md-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                   <i class="fa fa-check"></i> {!! $message !!}
                </div>
                <?php Session::forget('success');?>
            @endif

            @if ($message = Session::get('error'))
                <div class="custom-alerts alert alert-danger fade in">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    {!! $message !!}
                </div>
                <?php Session::forget('error');?>
            @endif


            <div class="white-box printableArea ribbon-wrapper">
                <button type="button" onclick="showPayments()" class="btn btn-info pull-right">@lang('app.viewPayments')</button>
                <button type="button" data-clipboard-text="{{ route('front.invoice', [md5($invoice->id)]) }}" class="btn btn-success pull-right mr-5 btn-copy"><i class="fa fa-copy"></i> <span id="copy_payment_text">@lang('modules.invoices.copyPaymentLink')</span></button>
                <div class="clearfix"></div>
                <div class="ribbon-content ">
                    @if($invoice->credit_note)
                        <div class="ribbon ribbon-bookmark ribbon-warning">@lang('app.credit-note')</div>
                    @else
                        @if($invoice->status == 'paid')
                            <div class="ribbon ribbon-bookmark ribbon-success">@lang('modules.invoices.paid')</div>
                        @elseif($invoice->status == 'partial')
                            <div class="ribbon ribbon-bookmark ribbon-info">@lang('modules.invoices.partial')</div>
                        @else
                            <div class="ribbon ribbon-bookmark ribbon-danger">@lang('modules.invoices.unpaid')</div>
                        @endif
                    @endif

                    <h3><b>@lang('app.invoice')</b> <span class="pull-right">{{ $invoice->invoice_number }}</span></h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">

                            <div class="pull-left">
                                <address>
                                    <h3> &nbsp;<b class="text-danger">{{ ucwords($global->company_name) }}</b></h3>
                                    @if(!is_null($settings))
                                        <p class="text-muted m-l-5">{!! nl2br($global->address) !!}</p>
                                    @endif
                                    @if($invoiceSetting->show_gst == 'yes' && !is_null($invoiceSetting->gst_number))
                                        <p class="text-muted m-l-5"><b>@lang('app.gstIn')
                                                :</b>{{ $invoiceSetting->gst_number }}</p>
                                    @endif
                                </address>
                            </div>
                            <div class="pull-right text-right">
                                <address>
                                    @if(!is_null($invoice->project->client))
                                        <h3>To,</h3>
                                        <h4 class="font-bold">{{ ucwords($invoice->project->client->name) }}</h4>

                                        <p class="text-muted m-l-30">{!! nl2br($invoice->project->client->address) !!}</p>
                                        @if($invoiceSetting->show_gst == 'yes' && !is_null($invoice->project->client->gst_number))
                                            <p class="m-t-5"><b>@lang('app.gstIn')
                                                    :</b>  {{ $invoice->project->client->gst_number }}
                                            </p>
                                        @endif
                                    @endif

                                    <p class="m-t-30"><b>@lang('app.invoice') @lang('app.date') :</b> <i
                                                class="fa fa-calendar"></i> {{ $invoice->issue_date->format($global->date_format) }}
                                    </p>

                                    <p><b>@lang('app.dueDate') :</b> <i
                                                class="fa fa-calendar"></i> {{ $invoice->due_date->format($global->date_format) }}
                                    </p>
                                    @if($invoice->recurring == 'yes')
                                        <p><b class="text-danger">@lang('modules.invoices.billingFrequency') : </b> {{ $invoice->billing_interval . ' '. ucfirst($invoice->billing_frequency) }} ({{ ucfirst($invoice->billing_cycle) }} cycles)</p>
                                    @endif
                                </address>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive m-t-40" style="clear: both;">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>@lang("modules.invoices.item")</th>
                                        <th class="text-right">@lang("modules.invoices.qty")</th>
                                        <th class="text-right">@lang("modules.invoices.unitPrice")</th>
                                        <th class="text-right">@lang("modules.invoices.price")</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $count = 0; ?>
                                    @foreach($invoice->items as $item)
                                        @if($item->type == 'item')
                                            <tr>
                                                <td class="text-center">{{ ++$count }}</td>
                                                <td>{{ ucfirst($item->item_name) }}
                                                    @if(!is_null($item->item_summary))
                                                        <p class="font-12">{{ $item->item_summary }}</p>
                                                    @endif
                                                </td>
                                                <td class="text-right">{{ $item->quantity }}</td>
                                                <td class="text-right"> {!! htmlentities($invoice->currency->currency_symbol)  !!}{{ $item->unit_price }} </td>
                                                <td class="text-right"> {!! htmlentities($invoice->currency->currency_symbol)  !!}{{ $item->amount }} </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="pull-right m-t-30 text-right">
                                <p>@lang("modules.invoices.subTotal")
                                    : {!! htmlentities($invoice->currency->currency_symbol)  !!}{{ $invoice->sub_total }}</p>

                                <p>@lang("modules.invoices.discount")
                                    : {!! htmlentities($invoice->currency->currency_symbol)  !!}{{ $discount }} </p>
                                @foreach($taxes as $key=>$tax)
                                    <p>{{ strtoupper($key) }}
                                        : {!! htmlentities($invoice->currency->currency_symbol)  !!}{{ $tax }} </p>
                                @endforeach
                                <hr>
                                <h3><b>@lang("modules.invoices.total")
                                        :</b> {!! htmlentities($invoice->currency->currency_symbol)  !!}{{ $invoice->total }}
                                </h3>
                            </div>

                            @if(!is_null($invoice->note))
                                <div class="col-md-12">
                                    <p><strong>@lang('app.note')</strong>: {{ $invoice->note }}</p>
                                </div>
                            @endif
                            <div class="clearfix"></div>

                            <hr>
                            <div class="text-right">

                                <a class="btn btn-default btn-outline"
                                   href="{{ route('admin.all-invoices.download', $invoice->id) }}"> <span><i class="fa fa-file-pdf-o"></i> @lang('modules.invoices.downloadPdf')</span> </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{--Ajax Modal--}}
    <div class="modal fade bs-modal-md in" id="paymentDetail" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
                </div>
                <div class="modal-body">
                    @lang('app.loading')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal">@lang('app.close')</button>
                    <button type="button" class="btn blue">@lang('app.save') @lang('app.changes')</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--Ajax Modal Ends--}}

@endsection

@push('footer-script')
<script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/clipboard/clipboard.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
<script>

    var clipboard = new ClipboardJS('.btn-copy');

    clipboard.on('success', function(e) {
        var copied = "<?php echo __("app.copied") ?>";
        // $('#copy_payment_text').html(copied);
        $.toast({
            heading: 'Success',
            text: copied,
            position: 'top-right',
            loaderBg:'#ff6849',
            icon: 'success',
            hideAfter: 3500
        });
    });

    $(function () {
        var table = $('#invoices-table').dataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.all-invoices.create') }}',
            deferRender: true,
            "order": [[0, "desc"]],
            language: {
                "url": "<?php echo __("app.datatable") ?>"
            },
            "fnDrawCallback": function (oSettings) {
                $("body").tooltip({
                    selector: '[data-toggle="tooltip"]'
                });
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'project_name', name: 'projects.project_name'},
                {data: 'invoice_number', name: 'invoice_number'},
                {data: 'currency_symbol', name: 'currencies.currency_symbol'},
                {data: 'total', name: 'total'},
                {data: 'issue_date', name: 'issue_date'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

    });

    // Show Payment detail modal
    function showPayments() {
        var url = '{{route('admin.all-invoices.payment-detail', $invoice->id)}}';
        $.ajaxModal('#paymentDetail', url);
    }

</script>
@endpush