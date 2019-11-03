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
                <div class="panel-heading"><?php echo e(__($pageTitle)); ?></div>

                <div class="vtabs customvtab m-t-10">
                    <?php echo $__env->make('sections.super_admin_setting_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <div class="tab-content">
                        <div id="vhome3" class="tab-pane active">
                            <div class="row">
                                <div class="col-md-12">

                                    <h3 class="box-title m-b-0"><?php echo app('translator')->getFromJson("modules.slackSettings.notificationTitle"); ?></h3>

                                    <p class="text-muted m-b-10 font-13">
                                        <?php echo app('translator')->getFromJson("modules.slackSettings.notificationSubtitle"); ?>
                                    </p>


                                    <?php echo Form::open(['id'=>'editSlackSettings','class'=>'ajax-form','method'=>'PUT']); ?>


                                    <h5>
                                        Signup on <a href="https://onesignal.com/" target="_blank">onesignal.com</a>
                                    </h5>
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label for="company_name"><?php echo app('translator')->getFromJson('modules.pushSettings.oneSignalAppId'); ?></label>
                                            <input type="text" class="form-control" id="onesignal_app_id"
                                                   name="onesignal_app_id" value="<?php echo e($pushSettings->onesignal_app_id); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="company_name"><?php echo app('translator')->getFromJson('modules.pushSettings.oneSignalRestApiKey'); ?></label>
                                            <input type="text" class="form-control" id="onesignal_rest_api_key"
                                                   name="onesignal_rest_api_key" value="<?php echo e($pushSettings->onesignal_rest_api_key); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="company_name"><?php echo app('translator')->getFromJson('app.status'); ?></label>
                                            <select name="status" class="form-control" id="">
                                                <option
                                                        <?php if($pushSettings->status == 'inactive'): ?> selected <?php endif; ?>
                                                value="inactive"><?php echo app('translator')->getFromJson('app.inactive'); ?></option>
                                                <option
                                                        <?php if($pushSettings->status == 'active'): ?> selected <?php endif; ?>
                                                value="active"><?php echo app('translator')->getFromJson('app.active'); ?></option>
                                            </select>
                                        </div>


                                        <div class="form-group" style="display: none">
                                            <label for="exampleInputPassword1" class="d-block"><?php echo app('translator')->getFromJson('modules.slackSettings.slackNotificationLogo'); ?></label>

                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail"
                                                     style="width: 200px; height: 150px;">
                                                    <?php if(is_null($pushSettings->notification_logo)): ?>
                                                        <img src="https://placeholdit.imgix.net/~text?txtsize=25&txt=<?php echo app('translator')->getFromJson('modules.slackSettings.uploadSlackLogo'); ?>&w=200&h=150"
                                                             alt=""/>
                                                    <?php else: ?>
                                                        <img src="<?php echo e(asset('user-uploads/notification-logo/'.$pushSettings->notification_logo)); ?>"
                                                             alt=""/>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail"
                                                     style="max-width: 200px; max-height: 150px;"></div>
                                                <div>
                                                        <span class="btn btn-info btn-file">
                                                            <span class="fileinput-new"> <?php echo app('translator')->getFromJson('app.selectImage'); ?> </span>
                                                            <span class="fileinput-exists"> <?php echo app('translator')->getFromJson('app.change'); ?> </span>
                                                            <input type="file" name="notification_logo" id="notification_logo">
                                                        </span>
                                                    <a href="javascript:;" class="btn btn-danger fileinput-exists"
                                                       data-dismiss="fileinput"> <?php echo app('translator')->getFromJson('app.remove'); ?> </a>
                                                </div>
                                            </div>

                                            <?php if(!is_null($pushSettings->notification_logo)): ?>
                                                <div class="form-group">
                                                    <label for="removeImage"><?php echo app('translator')->getFromJson("modules.emailSettings.removeImage"); ?></label>
                                                    <div class="switchery-demo">
                                                        <input type="checkbox" name="removeImage" id="removeImageButton" class="js-switch removeImage"
                                                               data-color="#99d683" />
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <div class="clearfix"></div>
                                        </div>

                                    </div>


                                    <div class="form-actions m-t-20">
                                        <button type="submit" id="save-form"
                                                class="btn btn-success waves-effect waves-light m-r-10">
                                            <?php echo app('translator')->getFromJson('app.update'); ?>
                                        </button>
                                        <button type="button" id="send-test-notification"
                                                class="btn btn-primary waves-effect waves-light"><?php echo app('translator')->getFromJson('modules.slackSettings.sendTestNotification'); ?></button>
                                        <button type="reset"
                                                class="btn btn-inverse waves-effect waves-light"><?php echo app('translator')->getFromJson('app.reset'); ?></button>
                                    </div>

                                    <?php echo Form::close(); ?>


                                </div>
                                <!-- .row -->

                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
        <!-- .row -->


        <?php $__env->stopSection(); ?>

        <?php $__env->startPush('footer-script'); ?>
        <script src="<?php echo e(asset('plugins/bower_components/switchery/dist/switchery.min.js')); ?>"></script>
        <script>
            $('#save-form').click(function () {
                $.easyAjax({
                    url: '<?php echo e(route('super-admin.push-notification-settings.update', ['1'])); ?>',
                    container: '#editSlackSettings',
                    type: "POST",
                    redirect: true,
                    file: true
                })
            });
            $('#removeImageButton').change(function () {
                var removeButton;
                if ($(this).is(':checked'))
                    removeButton = 'yes';
                else
                    removeButton = 'no';

                var img;
                if(removeButton == 'yes'){
                    img = '<img src="https://placeholdit.imgix.net/~text?txtsize=25&txt=<?php echo app('translator')->getFromJson('modules.slackSettings.uploadSlackLogo'); ?>&w=200&h=150" alt=""/>';
                }
                else{
                    img = '<img src="<?php echo e(asset('user-uploads/notification-logo/'.$pushSettings->notification_logo)); ?>" alt=""/>'
                }
                $('.thumbnail').html(img);

            });

            $('#send-test-notification').click(function () {

                var url = '<?php echo e(route('super-admin.push-notification-settings.sendTestNotification')); ?>';

                $.easyAjax({
                    url: url,
                    type: "GET",
                    success: function (response) {

                    }
                })
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.super-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/super-admin/push-settings/index.blade.php ENDPATH**/ ?>