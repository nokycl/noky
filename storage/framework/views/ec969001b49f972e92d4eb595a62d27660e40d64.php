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
                <li class="active"><?php echo app('translator')->getFromJson('app.edit'); ?></li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('head-script'); ?>
    <link rel="stylesheet"
          href="<?php echo e(asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-inverse">
                <div class="panel-heading"> <?php echo app('translator')->getFromJson('modules.employees.updateTitle'); ?></div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <?php echo Form::open(['id'=>'updateEmployee','class'=>'ajax-form','method'=>'PUT']); ?>

                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label><?php echo app('translator')->getFromJson('modules.employees.employeeName'); ?></label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               value="<?php echo e($userDetail->name); ?>" autocomplete="nope">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo app('translator')->getFromJson('modules.employees.employeeEmail'); ?></label>
                                        <input type="email" name="email" id="email" class="form-control"
                                               value="<?php echo e($userDetail->email); ?>" autocomplete="nope">
                                        <span class="help-block">Employee will login using this email.</span>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo app('translator')->getFromJson('modules.employees.employeePassword'); ?></label>
                                        <input type="password" style="display: none">
                                        <input type="password" name="password" id="password" class="form-control" autocomplete="nope">
                                        <span class="help-block"> <?php echo app('translator')->getFromJson('modules.employees.updatePasswordNote'); ?></span>
                                    </div>
                                </div>
                                <!--/span-->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo app('translator')->getFromJson('app.mobile'); ?></label>
                                        <input type="tel" name="mobile" id="mobile" class="form-control"
                                               value="<?php echo e($userDetail->mobile); ?>" autocomplete="nope">
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?php echo app('translator')->getFromJson('modules.employees.gender'); ?></label>
                                        <select name="gender" id="gender" class="form-control">
                                            <option <?php if($userDetail->gender == 'male'): ?> selected
                                                    <?php endif; ?> value="male"><?php echo app('translator')->getFromJson('app.male'); ?></option>
                                            <option <?php if($userDetail->gender == 'female'): ?> selected
                                                    <?php endif; ?> value="female"><?php echo app('translator')->getFromJson('app.female'); ?></option>
                                            <option <?php if($userDetail->gender == 'others'): ?> selected
                                                    <?php endif; ?> value="others"><?php echo app('translator')->getFromJson('app.others'); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--/row-->

                            <div class="row">
                                <div class="col-md-6">
                                    <label><?php echo app('translator')->getFromJson('modules.profile.profilePicture'); ?></label>
                                    <div class="form-group">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                <?php if(is_null($userDetail->image)): ?>
                                                    <img src="https://placeholdit.imgix.net/~text?txtsize=25&txt=<?php echo app('translator')->getFromJson('modules.profile.uploadPicture'); ?>&w=200&h=150"
                                                         alt=""/>
                                                <?php else: ?>
                                                    <img src="<?php echo e(asset('user-uploads/avatar/'.$userDetail->image)); ?>"
                                                         alt=""/>
                                                <?php endif; ?>
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail"
                                                 style="max-width: 200px; max-height: 150px;"></div>
                                            <div>
                                <span class="btn btn-info btn-file">
                                    <span class="fileinput-new"> <?php echo app('translator')->getFromJson('app.selectImage'); ?> </span>
                                    <span class="fileinput-exists"> <?php echo app('translator')->getFromJson('app.change'); ?> </span>
                                    <input type="file" name="image" id="image"> </span>
                                                <a href="javascript:;" class="btn btn-danger fileinput-exists"
                                                   data-dismiss="fileinput"> <?php echo app('translator')->getFromJson('app.remove'); ?> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" id="save-form" class="btn btn-success"><i
                                        class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.update'); ?></button>
                            <a href="<?php echo e(route('super-admin.dashboard')); ?>" class="btn btn-default"><?php echo app('translator')->getFromJson('app.back'); ?></a>
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
        $("#joining_date, .date-picker").datepicker({
            todayHighlight: true,
            autoclose: true
        });


        $('#save-form').click(function () {
            $.easyAjax({
                url: '<?php echo e(route('super-admin.profile.update', [$userDetail->id])); ?>',
                container: '#updateEmployee',
                type: "POST",
                redirect: true,
                file: true,
            })
        });
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.super-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/super-admin/profile/edit.blade.php ENDPATH**/ ?>