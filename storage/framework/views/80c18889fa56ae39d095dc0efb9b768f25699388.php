<?php $__env->startSection('page-title'); ?>
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="<?php echo e($pageIcon); ?>"></i> <?php echo e(__($pageTitle)); ?></h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="<?php echo e(route('super-admin.dashboard')); ?>"><?php echo app('translator')->getFromJson('app.menu.home'); ?></a></li>
                <li class="active"><?php echo e(__($pageTitle)); ?></li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('head-script'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/switchery/dist/switchery.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-inverse">
                <div class="panel-heading"><?php echo app('translator')->getFromJson('app.language'); ?> <?php echo app('translator')->getFromJson('app.menu.settings'); ?></div>

                <div class="vtabs customvtab m-t-10">
                    <?php echo $__env->make('sections.super_admin_setting_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <div class="tab-content">
                        <div id="vhome3" class="tab-pane active">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <a href="<?php echo e(url('/translations')); ?>" target="_blank" class="btn btn-sm m-b-30 btn-warning"><i class="ti-settings"></i> Translate</a>

                                    <?php echo Form::open(['id'=>'updateProfile','class'=>'ajax-form','method'=>'PUT']); ?>

                                    <div class="form-body">
                                        <div class="row">

                                            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="col-sm-6 col-md-4 m-t-10">
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-8"><?php echo e($language->language_name); ?></label>

                                                        <div class="col-sm-4">
                                                            <div class="switchery-demo">
                                                                <input type="checkbox"
                                                                       <?php if($language->status == 'enabled'): ?> checked
                                                                       <?php endif; ?> class="js-switch change-language-setting"
                                                                       data-color="#99d683"
                                                                       data-setting-id="<?php echo e($language->id); ?>"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </div>
                                        <!--/row-->
                                    </div>
                                    <?php echo Form::close(); ?>

                                </div>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>

                </div>
            </div>    <!-- .row -->
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-script'); ?>
    <script src="<?php echo e(asset('plugins/bower_components/switchery/dist/switchery.min.js')); ?>"></script>
    <script>
        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function () {
            new Switchery($(this)[0], $(this).data());

        });

        $('.change-language-setting').change(function () {
            var id = $(this).data('setting-id');

            if ($(this).is(':checked'))
                var status = 'enabled';
            else
                var status = 'disabled';

            var url = '<?php echo e(route('super-admin.language-settings.update', ':id')); ?>';
            url = url.replace(':id', id);
            $.easyAjax({
                url: url,
                type: "POST",
                data: {'id': id, 'status': status, '_method': 'PUT', '_token': '<?php echo e(csrf_token()); ?>'}
            })
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.super-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/super-admin/language-settings/index.blade.php ENDPATH**/ ?>