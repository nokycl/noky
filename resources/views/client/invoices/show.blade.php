@extends('layouts.client-app')

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
                <li><a href="{{ route('client.dashboard.index') }}">@lang("app.menu.home")</a></li>
                <li><a href="{{ route('client.invoices.index') }}">@lang("app.menu.invoices")</a></li>
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
    .displayNone {
        display: none;
    }
    .takeLeft {
        float: left;
    }
</style>
@endpush

@section('content')

    <div class="row">
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
                <div class="ribbon-content " id="invoice_container">
                    @if($invoice->status == 'paid')
                        <div class="ribbon ribbon-bookmark ribbon-success">@lang('modules.invoices.paid')</div>
                    @elseif($invoice->status == 'partial')
                        <div class="ribbon ribbon-bookmark ribbon-info">@lang('modules.invoices.partial')</div>
                    @else
                        <div class="ribbon ribbon-bookmark ribbon-danger">@lang('modules.invoices.unpaid')</div>
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
                                    <h3>To,</h3>
                                    <h4 class="font-bold">{{ ucwords($invoice->project->client->name) }}</h4>

                                    <p class="text-muted m-l-30">{!! nl2br($invoice->project->client->address) !!}</p>
                                    @if($invoiceSetting->show_gst == 'yes' && !is_null($invoice->project->client->gst_number))
                                        <p class="m-t-5"><b>@lang('app.gstIn')
                                                :</b>  {{ $invoice->project->client->gst_number }}
                                        </p>
                                    @endif
                                    <p class="m-t-30"><b>@lang('modules.invoices.invoiceDate') :</b> <i
                                                class="fa fa-calendar"></i> {{ $invoice->issue_date->format($global->date_format) }}
                                    </p>

                                    <p><b>@lang('modules.dashboard.dueDate') :</b> <i
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
                                                <td>{{ ucfirst($item->item_name) }}</td>
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
                            <div class="row">
                                <div class="col-md-6 text-left">
                                    @if($invoice->status == 'unpaid')

                                    <div class="form-group">
                                        <div class="radio-list">
                                            @if(($credentials->paypal_status == 'active' || $credentials->stripe_status == 'active'))
                                                <label class="radio-inline p-0">
                                                    <div class="radio radio-info">
                                                        <input checked onchange="showButton('online')" type="radio" name="method" id="radio13" value="high">
                                                        <label for="radio13">@lang('modules.client.online')</label>
                                                    </div>
                                                </label>
                                            @endif
                                            @if($methods->count() > 0)
                                                <label class="radio-inline">
                                                    <div class="radio radio-info">
                                                        <input type="radio" onchange="showButton('offline')"  name="method" id="radio15">
                                                        <label for="radio15">@lang('modules.client.offline')</label>
                                                    </div>
                                                </label>
                                            @endif
                                        </div>
                                    </div>
                                    {{--<div class="clearfix"></div>--}}
                                    <div class="col-md-12 p-l-0 text-left">
                                        @if(($credentials->paypal_status == 'active' || $credentials->stripe_status == 'active'))
                                            <div class="btn-group displayNone" id="onlineBox">
                                                <div class="dropup">
                                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    @lang('modules.invoices.payNow') <span class="caret"></span>
                                                </button>
                                                <ul role="menu" class="dropdown-menu">
                                                    @if($credentials->paypal_status == 'active')
                                                        <li>
                                                            <a href="{{ route('client.paypal', [$invoice->id]) }}"><i
                                                                        class="fa fa-paypal"></i> @lang('modules.invoices.payPaypal') </a>
                                                        </li>
                                                    @endif
                                                    @if($credentials->stripe_status == 'active')
                                                        <li class="divider"></li>
                                                        <li>
                                                            <a href="javascript:void(0);" id="stripePaymentButton"><i
                                                                        class="fa fa-cc-stripe"></i> @lang('modules.invoices.payStripe') </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                                </div>

                                            </div>
                                        @endif
                                        @if($methods->count() > 0)
                                            <div class="form-group displayNone" id="offlineBox">
                                                <div class="radio-list">
                                                    @forelse($methods as $key => $method)
                                                        <label class="radio-inline @if($key == 0) p-0 @endif">
                                                            <div class="radio radio-info" >
                                                                <input @if($key == 0) checked @endif onchange="showDetail('{{ $method->id }}')" type="radio" name="offlineMethod" id="offline{{$key}}"
                                                                    value="{{ $method->id }}">
                                                                <label for="offline{{$key}}" class="text-info" >
                                                                    {{ ucfirst($method->name) }} </label>
                                                            </div>
                                                            <div class="displayNone" id="method-desc-{{ $method->id }}">
                                                                {!! $method->description !!}
                                                            </div>
                                                        </label>
                                                    @empty
                                                    @endforelse
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 displayNone" id="methodDetail">
                                                    </div>

                                                @if(count($methods) > 0)
                                                    <div class="col-md-12">
                                                        <button type="button" class="btn btn-info save-offline">@lang('app.save')</button>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-6 text-right">

                                    <a class="btn btn-default btn-outline"
                                       href="{{ route('client.invoices.download', $invoice->id) }}"> <span><i
                                                    class="fa fa-file-pdf-o"></i> @lang('modules.invoices.downloadPdf')</span> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('footer-script')
