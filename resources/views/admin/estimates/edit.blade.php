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
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
                <li><a href="{{ route('admin.estimates.index') }}">{{ __($pageTitle) }}</a></li>
                <li class="active">@lang('app.update')</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
    .dropdown-content {
        width: 250px;
        max-height: 250px;
        overflow-y: scroll;
        overflow-x: hidden;
    }
</style>
@endpush

@section('content')

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-inverse">
                <div class="panel-heading"> @lang('modules.estimates.updateEstimate')</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        {!! Form::open(['id'=>'updatePayments','class'=>'ajax-form','method'=>'PUT']) !!}
                        <div class="form-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">@lang('modules.estimates.estimatesNumber')</label>
                                        <div class="input-icon">
                                            <input type="text" readonly class="form-control" name="estimate_number" id="estimate_number" value="{{ $estimate->estimate_number }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">@lang('app.client')</label>
                                        <select class="select2 form-control" data-placeholder="Choose Client"
                                                name="client_id">
                                            @foreach($clients as $client)
                                                <option
                                                        @if($estimate->client_id == $client->user_id) selected
                                                        @endif
                                                        value="{{ $client->user_id }}">{{ ucwords($client->company_name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">@lang('modules.invoices.currency')</label>
                                        <select class="form-control" name="currency_id" id="currency_id">
                                            @foreach($currencies as $currency)
                                                <option
                                                        @if($estimate->currency_id == $currency->id) selected
                                                        @endif
                                                        value="{{ $currency->id }}">{{ $currency->currency_symbol.' ('.$currency->currency_code.')' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">@lang('modules.estimates.validTill')</label>
                                        <div class="input-icon">
                                            <input type="text" class="form-control" name="valid_till" id="valid_till"
                                                   value="{{ $estimate->valid_till->format('m/d/Y') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">@lang('app.status')</label>
                                        <select class="form-control" name="status" id="status">
                                            <option
                                                    @if($estimate->status == 'accepted') selected @endif
                                            value="accepted">@lang('modules.estimates.accepted')
                                            </option>
                                            <option
                                                    @if($estimate->status == 'waiting') selected @endif
                                            value="waiting">@lang('modules.estimates.waiting')
                                            </option>
                                            <option
                                                    @if($estimate->status == 'declined') selected @endif
                                            value="declined">@lang('modules.estimates.declined')
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="btn-group m-b-10">
                                        <button aria-expanded="false" data-toggle="dropdown" class="btn btn-info dropdown-toggle waves-effect waves-light" type="button">@lang('app.menu.products') <span class="caret"></span></button>
                                        <ul role="menu" class="dropdown-menu dropdown-content">
                                            @foreach($products as $product)
                                                <li class="m-b-10">
                                                    <div class="row m-t-10">
                                                        <div class="col-md-6" style="padding-left: 30px">
                                                            {{ $product->name }}
                                                        </div>
                                                        <div class="col-md-6" style="text-align: right;padding-right: 30px;">
                                                            <a href="javascript:;" data-pk="{{ $product->id }}" class="btn btn-success btn btn-outline btn-xs waves-effect add-product">@lang('app.add') <i class="fa fa-plus" aria-hidden="true"></i></a>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">

                                <div class="col-xs-12  visible-md visible-lg">

                                        <div class="col-md-4 font-bold" style="padding: 8px 15px">
                                            @lang('modules.invoices.item')
                                        </div>
    
                                        <div class="col-md-1 font-bold" style="padding: 8px 15px">
                                            @lang('modules.invoices.qty')
                                        </div>
    
                                        <div class="col-md-2 font-bold" style="padding: 8px 15px">
                                            @lang('modules.invoices.unitPrice')
                                        </div>
    
                                        <div class="col-md-2 font-bold" style="padding: 8px 15px">
                                            @lang('modules.invoices.tax') <a href="javascript:;" id="tax-settings" ><i class="ti-settings text-info"></i></a>
                                        </div>
    
                                        <div class="col-md-2 text-center font-bold" style="padding: 8px 15px">
                                            @lang('modules.invoices.amount')
                                        </div>
    
                                        <div class="col-md-1" style="padding: 8px 15px">
                                            &nbsp;
                                        </div>

                                </div>

                                <div id="sortable">
                                @foreach($estimate->items as $item)
                                    <div class="col-xs-12 item-row margin-top-5">
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.item')</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></div>
                                                        <input type="text" class="form-control item_name" name="item_name[]"
                                                            value="{{ $item->item_name }}" >
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                <textarea name="item_summary[]" class="form-control" placeholder="@lang('app.description')" rows="2">{{ $item->item_summary }}</textarea>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-1">

                                            <div class="form-group">
                                                <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.qty')</label>
                                                <input type="number" min="1" class="form-control quantity"
                                                    value="{{ $item->quantity }}" name="quantity[]"
                                                    >
                                            </div>


                                        </div>

                                        <div class="col-md-2">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.unitPrice')</label>
                                                    <input type="text" min="" class="form-control cost_per_item"
                                                        name="cost_per_item[]" value="{{ $item->unit_price }}"
                                                        >
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-2">

                                            <div class="form-group">
                                                <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.type')</label>
                                                <select name="taxes[]" class="form-control type">
                                                    <option value="">@lang('app.zero') @lang('modules.invoices.tax')</option>
                                                    @foreach($taxes as $tax)
                                                        <option
                                                                @if($item->tax_id == $tax->id) selected @endif
                                                                data-rate="{{ $tax->rate_percent }}" value="{{ $tax->id }}">{{ $tax->tax_name }}: {{ $tax->rate_percent }}%</option>
                                                    @endforeach
                                                </select>
                                            </div>


                                        </div>

                                        <div class="col-md-2 border-dark  text-center">
                                            <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.amount')</label>
                                            <p class="form-control-static"><span
                                                        class="amount-html">{{ number_format((float)$item->amount, 2, '.', '') }}</span></p>
                                            <input type="hidden" value="{{ $item->amount }}" class="amount"
                                                name="amount[]">
                                        </div>

                                        <div class="col-md-1 text-right visible-md visible-lg">
                                            <button type="button" class="btn remove-item btn-circle btn-danger"><i
                                                        class="fa fa-remove"></i></button>
                                        </div>
                                        <div class="col-md-1 hidden-md hidden-lg">
                                            <div class="row">
                                                <button type="button" class="btn btn-circle remove-item btn-danger"><i
                                                            class="fa fa-remove"></i> @lang('app.remove')
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                                </div>

                                <div id="item-list">

                                </div>

                                <div class="col-xs-12 m-t-5">
                                    <button type="button" class="btn btn-info" id="add-item"><i class="fa fa-plus"></i>
                                        @lang('modules.invoices.addItem')
                                    </button>
                                </div>

                                <div class="col-xs-12 ">
                                        <div class="row">
                                            <div class="col-md-offset-9 col-xs-6 col-md-1 text-right p-t-10">@lang('modules.invoices.subTotal')</div>
    
                                            <p class="form-control-static col-xs-6 col-md-2">
                                                <span class="sub-total">{{ number_format((float)$estimate->sub_total, 2, '.', '') }}</span>
                                            </p>
    
    
                                            <input type="hidden" class="sub-total-field" name="sub_total" value="{{ $estimate->sub_total }}">
                                        </div>
    
                                        <div class="row">
                                            <div class="col-md-offset-9 col-md-1 text-right p-t-10">
                                                @lang('modules.invoices.discount')
                                            </div>
                                            <div class="form-group col-xs-6 col-md-1" >
                                                <input type="number" min="0" value="{{ $estimate->discount }}" name="discount_value" class="form-control discount_value" >
                                            </div>
                                            <div class="form-group col-xs-6 col-md-1" >
                                                <select class="form-control" name="discount_type" id="discount_type">
                                                    <option
                                                            @if($estimate->discount_type == 'percent') selected @endif
                                                            value="percent">%</option>
                                                    <option
                                                            @if($estimate->discount_type == 'fixed') selected @endif
                                                    value="fixed">@lang('modules.invoices.amount')</option>
                                                </select>
                                            </div>
                                        </div>
    
                                        <div class="row m-t-5" id="invoice-taxes">
                                            <div class="col-md-offset-9 col-md-1 text-right p-t-10">
                                                @lang('modules.invoices.tax')
                                            </div>
    
                                            <p class="form-control-static col-xs-6 col-md-2" >
                                                <span class="tax-percent">0</span>
                                            </p>
                                        </div>
    
                                        <div class="row m-t-5 font-bold">
                                            <div class="col-md-offset-9 col-md-1 col-xs-6 text-right p-t-10">@lang('modules.invoices.total')</div>
    
                                            <p class="form-control-static col-xs-6 col-md-2">
                                                <span class="total">{{ number_format((float)$estimate->total, 2, '.', '') }}</span>
                                            </p>
    
    
                                            <input type="hidden" class="total-field" name="total"
                                                    value="{{ round($estimate->total, 2) }}">
                                        </div>
    
                                    </div>

                            </div>
                            <div class="row">

                                <div class="col-sm-12">

                                    <div class="form-group">
                                        <label class="control-label">@lang('app.note')</label>

                                        <textarea name="note" class="form-control" rows="5">{{ $estimate->note }}</textarea>
                                    </div>

                                </div>

                            </div>

                        </div>
                        <div class="form-actions" style="margin-top: 70px">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" id="save-form" class="btn btn-success"><i
                                                class="fa fa-check"></i> @lang('app.save')
                                    </button>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>    <!-- .row -->

    {{--Ajax Modal--}}
    <div class="modal fade bs-modal-md in" id="taxModal" role="dialog" aria-labelledby="myModalLabel"
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
<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

<script>
    $(function () {
        $( "#sortable" ).sortable();
    });
    $(".select2").select2({
        formatNoMatches: function () {
            return "{{ __('messages.noRecordFound') }}";
        }
    });

    jQuery('#valid_till').datepicker({
        autoclose: true,
        todayHighlight: true
    });

    $('#save-form').click(function () {
        $.easyAjax({
            url: '{{route('admin.estimates.update', $estimate->id)}}',
            container: '#updatePayments',
            type: "POST",
            redirect: true,
            data: $('#updatePayments').serialize()
        })
    });

    $('#add-item').click(function () {
        var item = '<div class="col-xs-12 item-row margin-top-5">'

            +'<div class="col-md-4">'
            +'<div class="row">'
            +'<div class="form-group">'
            +'<label class="control-label hidden-md hidden-lg">@lang('modules.invoices.item')</label>'
            +'<div class="input-group">'
            +'<div class="input-group-addon"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></div>'
            +'<input type="text" class="form-control item_name" name="item_name[]" >'
            +'</div>'

            +'</div>'
            +'<div class="form-group">'
            +'<textarea name="item_summary[]" class="form-control" placeholder="@lang('app.description')" rows="2"></textarea>'
            +'</div>'
            +'</div>'

            +'</div>'

            +'<div class="col-md-1">'

            +'<div class="form-group">'
            +'<label class="control-label hidden-md hidden-lg">@lang('modules.invoices.qty')</label>'
            +'<input type="number" min="1" class="form-control quantity" value="1" name="quantity[]" >'
            +'</div>'


            +'</div>'

            +'<div class="col-md-2">'
            +'<div class="row">'
            +'<div class="form-group">'
            +'<label class="control-label hidden-md hidden-lg">@lang('modules.invoices.unitPrice')</label>'
            +'<input type="text" min="0" class="form-control cost_per_item" value="0" name="cost_per_item[]">'
            +'</div>'
            +'</div>'

            +'</div>'


            +'<div class="col-md-2">'

            +'<div class="form-group">'
            +'<label class="control-label hidden-md hidden-lg">@lang('modules.invoices.tax')</label>'
            +'<select name="taxes[]" class="form-control type">'
            +'<option value="">@lang('app.zero') @lang('modules.invoices.tax')</option>'
                @foreach($taxes as $tax)
            +'<option data-rate="{{ $tax->rate_percent }}" value="{{ $tax->id }}">{{ $tax->tax_name.': '.$tax->rate_percent }}%</option>'
                @endforeach
            +'</select>'
            +'</div>'


            +'</div>'

            +'<div class="col-md-2 text-center">'
            +'<label class="control-label hidden-md hidden-lg">@lang('modules.invoices.amount')</label>'
            +'<p class="form-control-static"><span class="amount-html">0.00</span></p>'
            +'<input type="hidden" class="amount" name="amount[]">'
            +'</div>'

            +'<div class="col-md-1 text-right visible-md visible-lg">'
            +'<button type="button" class="btn remove-item btn-circle btn-danger"><i class="fa fa-remove"></i></button>'
            +'</div>'

            +'<div class="col-md-1 hidden-md hidden-lg">'
            +'<div class="row">'
            +'<button type="button" class="btn remove-item btn-danger"><i class="fa fa-remove"></i> @lang('app.remove')</button>'
            +'</div>'
            +'</div>'

            +'</div>';

        $(item).hide().appendTo("#sortable").fadeIn(500);

    });

    $('#updatePayments').on('click', '.remove-item', function () {
        $(this).closest('.item-row').fadeOut(300, function () {
            $(this).remove();
            calculateTotal();
        });
    });

    $('#updatePayments').on('keyup', '.quantity,.cost_per_item,.item_name, .discount_value', function () {
        var quantity = $(this).closest('.item-row').find('.quantity').val();

        var perItemCost = $(this).closest('.item-row').find('.cost_per_item').val();

        var amount = (quantity * perItemCost);

        $(this).closest('.item-row').find('.amount').val(decimalupto2(amount));
        $(this).closest('.item-row').find('.amount-html').html(decimalupto2(amount));

        calculateTotal();


    });

    $('#updatePayments').on('change','.type, #discount_type', function () {
        var quantity = $(this).closest('.item-row').find('.quantity').val();

        var perItemCost = $(this).closest('.item-row').find('.cost_per_item').val();

        var amount = (quantity*perItemCost);

        $(this).closest('.item-row').find('.amount').val(decimalupto2(amount));
        $(this).closest('.item-row').find('.amount-html').html(decimalupto2(amount));

        calculateTotal();


    });

    function calculateTotal()
    {
        var subtotal = 0;
        var discount = 0;
        var tax = '';
        var taxList = new Object();
        var taxTotal = 0;
        $(".quantity").each(function (index, element) {

            var itemTax = $(this).closest('.item-row').find('.type option:selected').data('rate');
            var itemTaxName = $(this).closest('.item-row').find('.type option:selected').text();
            var itemTaxId = $(this).closest('.item-row').find('.type').val();
            var amount = $(this).closest('.item-row').find('.amount').val();
            subtotal = parseFloat(subtotal)+parseFloat(amount);

            if(itemTaxId != ''){
                if(typeof (taxList[itemTaxName]) === 'undefined'){
                    taxList[itemTaxName] = ((parseFloat(itemTax)/100)*parseFloat(amount));
                }
                else{
                    taxList[itemTaxName] = parseFloat(taxList[itemTaxName]) + ((parseFloat(itemTax)/100)*parseFloat(amount));
                }

            }

        });

        $.each( taxList, function( key, value ) {
            if(!isNaN(value)){

                tax = tax+'<div class="col-md-offset-9 col-md-1 text-right p-t-10">'
                    +key
                    +'</div>'
                    +'<p class="form-control-static col-xs-6 col-md-2" >'
                    +'<span class="tax-percent">'+decimalupto2(value)+'</span>'
                    +'</p>';

                taxTotal = taxTotal+value;
            }

        });

        $('.sub-total').html(decimalupto2(subtotal));
        $('.sub-total-field').val(decimalupto2(subtotal));


        var discountType = $('#discount_type').val();
        var discountValue = $('.discount_value').val();

        if(discountValue != ''){
            if(discountType == 'percent'){
                discount = ((parseFloat(subtotal)/100)*parseFloat(discountValue));
            }
            else{
                discount = parseFloat(discountValue);
            }

        }

        $('#invoice-taxes').html(tax);

        var totalAfterDiscount = subtotal-discount;

        totalAfterDiscount = (totalAfterDiscount < 0) ? 0 : totalAfterDiscount;

        var total = decimalupto2(totalAfterDiscount+taxTotal);

        $('.total').html(total);
        $('.total-field').val(total);

    }

    calculateTotal();

    function decimalupto2(num) {
        var amt =  Math.round(num * 100) / 100;
        return parseFloat(amt.toFixed(2));
    }

    $('.add-product').on('click', function(event) {
        event.preventDefault();
        var id = $(this).data('pk');
        $.easyAjax({
            url:'{{ route('admin.all-invoices.update-item') }}',
            type: "GET",
            data: { id: id },
            success: function(response) {
                $(response.view).hide().appendTo("#sortable").fadeIn(500);
                calculateTotal();
    }
        });
    });
</script>
@endpush

