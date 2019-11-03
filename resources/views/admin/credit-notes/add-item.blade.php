<div class="col-xs-12 item-row margin-top-5">
    <div class="col-md-4">
        <div class="row">
            <div class="form-group">
                <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.item')</label>
                <div class="input-group">
                    <div class="input-group-addon"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></div>
                    <input type="text" class="form-control item_name" name="item_name[]"
                           value="{{ $items->name }}" >
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-1">
        <div class="form-group">
            <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.qty')</label>
            <input type="number" min="1" class="form-control quantity" data-item-id="{{ $items->id }}" value="1" name="quantity[]" >
        </div>
    </div>

    <div class="col-md-2">
        <div class="row">
            <div class="form-group">
                <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.unitPrice')</label>
                <input type="text"  class="form-control cost_per_item" name="cost_per_item[]" data-item-id="{{ $items->id }}" value="{{ $items->price }}">
            </div>
        </div>
    </div>

    <div class="col-md-2">

        <div class="form-group">
            <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.type')</label>
            <select name="taxes[]" class="form-control type">
                <option value="">--</option>
                @foreach($taxes as $tax)
                    <option @if($items->tax) @if($tax->id == $items->tax->id) selected @endif @endif data-rate="{{ $tax->rate_percent }}" value="{{ $tax->id }}">{{ $tax->tax_name }}: {{ $tax->rate_percent }}%</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-2 border-dark  text-center">
        <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.amount')</label>

        <p class="form-control-static"><span class="amount-html" data-item-id="{{ $items->id }}">0</span></p>
        <input type="hidden" class="amount" name="amount[]" data-item-id="{{ $items->id }}">
    </div>

    <div class="col-md-1 text-right visible-md visible-lg">
        <button type="button" class="btn remove-item btn-circle btn-danger"><i class="fa fa-remove"></i></button>
    </div>

    <div class="col-md-1 hidden-md hidden-lg">
        <div class="row">
            <button type="button" class="btn btn-circle remove-item btn-danger"><i class="fa fa-remove"></i> @lang('app.remove')</button>
        </div>
    </div>

</div>
<script>
    $(function () {
        var quantity = $('#sortable').find('.quantity[data-item-id="{{ $items->id }}"]').val();
        var perItemCost = $('#sortable').find('.cost_per_item[data-item-id="{{ $items->id }}"]').val();
        var amount = (quantity*perItemCost);
        $('#sortable').find('.amount[data-item-id="{{ $items->id }}"]').val(amount);
        $('#sortable').find('.amount-html[data-item-id="{{ $items->id }}"]').html(amount);

        calculateTotal();
    });
</script>