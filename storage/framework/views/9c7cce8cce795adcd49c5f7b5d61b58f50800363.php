<div class="media">
    <div class="media-body">
        <h5 class="media-heading"><span class="btn btn-circle btn-success"><i class="icon-user"></i></span> New  <b><?php echo e($notification->data['company_name']); ?></b> <?php echo app('translator')->getFromJson('messages.namedCompanyRegistered.'); ?></h5>
    </div>
    <h6><i><?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->data['created_at'])->diffForHumans()); ?></i></h6>
</div><?php /**PATH /var/www/html/resources/views/notifications/superadmin/detail_new_company_register.blade.php ENDPATH**/ ?>