<?php $__env->startComponent('mail::layout'); ?>
    
    <?php $__env->slot('header'); ?>
        <?php $__env->startComponent('mail::header', ['url' => config('app.url')]); ?>
            <img src="<?php echo e(config('app.logo')); ?>" style="max-height: 45px" alt="">
        <?php echo $__env->renderComponent(); ?>
    <?php $__env->endSlot(); ?>

    
    <?php echo e($slot); ?>


    
    <?php if(isset($subcopy)): ?>
        <?php $__env->slot('subcopy'); ?>
            <?php $__env->startComponent('mail::subcopy'); ?>
                <?php echo e($subcopy); ?>

            <?php echo $__env->renderComponent(); ?>
        <?php $__env->endSlot(); ?>
    <?php endif; ?>

    
    <?php $__env->slot('footer'); ?>
        <?php $__env->startComponent('mail::footer'); ?>
            &copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>.
        <?php echo $__env->renderComponent(); ?>
    <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /var/www/html/resources/views/vendor/mail/html/message.blade.php ENDPATH**/ ?>