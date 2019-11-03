<div class="media">
    <div class="media-body">
        <h5 class="media-heading"><span class="btn btn-circle btn-info"><i class="icon-list"></i></span> New task for you - <?php echo e(ucfirst($notification->data['heading'])); ?></h5>
        <?php if(isset($notification->data['description'])): ?> <?php echo ucwords($notification->data['description']); ?> <?php endif; ?></div>
    <h6><i><?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->data['created_at'])->diffForHumans()); ?></i></h6>
</div><?php /**PATH /var/www/html/resources/views/notifications/member/detail_new_task.blade.php ENDPATH**/ ?>