<div class="row">
    <div class="col-md-12">
        <div class="panel panel-inverse">
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="packageName">Package</label>
                                    <select name="package" id="packageName" class="form-control select2">
                                        <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($package->id); ?>"
                                                    <?php if($company->package_id == $package->id): ?> selected <?php endif; ?> ><?php echo e($package->name ?? ''); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="packageType">Package Type</label>
                                    <select name="packageType" id="packageType" class="form-control select2">
                                        <option value="annual" <?php if($company->package_type == 'annual'): ?> selected <?php endif; ?> >
                                            Annual
                                        </option>
                                        <option value="monthly"
                                                <?php if($company->package_type == 'monthly'): ?> selected <?php endif; ?> >Monthly
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="packageAmount">Amount</label>
                                    <input type="text" name="amount" id="packageAmount" class="form-control" value="<?php echo e(!empty($currentPackage) ? $currentPackage->{$company->package_type . '_price'} : ''); ?>">
                                </div>
                            </div>

                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Pay Date</label>
                                    <input type="text" name="pay_date" id="pay_date" class="form-control" value="<?php echo e($lastInvoice && $lastInvoice->pay_date ? $lastInvoice->pay_date->format('m/d/Y') : ''); ?>">
                                </div>
                            </div>

                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Next Pay Date</label>
                                    <input type="text" name="next_pay_date" id="next_pay_date" class="form-control" value="<?php echo e($lastInvoice && $lastInvoice->next_pay_date ? $lastInvoice->next_pay_date->format('m/d/Y') : ''); ?>">
                                </div>
                            </div>

                            <!--/span-->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Licence Expires On</label>
                                    <input type="text" name="licence_expires_on" id="licence_expires_on" class="form-control" value="<?php echo e($company->licence_expire_on ? $company->licence_expire_on->format('m/d/Y') : ''); ?>" disabled="disabled">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var packageInfo = <?php echo json_encode($packageInfo, 15, 512) ?>

    $("#pay_date").datepicker({
        todayHighlight: true,
        autoclose: true,
    }).on('change', function () {
        updateExpiryDate();
    });

    $("#next_pay_date").datepicker({
        todayHighlight: true,
        autoclose: true,
    });

    $('#packageType').off().on('change', function () {
        $('#packageAmount').val(packageInfo[$('#packageName').val()][$(this).val()]);
        updateExpiryDate();
    });

    $('#packageName').off().on('change', function () {
        $('#packageAmount').val(packageInfo[$(this).val()][$('#packageType').val()]);
    });

    function updateExpiryDate() {
        let startDate = moment($("#pay_date").val(), "MM-DD-YYYY");
        let endDate = startDate.add(1, ($('#packageType').val() === 'monthly') ? 'months' : 'year').format("MM/DD/YYYY");
        $('#licence_expires_on').val(endDate);
    }

    $('#update-company-form').off().submit(function (e) {
        e.preventDefault();
        const PackageName = $('#packageName').val();
        const PackageType = $('#PackageType').val();
        $.easyAjax({
            url: '<?php echo e(route('super-admin.companies.edit-package.post', [$company->id])); ?>',
            container: '#update-company-form',
            type: "POST",
            redirect: false,
            data: $(this).serialize(),
            success: function () {
                $('#packageUpdateModal').modal('hide');
            }
        });
    });
</script>
<?php /**PATH /var/www/html/resources/views/super-admin/companies/editPackage.blade.php ENDPATH**/ ?>