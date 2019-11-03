<div class="media">
    <div class="media-body">
        <h5 class="media-heading"><span class="btn btn-circle btn-info"><i class="icon-list"></i></span> New task - {{ ucfirst($notification->data['heading']) }}</h5>
        @if(isset($notification->data['description'])) {{ ucwords($notification->data['description']) }}. @endif</div>
    <h6><i>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->data['created_at'])->diffForHumans() }}</i></h6>
</div>