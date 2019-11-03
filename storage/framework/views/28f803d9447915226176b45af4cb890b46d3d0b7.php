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

                                    <h3 class="box-title m-b-0"><?php echo app('translator')->getFromJson("modules.emailSettings.notificationTitle"); ?></h3>

                                    <p class="text-muted m-b-10 font-13">
                                        <?php echo app('translator')->getFromJson("modules.emailSettings.notificationSubtitle"); ?>
                                    </p>


                                    <?php echo Form::open(['id'=>'updateSettings','class'=>'ajax-form']); ?>

                                    <?php echo Form::hidden('_token', csrf_token()); ?>

                                    <?php echo method_field('PUT'); ?>
                                    <div id="alert">
                                        <?php if($smtpSetting->mail_driver =='smtp'): ?>
                                            <?php if($smtpSetting->verified): ?>
                                                <div class="alert alert-success"><?php echo e(__('messages.smtpSuccess')); ?></div>
                                            <?php else: ?>
                                                <div class="alert alert-danger"><?php echo e(__('messages.smtpError')); ?></div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-12 ">
                                                <label><?php echo app('translator')->getFromJson("modules.emailSettings.mailDriver"); ?></label>
                                                <div class="form-group">
                                                    <label class="radio-inline"><input type="radio" class="checkbox" onchange="getDriverValue(this);" value="mail" <?php if($smtpSetting->mail_driver == 'mail'): ?> checked <?php endif; ?> name="mail_driver">Mail</label>
                                                    <label class="radio-inline m-l-10"><input type="radio" onchange="getDriverValue(this);"  value="smtp" <?php if($smtpSetting->mail_driver == 'smtp'): ?> checked <?php endif; ?> name="mail_driver">SMTP</label>


                                                </div>
                                            </div>

                                            <!--/span-->
                                        </div>
                                        <div id="smtp_div">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->getFromJson("modules.emailSettings.mailHost"); ?></label>
                                                        <input type="text" name="mail_host" id="mail_host"
                                                               class="form-control"
                                                               value="<?php echo e($smtpSetting->mail_host); ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->getFromJson("modules.emailSettings.mailPort"); ?></label>
                                                        <input type="text" name="mail_port" id="mail_port"
                                                               class="form-control"
                                                               value="<?php echo e($smtpSetting->mail_port); ?>">
                                                    </div>
                                                </div>
                                                <!--/span-->

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->getFromJson("modules.emailSettings.mailUsername"); ?></label>
                                                        <input type="text" name="mail_username"
                                                               id="mail_username"
                                                               class="form-control"
                                                               value="<?php echo e($smtpSetting->mail_username); ?>">
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <!--/row-->

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label"><?php echo app('translator')->getFromJson("modules.emailSettings.mailPassword"); ?></label>
                                                        <input type="password" name="mail_password"
                                                               id="mail_password"
                                                               class="form-control"
                                                               value="<?php echo e($smtpSetting->mail_password); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label"><?php echo app('translator')->getFromJson("modules.emailSettings.mailEncryption"); ?></label>
                                                        <select class="form-control" name="mail_encryption"
                                                                id="mail_encryption">
                                                            <option <?php if($smtpSetting->mail_encryption == 'tls'): ?> selected <?php endif; ?>>
                                                                tls
                                                            </option>
                                                            <option <?php if($smtpSetting->mail_encryption == 'ssl'): ?> selected <?php endif; ?>>
                                                                ssl
                                                            </option>
                                                            
                                                            <option value="null" <?php if($smtpSetting->mail_encryption == null): ?> selected <?php endif; ?>>
                                                                none
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>

                                    </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label"><?php echo app('translator')->getFromJson("modules.emailSettings.mailFrom"); ?></label>
                                                        <input type="text" name="mail_from_name"
                                                               id="mail_from_name"
                                                               class="form-control"
                                                               value="<?php echo e($smtpSetting->mail_from_name); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label"><?php echo app('translator')->getFromJson("modules.emailSettings.mailFromEmail"); ?></label>
                                                        <input type="text" name="mail_from_email"
                                                               id="mail_from_email"
                                                               class="form-control"
                                                               value="<?php echo e($smtpSetting->mail_from_email); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->

                                            
                                    <div class="form-actions">
                                        <button type="submit" id="save-form" class="btn btn-success"><i
                                                    class="fa fa-check"></i>
                                            <?php echo app('translator')->getFromJson('app.update'); ?>
                                        </button>
                                        <button type="button" id="send-test-email"
                                                class="btn btn-primary"><?php echo app('translator')->getFromJson('modules.emailSettings.sendTestEmail'); ?></button>
                                        <button type="reset" class="btn btn-default"><?php echo app('translator')->getFromJson('app.reset'); ?></button>
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


        
        <div class="modal fade bs-modal-md in" id="testMailModal" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-md" id="modal-data-application">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Test Email</h4>
                    </div>
                    <div class="modal-body">
                        <?php echo Form::open(['id'=>'testEmail','class'=>'ajax-form','method'=>'POST']); ?>

                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Enter email address where test mail needs to be sent</label>
                                        <input type="text" name="test_email" id="test_email"
                                               class="form-control"
                                               value="<?php echo e($user->email); ?>">
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success" id="send-test-email-submit">submit</button>
                        </div>
                        <?php echo Form::close(); ?>

                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->.
            </div>

        </div> 
    </div> 

        <?php $__env->stopSection(); ?>

        <?php $__env->startPush('footer-script'); ?>
        <script src="<?php echo e(asset('plugins/bower_components/switchery/dist/switchery.min.js')); ?>"></script>
        <script>
            $('#save-form').click(function () {

                var url = '<?php echo e(route('super-admin.email-settings.update', $smtpSetting->id)); ?>';

                $.easyAjax({
                    url: url,
                    type: "POST",
                    container: '#updateSettings',
                    data: $('#updateSettings').serialize(),
                    messagePosition: "inline",
                    success: function (response) {
                    if (response.status == 'error') {
                        $('#alert').prepend('<div class="alert alert-danger"><?php echo e(__('messages.smtpError')); ?></div>')
                    }else{
                        $('#alert').show();
                    }
                }
                })
            });

             $('#send-test-email').click(function () {
            $('#testMailModal').modal('show')
        });

        $('#send-test-email-submit').click(function () {
            $.easyAjax({
                url: '<?php echo e(route('super-admin.email-settings.sendTestEmail')); ?>',
                type: "GET",
                messagePosition: "inline",
                container: "#testEmail",
                data: $('#testEmail').serialize()

            })
        });


        function getDriverValue(sel) {
            if (sel.value == 'mail') {
                $('#smtp_div').hide();
                $('#alert').hide();
            } else {
                $('#smtp_div').show();
                $('#alert').show();
            }
        }

        <?php if($smtpSetting->mail_driver == 'mail'): ?>
        $('#smtp_div').hide();
        $('#alert').hide();
        <?php endif; ?>
        </script>
    <?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.super-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/super-admin/email-settings/index.blade.php ENDPATH**/ ?>