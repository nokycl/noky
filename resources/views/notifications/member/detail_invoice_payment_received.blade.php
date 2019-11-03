<div class="media">
    <div class="media-body">
        <h5 class="media-heading"><span class="btn btn-circle btn-info"><i class="icon-list"></i></span> @lang('email.invoices.paymentReceived')</h5>
        {{ $notification->data['original_invoice_number'] }}
        </div>
    <h6><i>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->diffForHumans() }}</i></h6>
</div>