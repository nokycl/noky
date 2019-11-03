<div class="media">
    <div class="media-body">
        <h5 class="media-heading"><span class="btn btn-circle btn-danger"><i class="icon-clock"></i></span> Timer Started for Project - {{ ucwords($notification->data['project']['project_name']) }}</h5>
    </div>
    <h6><i>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->data['created_at'])->diffForHumans() }}</i></h6>
</div>