<div class="media">
    <div class="media-body">
        <h5 class="media-heading"><span class="btn btn-circle btn-info"><i class="icon-list"></i></span> Expense status updated to {{ $notification->data['status'] }}</h5>
        Your expense "{{ ucfirst($notification->data['item_name']) }}" status updated to  {{ $notification->data['status'] }}</div>
    <h6><i>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->data['created_at'])->diffForHumans() }}</i></h6>
</div>