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
                <li class="active"><?php echo app('translator')->getFromJson('app.edit'); ?></li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('head-script'); ?>
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-inverse">
                <div class="panel-heading"> <?php echo app('translator')->getFromJson('app.update'); ?> <?php echo app('translator')->getFromJson('app.superAdmin'); ?></div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <?php echo Form::open(['id'=>'updateClient','class'=>'ajax-form','method'=>'PUT']); ?>

                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="form-group">
                                        <label><?php echo app('translator')->getFromJson('app.name'); ?></label>
                                        <input type="text" name="name" id="name"
                                               class="form-control" value="<?php echo e($userDetail->name); ?>">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><?php echo app('translator')->getFromJson('app.email'); ?></label>
                                        <input type="email" name="email" id="email"
                                               class="form-control" value="<?php echo e($userDetail->email); ?>">
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><?php echo app('translator')->getFromJson('app.password'); ?></label>
                                        <input type="password" name="password" id="password"
                                               class="form-control">
                                        <span class="help-block"> <?php echo app('translator')->getFromJson('modules.profile.passwordNote'); ?></span>
                                    </div>
                                </div>
                                <!--/span-->

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><?php echo app('translator')->getFromJson('app.mobileNumber'); ?></label>
                                        <input type="tel" name="mobile" id="mobile" class="form-control"
                                               value="<?php echo e($userDetail->mobile); ?>">
                                    </div>
                                </div>
                                <!--/span-->

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><?php echo app('translator')->getFromJson('modules.employees.gender'); ?></label>
                                        <select name="gender" id="gender" class="form-control">
                                            <option <?php if($userDetail->gender == 'male'): ?> selected <?php endif; ?> value="male"><?php echo app('translator')->getFromJson('app.male'); ?></option>
                                            <option <?php if($userDetail->gender == 'female'): ?> selected <?php endif; ?> value="female"><?php echo app('translator')->getFromJson('app.female'); ?></option>
                                            <option <?php if($userDetail->gender == 'others'): ?> selected <?php endif; ?> value="others"><?php echo app('translator')->getFromJson('app.others'); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <!--/span-->

                                <!--/span-->
                                <?php if($user->id != $userDetail->id): ?>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><?php echo app('translator')->getFromJson('app.status'); ?></label>
                                        <select name="status" id="status" class="form-control">
                                            <option <?php if($userDetail->status == 'active'): ?> selected <?php endif; ?> value="active"><?php echo app('translator')->getFromJson('app.active'); ?></option>
                                            <option <?php if($userDetail->status == 'deactive'): ?> selected <?php endif; ?> value="deactive"><?php echo app('translator')->getFromJson('app.deactive'); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <!--/span-->
                            </div>
                            <!--/row-->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo app('translator')->getFromJson('app.address'); ?></label>
                                        <textarea name="address" id="address" rows="5"
                                                  class="form-control"><?php if(!empty($employeeDetail)): ?><?php echo e($employeeDetail->address); ?><?php endif; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label><?php echo app('translator')->getFromJson('modules.profile.profilePicture'); ?></label>

                                    <div class="form-group">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail"
                                                 style="width: 200px; height: 150px;">
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
                                                <a href="javascript:;"
                                                   class="btn btn-danger fileinput-exists"
                                                   data-dismiss="fileinput"> <?php echo app('translator')->getFromJson('app.remove'); ?> </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <!--/span-->


                        </div>
                        <div class="form-actions">
                            <button type="submit" id="save-form" class="btn btn-success"> <i class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.update'); ?></button>
                            <a href="<?php echo e(route('super-admin.packages.index')); ?>" class="btn btn-default"><?php echo app('translator')->getFromJson('app.back'); ?></a>
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
    $(".date-picker").datepicker({
        todayHighlight: true,
        autoclose: true
    });
    
    $('#save-form').click(function () {
        $.easyAjax({
            url: '<?php echo e(route('super-admin.super-admin.update', [$userDetail->id])); ?>',
            container: '#updateClient',
            type: "POST",
            redirect: true,
            file: true
        })
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.super-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\noky\resources\views/super-admin/super-admin/edit.blade.php ENDPATH**/ ?>