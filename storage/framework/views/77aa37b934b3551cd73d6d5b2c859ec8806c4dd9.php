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
                <li><a href="<?php echo e(route('admin.clients.index')); ?>"><?php echo e(__($pageTitle)); ?></a></li>
                <li class="active"><?php echo app('translator')->getFromJson('app.edit'); ?></li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('head-script'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('image-picker/image-picker.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/switchery/dist/switchery.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('plugins/steps-form/steps.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-inverse">
                <div class="panel-heading"><?php echo app('translator')->getFromJson('app.menu.accountSetup'); ?></div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <div id="updateClient">
                        <!-- progressbar -->
                            <ul id="progressbar">
                                <li class="active"><?php echo app('translator')->getFromJson('app.menu.accountSetup'); ?></li>
                                <li><?php echo app('translator')->getFromJson('modules.accountSettings.updateTitle'); ?></li>
                                <li><?php echo app('translator')->getFromJson('modules.invoiceSettings.updateTitle'); ?></li>
                            </ul>
                            <!-- fieldsets -->
                            <fieldset>
                                <h2 class="fs-title"><?php echo app('translator')->getFromJson('app.congratulations'); ?>!</h2>
                                <h3 class="fs-subtitle"><?php echo app('translator')->getFromJson('app.paperlessOffice'); ?></h3>
                                <input type="button" name="next" class="next action-button" value="Next" />
                            </fieldset>
                            <fieldset>
                                <?php echo Form::open(['id'=>'companySettings','class'=>'ajax-form','method'=>'PUT']); ?>

                                    <h3 class="fs-subtitle"><?php echo app('translator')->getFromJson('modules.accountSettings.updateTitle'); ?></h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="company_name"><?php echo app('translator')->getFromJson('modules.accountSettings.companyName'); ?></label>
                                                <input type="text" class="form-control" id="company_name" name="company_name"
                                                       value="<?php echo e($global->company_name); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="company_email"><?php echo app('translator')->getFromJson('modules.accountSettings.companyEmail'); ?></label>
                                                <input type="email" class="form-control" id="company_email" name="company_email"
                                                       value="<?php echo e($global->company_email); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="company_phone"><?php echo app('translator')->getFromJson('modules.accountSettings.companyPhone'); ?></label>
                                                <input type="tel" class="form-control" id="company_phone" name="company_phone"
                                                       value="<?php echo e($global->company_phone); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1"><?php echo app('translator')->getFromJson('modules.accountSettings.companyWebsite'); ?></label>
                                                <input type="text" class="form-control" id="website" name="website"
                                                       value="<?php echo e($global->website); ?>">
                                            </div>
                                        </div>
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
                                                        <input type="file" name="logo" id="logo">
                                                    </span>
                                                    <a href="javascript:;" class="btn btn-danger fileinput-exists"
                                                       data-dismiss="fileinput"> <?php echo app('translator')->getFromJson('app.remove'); ?> </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address"><?php echo app('translator')->getFromJson('modules.accountSettings.companyAddress'); ?></label>
                                                <textarea class="form-control" id="address" rows="2"
                                                          name="address"><?php echo e($global->address); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="currency_id"><?php echo app('translator')->getFromJson('modules.accountSettings.defaultCurrency'); ?></label>
                                                <select name="currency_id" id="currency_id" class="form-control">
                                                    <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option
                                                                <?php if($currency->id == $global->currency_id): ?> selected <?php endif; ?>
                                                        value="<?php echo e($currency->id); ?>"><?php echo e($currency->currency_symbol.' ('.$currency->currency_code.')'); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="timezone"><?php echo app('translator')->getFromJson('modules.accountSettings.defaultTimezone'); ?></label>
                                                <select name="timezone" id="timezone" class="form-control select2">
                                                    <?php $__currentLoopData = $timezones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option <?php if($global->timezone == $tz): ?> selected <?php endif; ?>><?php echo e($tz); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="date_format"><?php echo app('translator')->getFromJson('modules.accountSettings.dateFormat'); ?></label>
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
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="time_format"><?php echo app('translator')->getFromJson('modules.accountSettings.timeFormat'); ?></label>
                                                <select name="time_format" id="time_format" class="form-control select2">
                                                    <option value="h:i A" <?php if($global->time_format == 'H:i A'): ?> selected <?php endif; ?> >12 Hour  (6:20 PM) </option>
                                                    <option value="h:i a" <?php if($global->time_format == 'H:i a'): ?> selected <?php endif; ?> >12 Hour  (6:20 pm) </option>
                                                    <option value="H:i" <?php if($global->time_format == 'H:i'): ?> selected <?php endif; ?> >24 Hour  (18:20) </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="locale"><?php echo app('translator')->getFromJson('modules.accountSettings.changeLanguage'); ?></label>
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
                                    <button type="submit" id="save-form" class="btn btn-success"> <i class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.update'); ?></button>
                                <?php echo Form::close(); ?>

                                <input type="button" name="next" class="next action-button" value="Next" style="display: none" />
                            </fieldset>
                            <fieldset>
                                <?php echo Form::open(['id'=>'invoiceSettings','class'=>'ajax-form','method'=>'PUT']); ?>

                                    
                                    <h3 class="fs-subtitle"><?php echo app('translator')->getFromJson('modules.invoiceSettings.updateTitle'); ?></h3>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="invoice_prefix"><?php echo app('translator')->getFromJson('modules.invoiceSettings.invoicePrefix'); ?></label>
                                                <input type="text" class="form-control" id="invoice_prefix" name="invoice_prefix"
                                                       value="<?php echo e($invoiceSetting->invoice_prefix); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="invoice_digit"><?php echo app('translator')->getFromJson('modules.invoiceSettings.invoiceDigit'); ?></label>
                                                <input type="number" min="2" class="form-control" id="invoice_digit" name="invoice_digit"
                                                       value="<?php echo e($invoiceSetting->invoice_digit); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="invoice_look_like"><?php echo app('translator')->getFromJson('modules.invoiceSettings.invoiceLookLike'); ?></label>
                                                <input type="text" class="form-control" id="invoice_look_like" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="estimate_prefix"><?php echo app('translator')->getFromJson('modules.invoiceSettings.estimatePrefix'); ?></label>
                                                <input type="text" class="form-control" id="estimate_prefix" name="estimate_prefix"
                                                       value="<?php echo e($invoiceSetting->estimate_prefix); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="estimate_digit"><?php echo app('translator')->getFromJson('modules.invoiceSettings.estimateDigit'); ?></label>
                                                <input type="number" min="2" class="form-control" id="estimate_digit" name="estimate_digit"
                                                       value="<?php echo e($invoiceSetting->estimate_digit); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="estimate_look_like"><?php echo app('translator')->getFromJson('modules.invoiceSettings.estimateLookLike'); ?></label>
                                                <input type="text" class="form-control" id="estimate_look_like" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="credit_note_prefix"><?php echo app('translator')->getFromJson('modules.invoiceSettings.credit_notePrefix'); ?></label>
                                                <input type="text" class="form-control" id="credit_note_prefix" name="credit_note_prefix"
                                                       value="<?php echo e($invoiceSetting->credit_note_prefix); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="credit_note_digit"><?php echo app('translator')->getFromJson('modules.invoiceSettings.credit_noteDigit'); ?></label>
                                                <input type="number" min="2" class="form-control" id="credit_note_digit" name="credit_note_digit"
                                                       value="<?php echo e($invoiceSetting->credit_note_digit); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="credit_note_look_like"><?php echo app('translator')->getFromJson('modules.invoiceSettings.credit_noteLookLike'); ?></label>
                                                <input type="text" class="form-control" id="credit_note_look_like" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="template"><?php echo app('translator')->getFromJson('modules.invoiceSettings.template'); ?></label>
                                                <select name="template" class="image-picker show-labels show-html">
                                                    <option data-img-src="<?php echo e(asset('invoice-template/1.png')); ?>"
                                                            <?php if($invoiceSetting->template == 'invoice-1'): ?> selected <?php endif; ?>
                                                            value="invoice-1">Template
                                                        1
                                                    </option>
                                                    <option data-img-src="<?php echo e(asset('invoice-template/2.png')); ?>"
                                                            <?php if($invoiceSetting->template == 'invoice-2'): ?> selected <?php endif; ?>
                                                            value="invoice-2">Template
                                                        2
                                                    </option>
                                                    <option data-img-src="<?php echo e(asset('invoice-template/3.png')); ?>"
                                                            <?php if($invoiceSetting->template == 'invoice-3'): ?> selected <?php endif; ?>
                                                            value="invoice-3">Template
                                                        3
                                                    </option>
                                                    <option data-img-src="<?php echo e(asset('invoice-template/4.png')); ?>"
                                                            <?php if($invoiceSetting->template == 'invoice-4'): ?> selected <?php endif; ?>
                                                            value="invoice-4">Template
                                                        4
                                                    </option>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="due_after"><?php echo app('translator')->getFromJson('modules.invoiceSettings.dueAfter'); ?></label>

                                                <div class="input-group m-t-10">
                                                    <input type="number" id="due_after" name="due_after" class="form-control" value="<?php echo e($invoiceSetting->due_after); ?>">
                                                    <span class="input-group-addon"><?php echo app('translator')->getFromJson('app.days'); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="gst_number"><?php echo app('translator')->getFromJson('app.gstNumber'); ?></label>
                                                <input type="text" id="gst_number" name="gst_number" class="form-control" value="<?php echo e($invoiceSetting->gst_number); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label" ><?php echo app('translator')->getFromJson('app.showGst'); ?></label>
                                                <div class="switchery-demo">
                                                    <input type="checkbox" name="show_gst" <?php if($invoiceSetting->show_gst == 'yes'): ?> checked <?php endif; ?> class="js-switch " data-color="#99d683"  />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="invoice_terms"><?php echo app('translator')->getFromJson('modules.invoiceSettings.invoiceTerms'); ?></label>
                                                <textarea name="invoice_terms" id="invoice_terms" class="form-control"
                                                          rows="4"><?php echo e($invoiceSetting->invoice_terms); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                <button type="submit" id="save-form" class="btn btn-success"> <i class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.update'); ?></button>
                                <?php echo Form::close(); ?>

                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    <!-- .row -->

<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-script'); ?>
    <script src="<?php echo e(asset('plugins/steps-form/steps.js')); ?>"></script>
    <script src="<?php echo e(asset('image-picker/image-picker.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/bower_components/switchery/dist/switchery.min.js')); ?>"></script>


    <script>
        $(".image-picker").imagepicker();
        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function () {
            new Switchery($(this)[0], $(this).data());

        });
        $('#companySettings #save-form').click(function () {
            $.easyAjax({
                url: '<?php echo e(route('admin.account-setup.update', $global->id)); ?>',
                container: '#companySettings',
                type: "POST",
                data: $('#companySettings').serialize(),
                success: function (response) {
                    console.log(response);
                    if(response.status == 'success'){
                        $('#companySettings').siblings('.next').trigger('click');
                    }
                }
            })
        });
        $('#invoiceSettings #save-form').click(function () {
            $.easyAjax({
                url: '<?php echo e(route('admin.account-setup.update-invoice', $invoiceSetting->id)); ?>',
                container: '#invoiceSettings',
                type: "POST",
                data: $('#invoiceSettings').serialize()
            })
        });

        $('#invoice_prefix, #invoice_digit, #estimate_prefix, #estimate_digit, #credit_note_prefix, #credit_note_digit').on('keyup', function () {
            genrateInvoiceNumber();
        });

        genrateInvoiceNumber();

        function genrateInvoiceNumber() {
            var invoicePrefix = $('#invoice_prefix').val();
            var invoiceDigit = $('#invoice_digit').val();
            var invoiceZero = '';
            for ($i=0; $i<invoiceDigit-1; $i++){
                invoiceZero = invoiceZero+'0';
            }
            invoiceZero = invoiceZero+'1';
            var invoice_no = invoicePrefix+'#'+invoiceZero;
            $('#invoice_look_like').val(invoice_no);

            var estimatePrefix = $('#estimate_prefix').val();
            var estimateDigit = $('#estimate_digit').val();
            var estimateZero = '';
            for ($i=0; $i<estimateDigit-1; $i++){
                estimateZero = estimateZero+'0';
            }
            estimateZero = estimateZero+'1';
            var estimate_no = estimatePrefix+'#'+estimateZero;
            $('#estimate_look_like').val(estimate_no);

            var creditNotePrefix = $('#credit_note_prefix').val();
            var creditNoteDigit = $('#credit_note_digit').val();
            var creditNoteZero = '';
            for ($i=0; $i<creditNoteDigit-1; $i++){
                creditNoteZero = creditNoteZero+'0';
            }
            creditNoteZero = creditNoteZero+'1';
            var creditNote_no = creditNotePrefix+'#'+creditNoteZero;
            $('#credit_note_look_like').val(creditNote_no);
        }
    </script>
    <script>
        $(".date-picker").datepicker({
            todayHighlight: true,
            autoclose: true
        });

        
        
        
        
        
        
        
        
        
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/account-setup/edit.blade.php ENDPATH**/ ?>