<script src="https://checkout.stripe.com/checkout.js"></script>
<script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
<script>
    $(function () {
        @if(($credentials->paypal_status == 'active' || $credentials->stripe_status == 'active'))
            showButton('online');
        @else
                @if($methods->count() > 0)
        showButton('offline');
                @endif
        @endif
                if ($("#radio15").prop("checked")) {
                    showButton('offline');
                }

        var table = $('#invoices-table').dataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: '{{ route('client.invoices.create') }}',
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

    @if($credentials->stripe_status == 'active')
        var handler = StripeCheckout.configure({
            key: '{{ $credentials->stripe_client_id }}',
            image: '{{ is_null($global->logo) ? asset('worksuite-logo.png') : asset('user-uploads/app-logo/'.$global->logo) }}',
            locale: 'auto',
            token: function(token) {
                // You can access the token ID with `token.id`.
                // Get the token ID to your server-side code for use.
                $.easyAjax({
                    url: '{{route('client.stripe', [$invoice->id])}}',
                    container: '#invoice_container',
                    type: "POST",
                    redirect: true,
                    data: {token: token, "_token" : "{{ csrf_token() }}"}
                })
            }
        });

        document.getElementById('stripePaymentButton').addEventListener('click', function(e) {
            // Open Checkout with further options:
            handler.open({
                name: '{{ $companyName }}',
                amount: {{ $invoice->total*100 }},
                currency: '{{ $invoice->currency->currency_code }}',
                email: "{{ $user->email }}"

            });
            e.preventDefault();
        });

        // Close Checkout on page navigation:
        window.addEventListener('popstate', function() {
            handler.close();
        });



    @endif

    // Show offline method detail
    function showDetail(id){
        var detail = $('#method-desc-'+id).html();
        $('#methodDetail').html(detail);
        $('#methodDetail').show();
    }

    // Payment mode
    function showButton(type){

        if(type == 'online'){
            $('#methodDetail').hide();
            $('#offlineBox').hide();
            $('#onlineBox').show();
        }else{
            $('#offline0').change();
            $('#offlineBox').show();
            $('#onlineBox').hide();
        }
    }

    $('.save-offline').click(function() {
        console.log('sdsd')
        let offlineId = $("input[name=offlineMethod]").val();

        $.easyAjax({
            url: '{{ route('client.invoices.store') }}',
            type: "POST",
            redirect: true,
            data: {invoiceId: "{{ $invoice->id }}", "_token" : "{{ csrf_token() }}", "offlineId": offlineId}
        })

    })
</script>
@endpush