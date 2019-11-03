<?php $__env->startComponent('mail::message'); ?>
# New Task

<?php echo app('translator')->getFromJson('email.newTask.subject'); ?>

<h5><?php echo app('translator')->getFromJson('app.task'); ?> <?php echo app('translator')->getFromJson('app.details'); ?></h5>

<?php $__env->startComponent('mail::text', ['text' => $content]); ?>

<?php echo $__env->renderComponent(); ?>


<?php $__env->startComponent('mail::button', ['url' => $url]); ?>
<?php echo app('translator')->getFromJson('app.view'); ?> <?php echo app('translator')->getFromJson('app.task'); ?>
<?php echo $__env->renderComponent(); ?>

<?php echo app('translator')->getFromJson('email.regards'); ?>,<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH /var/www/html/resources/views/mail/task/created.blade.php ENDPATH**/ ?>