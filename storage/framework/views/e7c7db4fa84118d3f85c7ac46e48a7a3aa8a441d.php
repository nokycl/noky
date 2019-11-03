<li class="top-notifications">
    <div class="message-center">
        <a href="javascript:;" class="show-all-notifications">
            <div class="user-img">
                <span class="btn btn-circle btn-success"><i class="icon-user"></i></span>
            </div>
            <div class="mail-contnet">
                <span class="mail-desc m-0"><?php echo app('translator')->getFromJson('NewCompanyRegistered'); ?></span> <span class="time"><?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->data['created_at'])->diffForHumans()); ?></span>
            </div>
        </a>
    </div>
</li><?php /**PATH C:\xampp\htdocs\noky\resources\views/notifications/superadmin/new_company_register.blade.php ENDPATH**/ ?>