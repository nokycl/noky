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
                <li><a href="{{ route('admin.all-credit-notes.index') }}">{{ __($pageTitle) }}</a></li>
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
                <div class="panel-heading"> @lang('app.update') @lang('app.credit-note')</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        {!! Form::open(['id'=>'updatePayments','class'=>'ajax-form','method'=>'PUT']) !!}
                        <div class="form-body">

                            <div class="row">
                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label class="control-label">@lang('app.credit-note') #</label>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-icon">
                                                    <input type="text" readonly class="form-control"
                                                           name="cn_number" id="cn_number"
                                                           value="{{ $creditNote->cn_number }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label class="control-label">@lang('app.project')</label>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <select class="select2 form-control" data-placeholder="Choose Project"
                                                        name="project_id">
                                                    @foreach($projects as $project)
                                                        <option
                                                                @if($creditNote->project_id == $project->id) selected
                                                                @endif
                                                                value="{{ $project->id }}">{{ ucwords($project->project_name) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">@lang('modules.credit-notes.currency')</label>
                                        <select class="form-control" name="currency_id" id="currency_id">
                                            @foreach($currencies as $currency)
                                                <option
                                                        @if($creditNote->currency_id == $currency->id) selected
                                                        @endif
                                                        value="{{ $currency->id }}">{{ $currency->currency_symbol.' ('.$currency->currency_code.')' }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label class="control-label">@lang('modules.credit-notes.creditNoteDate')</label>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-icon">
                                                    <input type="text" class="form-control" name="issue_date"
                                                           id="issue_date"
                                                           value="{{ $creditNote->issue_date->format('m/d/Y') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">@lang('app.dueDate')</label>

                                        <div class="input-icon">
                                            <input type="text" class="form-control" name="due_date" id="due_date"
                                                   value="{{ $creditNote->due_date->format('m/d/Y') }}">
                                        </div>
                                    </div>

                                </div>

{{--                                <div class="col-md-4">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label class="control-label">@lang('app.status')</label>--}}
{{--                                        <select class="form-control" name="status" id="status">--}}
{{--                                            <option--}}
{{--                                                    @if($creditNote->status == 'paid') selected @endif--}}
{{--                                            value="paid">@lang('modules.credit-notes.paid')--}}
{{--                                            </option>--}}
{{--                                            <option--}}
{{--                                                    @if($creditNote->status == 'unpaid') selected @endif--}}
{{--                                            value="unpaid">@lang('modules.credit-notes.unpaid')--}}
{{--                                            </option>--}}
{{--                                            <option--}}
{{--                                                    @if($creditNote->status == 'partial') selected @endif--}}
{{--                                            value="partial">@lang('modules.credit-notes.partial')--}}
{{--                                            </option>--}}
{{--                                        </select>--}}
{{--                                    </div>--}}

{{--                                </div>--}}

                            </div>

                            <div class="row">
                                <div class="col-md-3">

                                    <div class="form-group" >
                                        <label class="control-label">@lang('modules.credit-notes.isRecurringPayment') </label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <select class="form-control" name="recurring_payment" id="recurring_payment" onchange="recurringPayment()">
                                                    <option value="no" @if($creditNote->recurring == 'no') selected @endif>@lang('app.no')</option>
                                                    <option value="yes" @if($creditNote->recurring == 'yes') selected @endif>@lang('app.yes')</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 recurringPayment" style="display: none;">
                                    <div class="form-group">
                                        <label class="control-label">@lang('modules.credit-notes.billingFrequency')</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <select class="form-control" name="billing_frequency" id="billing_frequency" onchange="recurringPayment">
                                                    <option value="day" @if($creditNote->billing_frequency == 'day') selected @endif>@lang('app.day')</option>
                                                    <option value="week" @if($creditNote->billing_frequency == 'week') selected @endif>@lang('app.week')</option>
                                                    <option value="month" @if($creditNote->billing_frequency == 'month') selected @endif>@lang('app.month')</option>
                                                    <option value="year" @if($creditNote->billing_frequency == 'year') selected @endif>@lang('app.year')</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 recurringPayment" style="display: none;">
                                    <div class="form-group">
                                        <label class="control-label">@lang('modules.credit-notes.billingInterval')</label>
                                        <div class="input-icon">
                                            <input type="text" class="form-control" name="billing_interval" id="billing_interval" value="{{ $creditNote->billing_interval }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 recurringPayment" style="display: none;">
                                    <div class="form-group">
                                        <label class="control-label">@lang('modules.credit-notes.billingCycle')</label>
                                        <div class="input-icon">
                                            <input type="text" class="form-control" name="billing_cycle" id="billing_cycle" value="{{ $creditNote->billing_cycle }}">
                                        </div>
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
                                        @lang('modules.credit-notes.item')
                                    </div>

                                    <div class="col-md-1 font-bold" style="padding: 8px 15px">
                                        @lang('modules.credit-notes.qty')
                                    </div>

                                    <div class="col-md-2 font-bold" style="padding: 8px 15px">
                                        @lang('modules.credit-notes.unitPrice')
                                    </div>

                                    <div class="col-md-2 font-bold" style="padding: 8px 15px">
                                        @lang('modules.credit-notes.tax') <a href="javascript:;" id="tax-settings" ><i class="ti-settings text-info"></i></a>
                                    </div>

                                    <div class="col-md-2 text-center font-bold" style="padding: 8px 15px">
                                        @lang('modules.credit-notes.amount')
                                    </div>

                                    <div class="col-md-1" style="padding: 8px 15px">
                                        &nbsp;
                                    </div>

                                </div>

                                <div id="sortable">
                                    @foreach($creditNote->items as $item)
                                        <div class="col-xs-12 item-row margin-top-5">
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="control-label hidden-md hidden-lg">@lang('modules.credit-notes.item')</label>
                                                        <div class="input-group">
                                                            <div class="input-group-addon"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></div>
                                                            <input type="text" class="form-control item_name" name="item_name[]"
                                                                   value="{{ $item->item_name }}" >
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-1">

                                                <div class="form-group">
                                                    <label class="control-label hidden-md hidden-lg">@lang('modules.credit-notes.qty')</label>
                                                    <input type="number" min="1" class="form-control quantity"
                                                           value="{{ $item->quantity }}" name="quantity[]"
                                                           >
                                                </div>


                                            </div>

                                            <div class="col-md-2">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="control-label hidden-md hidden-lg">@lang('modules.credit-notes.unitPrice')</label>
                                                        <input type="text" min="" class="form-control cost_per_item"
                                                               name="cost_per_item[]" value="{{ $item->unit_price }}"
                                                               >
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-2">

                                                <div class="form-group">
                                                    <label class="control-label hidden-md hidden-lg">@lang('modules.credit-notes.type')</label>
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
                                                <label class="control-label hidden-md hidden-lg">@lang('modules.credit-notes.amount')</label>
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

                                <div class="col-xs-12 m-t-5">
                                    <button type="button" class="btn btn-info" id="add-item"><i class="fa fa-plus"></i>
                                        @lang('modules.credit-notes.addItem')
                                    </button>
                                </div>

                                <div class="col-xs-12 ">


                                    <div class="row">
                                        <div class="col-md-offset-9 col-xs-6 col-md-1 text-right p-t-10">@lang('modules.credit-notes.subTotal')</div>

                                        <p class="form-control-static col-xs-6 col-md-2">
                                            <span class="sub-total">{{ number_format((float)$creditNote->sub_total, 2, '.', '') }}</span>
                                        </p>


                                        <input type="hidden" class="sub-total-field" name="sub_total" value="{{ $creditNote->sub_total }}">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-offset-9 col-md-1 text-right p-t-10">
                                            @lang('modules.credit-notes.discount')
                                        </div>
                                        <div class="form-group col-xs-6 col-md-1" >
                                            <input type="number" min="0" value="{{ $creditNote->discount }}" name="discount_value" class="form-control discount_value" >
                                        </div>
                                        <div class="form-group col-xs-6 col-md-1" >
                                            <select class="form-control" name="discount_type" id="discount_type">
                                                <option
                                                        @if($creditNote->discount_type == 'percent') selected @endif
                                                        value="percent">%</option>
                                                <option
                                                        @if($creditNote->discount_type == 'fixed') selected @endif
                                                value="fixed">@lang('modules.credit-notes.amount')</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row m-t-5" id="invoice-taxes">
                                        <div class="col-md-offset-9 col-md-1 text-right p-t-10">
                                            @lang('modules.credit-notes.tax')
                                        </div>

                                        <p class="form-control-static col-xs-6 col-md-2" >
                                            <span class="tax-percent">0</span>
                                        </p>
                                    </div>

                                    <div class="row m-t-5 font-bold">
                                        <div class="col-md-offset-9 col-md-1 col-xs-6 text-right p-t-10">@lang('modules.credit-notes.total')</div>

                                        <p class="form-control-static col-xs-6 col-md-2">
                                            <span class="total">{{ number_format((float)$creditNote->total, 2, '.', '') }}</span>
                                        </p>


                                        <input type="hidden" class="total-field" name="total"
                                               value="{{ round($creditNote->total, 2) }}">
                                    </div>

                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group" >
                                    <label class="control-label">@lang('app.note')</label>
                                    <textarea class="form-control" name="note" id="note" rows="5">{{ $creditNote->note }}</textarea>
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

@endsection

@push('footer-script')
<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

<script>
    $(function () {
        recurringPayment();
        $( "#sortable" ).sortable();
    });

    $(".select2").select2({
        formatNoMatches: function () {
            return "{{ __('messages.noRecordFound') }}";
        }
    });

    jQuery('#issue_date, #due_date').datepicker({
        autoclose: true,
        todayHighlight: true
    });

    $('#save-form').click(function () {

        var discount = $('.discount-amount').html();
        var total = $('.total-field').val();

        if(parseFloat(discount) > parseFloat(total)){
            $.toast({
                heading: 'Error',
                text: "{{ __('messages.discountMoreThenTotal') }}",
                position: 'top-right',
                loaderBg:'#ff6849',
                icon: 'error',
                hideAfter: 3500
            });
            return false;
        }

        $.easyAjax({
            url: '{{route('admin.all-credit-notes.update', $creditNote->id)}}',
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
            +'<label class="control-label hidden-md hidden-lg">@lang('modules.credit-notes.item')</label>'
            +'<div class="input-group">'
            +'<div class="input-group-addon"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></div>'
            +'<input type="text" class="form-control item_name" name="item_name[]" >'
            +'</div>'

            +'</div>'
            +'</div>'

            +'</div>'

            +'<div class="col-md-1">'

            +'<div class="form-group">'
            +'<label class="control-label hidden-md hidden-lg">@lang('modules.credit-notes.qty')</label>'
            +'<input type="number" min="1" class="form-control quantity" value="1" name="quantity[]" >'
            +'</div>'


            +'</div>'

            +'<div class="col-md-2">'
            +'<div class="row">'
            +'<div class="form-group">'
            +'<label class="control-label hidden-md hidden-lg">@lang('modules.credit-notes.unitPrice')</label>'
            +'<input type="text" min="0" class="form-control cost_per_item" value="0" name="cost_per_item[]">'
            +'</div>'
            +'</div>'

            +'</div>'


            +'<div class="col-md-2">'

            +'<div class="form-group">'
            +'<label class="control-label hidden-md hidden-lg">@lang('modules.credit-notes.tax')</label>'
            +'<select name="taxes[]" class="form-control type">'
            +'<option value="">@lang('app.zero') @lang('modules.invoices.tax')</option>'
                @foreach($taxes as $tax)
            +'<option data-rate="{{ $tax->rate_percent }}" value="{{ $tax->id }}">{{ $tax->tax_name.': '.$tax->rate_percent }}%</option>'
                @endforeach
            +'</select>'
            +'</div>'


            +'</div>'

            +'<div class="col-md-2 text-center">'
            +'<label class="control-label hidden-md hidden-lg">@lang('modules.credit-notes.amount')</label>'
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

//            calculate subtotal

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

//
//            console.log(taxList);
//            console.log(taxTotal);

        });
//        console.log(taxList);

        $.each( taxList, function( key, value ) {
            if(!isNaN(value)){
//                console.log( key + ": " + value );

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

//       show tax
        $('#invoice-taxes').html(tax);

//            calculate total
        var totalAfterDiscount = subtotal-discount;

        totalAfterDiscount = (totalAfterDiscount < 0) ? 0 : totalAfterDiscount;

        var total = decimalupto2(totalAfterDiscount+taxTotal);
//console.log(total);

        $('.total').html(total);
        $('.total-field').val(total);

    }

    calculateTotal();

    function recurringPayment() {
        var recurring = $('#recurring_payment').val();

        if(recurring == 'yes')
        {
            $('.recurringPayment').show().fadeIn(300);
        } else {
            $('.recurringPayment').hide().fadeOut(300);
        }
    }

    function decimalupto2(num) {
        var amt =  Math.round(num * 100,2) / 100;
        return amt.toFixed(2);
    }

    $('.add-product').on('click', function(event) {
        event.preventDefault();
        var id = $(this).data('pk');
        $.easyAjax({
            url:'{{ route('admin.all-credit-notes.update-item') }}',
            type: "GET",
            data: { id: id },
            success: function(response) {
                $(response.view).hide().appendTo("#sortable").fadeIn(500);
            }
        });
    });

</script>
@endpush

