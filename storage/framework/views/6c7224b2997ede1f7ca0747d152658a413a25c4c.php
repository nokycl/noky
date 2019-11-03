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
                <li><a href="<?php echo e(route('super-admin.packages.index')); ?>"><?php echo e(__($pageTitle)); ?></a></li>
                <li class="active"><?php echo app('translator')->getFromJson('app.addNew'); ?></li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('head-script'); ?>
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css')); ?>">
    <style>
        .m-b-10{
            margin-bottom: 10px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-inverse">
                <div class="panel-heading"> <?php echo app('translator')->getFromJson('app.add'); ?> <?php echo app('translator')->getFromJson('app.package'); ?> <?php echo app('translator')->getFromJson('app.info'); ?></div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <?php echo Form::open(['id'=>'createClient','class'=>'ajax-form','method'=>'POST']); ?>

                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo app('translator')->getFromJson('app.name'); ?></label>
                                            <input type="text" id="name" name="name" value="" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->getFromJson('app.max'); ?> <?php echo app('translator')->getFromJson('app.menu.employees'); ?></label>
                                            <input type="number" name="max_employees" id="max_employees" value=""  class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->getFromJson('app.annual'); ?> <?php echo app('translator')->getFromJson('app.price'); ?> (<?php echo e($global->currency->currency_symbol); ?>)</label>
                                            <input type="number" name="annual_price" id="annual_price" value=""  class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->getFromJson('app.monthly'); ?> <?php echo app('translator')->getFromJson('app.price'); ?> (<?php echo e($global->currency->currency_symbol); ?>)</label>
                                            <input type="number" name="monthly_price" id="monthly_price"  value=""   class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo app('translator')->getFromJson('modules.package.stripeAnnualPlanId'); ?></label>
                                            <input type="text" id="stripe_annual_plan_id" name="stripe_annual_plan_id" value="" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->getFromJson('modules.package.stripeMonthlyPlanId'); ?></label>
                                            <input type="text" name="stripe_monthly_plan_id" id="stripe_monthly_plan_id" value=""  class="form-control">
                                        </div>
                                    </div>

                                </div>

                                <h3 class="box-title"><?php echo app('translator')->getFromJson('app.select'); ?> <?php echo app('translator')->getFromJson('app.module'); ?></h3>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="checkbox checkbox-info  col-md-10">
                                                <input id="select_all_permission"
                                                        
                                                        class="select_all_permission" type="checkbox">
                                                <label for="select_all_permission"><?php echo app('translator')->getFromJson('modules.permission.selectAll'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="row form-group module-in-package">
                                            <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="col-md-2">
                                                    <div class="checkbox checkbox-inline checkbox-info m-b-10">
                                                        <input id="<?php echo e($module->module_name); ?>" name="module_in_package[<?php echo e($module->id); ?>]" value="<?php echo e($module->module_name); ?>" class="module_checkbox"
                                                               type="checkbox">
                                                        <label for="<?php echo e($module->module_name); ?>"><?php echo e(ucfirst($module->module_name)); ?></label>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo app('translator')->getFromJson('app.description'); ?></label>
                                            <textarea name="description"  id="description"  rows="5" value="" class="form-control"></textarea>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="form-actions">
                                <button type="submit" id="save-form" class="btn btn-success"> <i class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.save'); ?></button>
                                <button type="reset" class="btn btn-default"><?php echo app('translator')->getFromJson('app.reset'); ?></button>
                            </div>
                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>    <!-- .row -->

<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-script'); ?>
<script src="<?php echo e(asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js')); ?>"></script>

<script>
    $('#save-form').click(function () {
        $.easyAjax({
            url: '<?php echo e(route('super-admin.packages.store')); ?>',
            container: '#createClient',
            type: "POST",
            redirect: true,
            data: $('#createClient').serialize()
        })
    });

    $('.select_all_permission').change(function () {
        if($(this).is(':checked')){
            $('.module_checkbox').prop('checked', true);
        } else {
            $('.module_checkbox').prop('checked', false);
        }
    });
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.super-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/super-admin/packages/create.blade.php ENDPATH**/ ?>