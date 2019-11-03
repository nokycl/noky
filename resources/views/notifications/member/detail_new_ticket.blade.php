<div class="media">
    <div class="media-body">
        <h5 class="media-heading"><span class="btn btn-circle btn-warning"><i class="icon-note"></i></span> New ticket - {{ ucfirst($notification->data['subject']) }}</h5>
    </div>
    <h6><i>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->data['created_at'])->diffForHumans() }}</i></h6>
</div>