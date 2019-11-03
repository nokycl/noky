<div class="media">
    <div class="media-body">
        <h5 class="media-heading"><span class="btn btn-circle btn-warning"><i class="ti-alert"></i></span> New Project Issue Reported</h5>
        {{ ucfirst($notification->data['description']) }} </div>
    <h6><i>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->data['created_at'])->diffForHumans() }}</i></h6>
</div>