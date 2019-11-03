<div class="media">
    <div class="media-body">
        <h5 class="media-heading"><span class="btn btn-circle btn-success"><i class="icon-user"></i></span> New event {{ $notification->data['event_name'] }} on {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->data['start_date_time'])->format('d M, Y') }}.</h5>
    </div>
    <h6><i>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->data['created_at'])->diffForHumans() }}</i></h6>
</div>