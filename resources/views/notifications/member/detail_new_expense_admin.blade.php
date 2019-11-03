<div class="media">
    <div class="media-body">
        <h5 class="media-heading"><span class="btn btn-circle btn-info"><i class="icon-list"></i></span> New expense "{{ $notification->data['item_name'] }}" added</h5>
        Item price is {{ $notification->data['price'] }}</div>
    <h6><i>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->data['created_at'])->diffForHumans() }}</i></h6>
</div>