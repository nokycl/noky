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
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/custom-select/custom-select.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="alert alert-info col-md-12">
            <h5 class="text-white">Set following cron command on your server</h5>
            <p>* * * * * cd <?php echo e(base_path()); ?> && php artisan schedule:run >> /dev/null 2>&1</p>
        </div>
        <div class="col-md-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <?php echo app('translator')->getFromJson('modules.accountSettings.updateTitle'); ?>
                    <a href="javascript:;" id="clear-cache" class="btn btn-sm btn-danger pull-right m-l-5"><i class="fa fa-times"></i> <?php echo app('translator')->getFromJson('app.disableCache'); ?></a>
                    <a href="javascript:;" id="refresh-cache" class="btn btn-sm btn-success pull-right"><i class="fa fa-refresh"></i> <?php echo app('translator')->getFromJson('app.refreshCache'); ?></a>
                </div>

                <div class="vtabs customvtab m-t-10">
                    <?php echo $__env->make('sections.super_admin_setting_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <div class="tab-content">
                        <div id="vhome3" class="tab-pane active">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <?php echo Form::open(['id'=>'editSettings','class'=>'ajax-form','method'=>'PUT']); ?>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="company_name"><?php echo app('translator')->getFromJson('modules.accountSettings.companyName'); ?></label>
                                                <input type="text" class="form-control" id="company_name" name="company_name"
                                                       value="<?php echo e($global->company_name); ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="company_email"><?php echo app('translator')->getFromJson('modules.accountSettings.companyEmail'); ?></label>
                                                <input type="email" class="form-control" id="company_email" name="company_email"
                                                       value="<?php echo e($global->company_email); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="company_phone"><?php echo app('translator')->getFromJson('modules.accountSettings.companyPhone'); ?></label>
                                                <input type="tel" class="form-control" id="company_phone" name="company_phone"
                                                       value="<?php echo e($global->company_phone); ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1"><?php echo app('translator')->getFromJson('modules.accountSettings.companyWebsite'); ?></label>
                                                <input type="text" class="form-control" id="website" name="website"
                                                       value="<?php echo e($global->website); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4 col-xs-12">
                                            <div class="form-group">
                                                <label for="company_phone"><?php echo app('translator')->getFromJson('modules.invoices.currency'); ?></label>
                                                <select class="form-control" id="currency_id" name="currency_id">
                                                    <?php $__empty_1 = true; $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                        <option <?php if($currency->id == $global->currency_id): ?> selected <?php endif; ?> value="<?php echo e($currency->id); ?>">
                                                            <?php echo e($currency->currency_name); ?> - (<?php echo e($currency->currency_symbol); ?>)
                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4 col-xs-12">
                                            <div class="form-group">
                                                <label for="address"><?php echo app('translator')->getFromJson('modules.accountSettings.defaultTimezone'); ?></label>
                                                <select name="timezone" id="timezone" class="form-control select2">
                                                    <?php $__currentLoopData = $timezones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option <?php if($global->timezone == $tz): ?> selected <?php endif; ?>><?php echo e($tz); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4 col-xs-12">
                                            <div class="form-group">
                                                <label for="address"><?php echo app('translator')->getFromJson('modules.accountSettings.changeLanguage'); ?></label>
                                                <select name="locale" id="locale" class="form-control select2">
                                                    <option <?php if($global->locale == "en"): ?> selected <?php endif; ?> value="en">English
                                                    </option>
                                                    <?php $__currentLoopData = $languageSettings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($language->language_code); ?>" <?php if($global->locale == $language->language_code): ?> selected <?php endif; ?> ><?php echo e($language->language_name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="google_recaptcha_key"><?php echo app('translator')->getFromJson('modules.accountSettings.google_recaptcha_key'); ?></label>
                                                <input type="tel" class="form-control" id="google_recaptcha_key" name="google_recaptcha_key"
                                                       value="<?php echo e($global->google_recaptcha_key); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1"><?php echo app('translator')->getFromJson('modules.accountSettings.companyLogo'); ?></label>

                                                <div class="col-md-12">
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail"
                                                             style="width: 200px; height: 150px;">
                                                            <?php if(is_null($global->logo)): ?>
                                                                <img src="<?php echo e(asset('logo-1.png')); ?>"
                                                                     alt=""/>
                                                            <?php else: ?>
                                                                <img src="<?php echo e(asset('user-uploads/app-logo/'.$global->logo)); ?>"
                                                                     alt=""/>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail"
                                                             style="max-width: 200px; max-height: 150px;"></div>
                                                        <div>
                                <span class="btn btn-info btn-file">
                                    <span class="fileinput-new"> <?php echo app('translator')->getFromJson('app.selectImage'); ?> </span>
                                    <span class="fileinput-exists"> <?php echo app('translator')->getFromJson('app.change'); ?> </span>
                                    <input type="file" name="logo" id="logo"> </span>
                                                            <a href="javascript:;" class="btn btn-danger fileinput-exists"
                                                               data-dismiss="fileinput"> <?php echo app('translator')->getFromJson('app.remove'); ?> </a>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label><?php echo app('translator')->getFromJson('modules.themeSettings.loginScreenBackground'); ?></label>

                                                <div class="col-md-12 m-b-20">
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail"
                                                             style="width: 200px; height: 150px;">
                                                            <?php if(is_null($global->login_background)): ?>
                                                                <img src="<?php echo e(asset('login-bg.jpg')); ?>"
                                                                     alt=""/>
                                                            <?php else: ?>
                                                                <img src="<?php echo e(asset('user-uploads/login-background.jpg')); ?>"
                                                                     alt=""/>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail"
                                                             style="max-width: 200px; max-height: 150px;"></div>
                                                        <div>
                                    <span class="btn btn-info btn-file">
                                    <span class="fileinput-new"> <?php echo app('translator')->getFromJson('app.selectImage'); ?> </span>
                                    <span class="fileinput-exists"> <?php echo app('translator')->getFromJson('app.change'); ?> </span>
                                    <input type="file" name="login_background" id="login_background"> </span>
                                                            <a href="javascript:;" class="btn btn-danger fileinput-exists"
                                                               data-dismiss="fileinput"> <?php echo app('translator')->getFromJson('app.remove'); ?> </a>
                                                        </div>
                                                    </div>
                                                    <div class="note">Recommended size: 1500 X 1056 (Pixels)</div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="address"><?php echo app('translator')->getFromJson('modules.accountSettings.companyAddress'); ?></label>
                                                <textarea class="form-control" id="address" rows="5"
                                                          name="address"><?php echo e($global->address); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" id="save-form"
                                            class="btn btn-success waves-effect waves-light m-r-10">
                                        <?php echo app('translator')->getFromJson('app.update'); ?>
                                    </button>
                                    <button type="reset"
                                            class="btn btn-inverse waves-effect waves-light"><?php echo app('translator')->getFromJson('app.reset'); ?></button>
                                    <?php echo Form::close(); ?>

                                </div>
                            </div>

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
<script src="<?php echo e(asset('plugins/bower_components/custom-select/custom-select.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js')); ?>"></script>

<script>

    $(".select2").select2({
        formatNoMatches: function () {
            return "<?php echo e(__('messages.noRecordFound')); ?>";
        }
    });

    $('#refresh-cache').click(function () {
        $.easyAjax({
            url: '<?php echo e(url("refresh-cache")); ?>',
            type: "GET",
            success: function() {
                window.location.reload();
            }
        })
    });

    $('#clear-cache').click(function () {
        $.easyAjax({
            url: '<?php echo e(url("clear-cache")); ?>',
            type: "GET",
            success: function() {
                window.location.reload();
            }
        })
    });

    $('#save-form').click(function () {
        $.easyAjax({
            url: '<?php echo e(route('super-admin.settings.update', $global->id)); ?>',
            container: '#editSettings',
            type: "POST",
            redirect: true,
            file: true,
        })
    });

</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.super-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/super-admin/settings/edit.blade.php ENDPATH**/ ?>