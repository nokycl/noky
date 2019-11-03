<?php

namespace App\Http\Controllers;

use App\Helper\Reply;
use App\Http\Controllers\Admin\AdminBaseController;
use Illuminate\Http\Request;

class NotificationController extends AdminBaseController
{
    public function __construct() {
        parent::__construct();
    }

    public function markAllRead() {
        $this->user->unreadNotifications->markAsRead();
        return Reply::success(__('messages.notificationRead'));
    }

    public function showAllMemberNotifications() {
        return view('notifications.member.all_notifications', $this->data);
    }

    public function showAllClientNotifications() {
        return view('notifications.client.all_notifications', $this->data);
    }

    public function showAllAdminNotifications() {
        return view('notifications.admin.all_notifications', $this->data);
    }

    public function showAllSuperAdminNotifications() {
        return view('notifications.superadmin.all_notifications', $this->data);
    }
}
