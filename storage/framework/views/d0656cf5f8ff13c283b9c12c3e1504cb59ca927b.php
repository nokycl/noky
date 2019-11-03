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
                <li><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo app('translator')->getFromJson('app.menu.home'); ?></a></li>
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
        <div class="col-md-12">
            <div class="panel panel-inverse">
                <div class="panel-heading"><?php echo app('translator')->getFromJson('modules.accountSettings.updateTitle'); ?></div>

                <div class="vtabs customvtab m-t-10">

                    <?php echo $__env->make('sections.admin_setting_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <div class="tab-content">
                        <div id="vhome3" class="tab-pane active">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <?php echo Form::open(['id'=>'editSettings','class'=>'ajax-form','method'=>'PUT']); ?>

                                    <div class="form-group">
                                        <label for="company_name"><?php echo app('translator')->getFromJson('modules.accountSettings.companyName'); ?></label>
                                        <input type="text" class="form-control" id="company_name" name="company_name"
                                               value="<?php echo e($global->company_name); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="company_email"><?php echo app('translator')->getFromJson('modules.accountSettings.companyEmail'); ?></label>
                                        <input type="email" class="form-control" id="company_email" name="company_email"
                                               value="<?php echo e($global->company_email); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="company_phone"><?php echo app('translator')->getFromJson('modules.accountSettings.companyPhone'); ?></label>
                                        <input type="tel" class="form-control" id="company_phone" name="company_phone"
                                               value="<?php echo e($global->company_phone); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1"><?php echo app('translator')->getFromJson('modules.accountSettings.companyWebsite'); ?></label>
                                        <input type="text" class="form-control" id="website" name="website"
                                               value="<?php echo e($global->website); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1"><?php echo app('translator')->getFromJson('modules.accountSettings.companyLogo'); ?></label>

                                        <div class="col-md-12">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail"
                                                     style="width: 200px; height: 150px;">
                                                    <?php if(is_null($global->logo)): ?>
                                                        <img src="https://placeholdit.imgix.net/~text?txtsize=25&txt=<?php echo app('translator')->getFromJson('modules.accountSettings.uploadLogo'); ?>&w=200&h=150"
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

                                    <div class="form-group">
                                        <label for="address"><?php echo app('translator')->getFromJson('modules.accountSettings.companyAddress'); ?></label>
                                        <textarea class="form-control" id="address" rows="5"
                                                  name="address"><?php echo e($global->address); ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="address"><?php echo app('translator')->getFromJson('modules.accountSettings.defaultCurrency'); ?></label>
                                        <select name="currency_id" id="currency_id" class="form-control">
                                            <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option
                                                        <?php if($currency->id == $global->currency_id): ?> selected <?php endif; ?>
                                                value="<?php echo e($currency->id); ?>"><?php echo e($currency->currency_symbol.' ('.$currency->currency_code.')'); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="address"><?php echo app('translator')->getFromJson('modules.accountSettings.defaultTimezone'); ?></label>
                                        <select name="timezone" id="timezone" class="form-control select2">
                                            <?php $__currentLoopData = $timezones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option <?php if($global->timezone == $tz): ?> selected <?php endif; ?>><?php echo e($tz); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="address"><?php echo app('translator')->getFromJson('modules.accountSettings.dateFormat'); ?></label>
                                        <select name="date_format" id="date_format" class="form-control select2">
                                            <option value="d-m-Y" <?php if($global->date_format == 'd-m-Y'): ?> selected <?php endif; ?> >d-m-Y (<?php echo e($dateObject->format('d-m-Y')); ?>) </option>
                                            <option value="m-d-Y" <?php if($global->date_format == 'm-d-Y'): ?> selected <?php endif; ?> >m-d-Y (<?php echo e($dateObject->format('m-d-Y')); ?>) </option>
                                            <option value="Y-m-d" <?php if($global->date_format == 'Y-m-d'): ?> selected <?php endif; ?> >Y-m-d (<?php echo e($dateObject->format('Y-m-d')); ?>) </option>
                                            <option value="d.m.Y" <?php if($global->date_format == 'd.m.Y'): ?> selected <?php endif; ?> >d.m.Y (<?php echo e($dateObject->format('d.m.Y')); ?>) </option>
                                            <option value="m.d.Y" <?php if($global->date_format == 'm.d.Y'): ?> selected <?php endif; ?> >m.d.Y (<?php echo e($dateObject->format('m.d.Y')); ?>) </option>
                                            <option value="Y.m.d" <?php if($global->date_format == 'Y.m.d'): ?> selected <?php endif; ?> >Y.m.d (<?php echo e($dateObject->format('Y.m.d')); ?>) </option>
                                            <option value="d/m/Y" <?php if($global->date_format == 'd/m/Y'): ?> selected <?php endif; ?> >d/m/Y (<?php echo e($dateObject->format('d/m/Y')); ?>) </option>
                                            <option value="m/d/Y" <?php if($global->date_format == 'm/d/Y'): ?> selected <?php endif; ?> >m/d/Y (<?php echo e($dateObject->format('m/d/Y')); ?>) </option>
                                            <option value="Y/m/d" <?php if($global->date_format == 'Y/m/d'): ?> selected <?php endif; ?> >Y/m/d (<?php echo e($dateObject->format('Y/m/d')); ?>) </option>
                                            <option value="d-M-Y" <?php if($global->date_format == 'd-M-Y'): ?> selected <?php endif; ?> >d-M-Y (<?php echo e($dateObject->format('d-M-Y')); ?>) </option>
                                            <option value="d/M/Y" <?php if($global->date_format == 'd/M/Y'): ?> selected <?php endif; ?> >d/M/Y (<?php echo e($dateObject->format('d/M/Y')); ?>) </option>
                                            <option value="d.M.Y" <?php if($global->date_format == 'd.M.Y'): ?> selected <?php endif; ?> >d.M.Y (<?php echo e($dateObject->format('d.M.Y')); ?>) </option>
                                            <option value="d-M-Y" <?php if($global->date_format == 'd-M-Y'): ?> selected <?php endif; ?> >d-M-Y (<?php echo e($dateObject->format('d-M-Y')); ?>) </option>
                                            <option value="d M Y" <?php if($global->date_format == 'd M Y'): ?> selected <?php endif; ?> >d M Y (<?php echo e($dateObject->format('d M Y')); ?>) </option>
                                            <option value="d F, Y" <?php if($global->date_format == 'd F, Y'): ?> selected <?php endif; ?> >d F, Y (<?php echo e($dateObject->format('d F, Y')); ?>) </option>
                                            <option value="D/M/Y" <?php if($global->date_format == 'D/M/Y'): ?> selected <?php endif; ?> >D/M/Y (<?php echo e($dateObject->format('D/M/Y')); ?>) </option>
                                            <option value="D.M.Y" <?php if($global->date_format == 'D.M.Y'): ?> selected <?php endif; ?> >D.M.Y (<?php echo e($dateObject->format('D.M.Y')); ?>) </option>
                                            <option value="D-M-Y" <?php if($global->date_format == 'D-M-Y'): ?> selected <?php endif; ?> >D-M-Y (<?php echo e($dateObject->format('D-M-Y')); ?>) </option>
                                            <option value="D M Y" <?php if($global->date_format == 'D M Y'): ?> selected <?php endif; ?> >D M Y (<?php echo e($dateObject->format('D M Y')); ?>) </option>
                                            <option value="d D M Y" <?php if($global->date_format == 'd D M Y'): ?> selected <?php endif; ?> >d D M Y (<?php echo e($dateObject->format('d D M Y')); ?>) </option>
                                            <option value="D d M Y" <?php if($global->date_format == 'D d M Y'): ?> selected <?php endif; ?> >D d M Y (<?php echo e($dateObject->format('D d M Y')); ?>) </option>
                                            <option value="dS M Y" <?php if($global->date_format == 'dS M Y'): ?> selected <?php endif; ?> >dS M Y (<?php echo e($dateObject->format('dS M Y')); ?>) </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="address"><?php echo app('translator')->getFromJson('modules.accountSettings.timeFormat'); ?></label>
                                        <select name="time_format" id="time_format" class="form-control select2">
                                            <option value="h:i A" <?php if($global->time_format == 'H:i A'): ?> selected <?php endif; ?> >12 Hour  (6:20 PM) </option>
                                            <option value="h:i a" <?php if($global->time_format == 'H:i a'): ?> selected <?php endif; ?> >12 Hour  (6:20 pm) </option>
                                            <option value="H:i" <?php if($global->time_format == 'H:i'): ?> selected <?php endif; ?> >24 Hour  (18:20) </option>
                                        </select>
                                    </div>
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

    $('#save-form').click(function () {
        $.easyAjax({
            url: '<?php echo e(route('admin.settings.update', [$global->id])); ?>',
            container: '#editSettings',
            type: "POST",
            redirect: true,
            file: true
        })
    });

</script>

<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/settings/edit.blade.php ENDPATH**/ ?>