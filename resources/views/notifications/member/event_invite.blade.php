<li class="top-notifications">
    <div class="message-center">
        <a href="javascript:;" class="show-all-notifications">
            <div class="user-img">
                <span class="btn btn-circle btn-success"><i class="icon-user"></i></span>
            </div>
            <div class="mail-contnet">
                <span class="mail-desc m-0">New event on {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->data['start_date_time'])->format('d M, Y') }}</span> <span class="time">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->data['created_at'])->diffForHumans() }}</span>
            </div>
        </a>
    </div>
</li>