<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Helper\Reply;

class NotificationController extends SuperAdminBaseController
{
    public function __construct() {
        parent::__construct();
    }

    public function markAllRead() {
        $this->user->unreadNotifications->markAsRead();
        return Reply::success(__('messages.notificationRead'));
    }

    public function showAllSuperAdminNotifications() {
        return view('notifications.superadmin.all_notifications', $this->data);
    }
}
