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
                <li><a href="<?php echo e(route('super-admin.companies.index')); ?>"><?php echo e(__($pageTitle)); ?></a></li>
                <li class="active"><?php echo app('translator')->getFromJson('app.edit'); ?></li>
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
                <div class="panel-heading"><?php echo app('translator')->getFromJson('app.update'); ?> <?php echo app('translator')->getFromJson('app.company'); ?></div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <?php echo Form::open(['id'=>'updateCompany','class'=>'ajax-form','method'=>'PUT', 'enctype' => 'multipart/form-data']); ?>

                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_name"><?php echo app('translator')->getFromJson('modules.accountSettings.companyName'); ?></label>
                                        <input type="text" class="form-control" id="company_name" name="company_name"
                                               value="<?php echo e($company->company_name ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_email"><?php echo app('translator')->getFromJson('modules.accountSettings.companyEmail'); ?></label>
                                        <input type="email" class="form-control" id="company_email" name="company_email"
                                               value="<?php echo e($company->company_email ?? ''); ?>">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_phone"><?php echo app('translator')->getFromJson('modules.accountSettings.companyPhone'); ?></label>
                                        <input type="tel" class="form-control" id="company_phone" name="company_phone"
                                               value="<?php echo e($company->company_phone ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1"><?php echo app('translator')->getFromJson('modules.accountSettings.companyWebsite'); ?></label>
                                        <input type="text" class="form-control" id="website" name="website"
                                               value="<?php echo e($company->website ?? ''); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1"><?php echo app('translator')->getFromJson('modules.accountSettings.companyLogo'); ?></label>

                                        <div class="col-md-12">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail"
                                                     style="width: 200px; height: 150px;">
                                                    <?php if(is_null($company->logo)): ?>
                                                        <img src="https://placeholdit.imgix.net/~text?txtsize=25&txt=<?php echo app('translator')->getFromJson('modules.accountSettings.uploadLogo'); ?>&w=200&h=150"
                                                             alt=""/>
                                                    <?php else: ?>
                                                        <img src="<?php echo e(asset('user-uploads/app-logo/'.$company->logo)); ?>"
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

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo app('translator')->getFromJson('app.status'); ?></label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="">-</option>
                                            <option value="active" <?php if($company->status == 'active'): ?> selected <?php endif; ?>><?php echo app('translator')->getFromJson('app.active'); ?></option>
                                            <option value="inactive" <?php if($company->status == 'inactive'): ?> selected <?php endif; ?>><?php echo app('translator')->getFromJson('app.inactive'); ?></option>
                                            <option value="license_expired" <?php if($company->status == 'license_expired'): ?> selected <?php endif; ?>><?php echo app('translator')->getFromJson('modules.dashboard.licenseExpired'); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address"><?php echo app('translator')->getFromJson('modules.accountSettings.companyAddress'); ?></label>
                                        <textarea class="form-control" id="address" rows="5"
                                                  name="address"><?php echo e($company->address ?? ''); ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address"><?php echo app('translator')->getFromJson('modules.accountSettings.defaultCurrency'); ?></label>
                                        <select name="currency_id" id="currency_id" class="form-control">
                                            <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option
                                                        <?php if($currency->id == $company->currency_id): ?> selected <?php endif; ?>
                                                value="<?php echo e($currency->id); ?>"><?php echo e($currency->currency_symbol.' ('.$currency->currency_code.')'); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address"><?php echo app('translator')->getFromJson('modules.accountSettings.defaultTimezone'); ?></label>
                                        <select name="timezone" id="timezone" class="form-control select2">
                                            <?php $__currentLoopData = $timezones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option <?php if($company->timezone == $tz): ?> selected <?php endif; ?>><?php echo e($tz); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address"><?php echo app('translator')->getFromJson('modules.accountSettings.changeLanguage'); ?></label>
                                        <select name="locale" id="locale" class="form-control select2">
                                            <option <?php if($company->locale == "en"): ?> selected <?php endif; ?> value="en">English
                                            </option>
                                            <?php $__currentLoopData = $languageSettings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($language->language_code); ?>" <?php if($company->locale == $language->language_code): ?> selected <?php endif; ?> ><?php echo e($language->language_name ?? ''); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" id="save-form" class="btn btn-success"> <i class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.update'); ?></button>
                            <a href="<?php echo e(route('super-admin.companies.index')); ?>" class="btn btn-default"><?php echo app('translator')->getFromJson('app.back'); ?></a>
                        </div>
                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>    <!-- .row -->

<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-script'); ?>

    <script src="<?php echo e(asset('plugins/bower_components/custom-select/custom-select.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js')); ?>"></script>
    <script>
        $('#save-form').click(function () {
            $.easyAjax({
                url: '<?php echo e(route('super-admin.companies.update', [$company->id])); ?>',
                container: '#updateCompany',
                type: "POST",
                redirect: true,
                file: true
            })
        });

        $(".select2").select2({
            formatNoMatches: function () {
                return "<?php echo e(__('messages.noRecordFound')); ?>";
            }
        });

    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.super-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/super-admin/companies/edit.blade.php ENDPATH**/ ?>