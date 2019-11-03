<div class="media">
    <div class="media-body">
        <h5 class="media-heading"><span class="btn btn-circle btn-success"><i class="icon-layers"></i></span> New project assigned</h5>
        You have been assigned a new project. <br>All the best :) </div>
    <h6><i>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->data['created_at'])->diffForHumans() }}</i></h6>
</div>