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
                <li><a href="<?php echo e(route('super-admin.currency.index')); ?>"><?php echo e(__($pageTitle)); ?></a></li>
                <li class="active"><?php echo app('translator')->getFromJson('app.addNew'); ?></li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-6">
            <div class="white-box">
                <h3 class="box-title m-b-0"><?php echo app('translator')->getFromJson('modules.currencySettings.addNewCurrency'); ?></h3>

                <p class="text-muted m-b-30 font-13"></p>

                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <?php echo Form::open(['id'=>'createCurrency','class'=>'ajax-form','method'=>'POST']); ?>

                        <div class="form-group">
                            <label for="company_name"><?php echo app('translator')->getFromJson('modules.currencySettings.currencyName'); ?></label>
                            <input type="text" class="form-control" id="currency_name" name="currency_name"
                                   placeholder="Enter Currency Name">
                        </div>
                        <div class="form-group">
                            <label><?php echo app('translator')->getFromJson('modules.currencySettings.isCryptoCurrency'); ?>?</label>
                            <div class="radio-list">
                                <label class="radio-inline p-0">
                                    <div class="radio radio-info">
                                        <input type="radio" name="is_cryptocurrency" id="crypto_currency_yes" value="yes">
                                        <label for="crypto_currency_yes"><?php echo app('translator')->getFromJson('app.yes'); ?></label>
                                    </div>
                                </label>
                                <label class="radio-inline">
                                    <div class="radio radio-info">
                                        <input type="radio" name="is_cryptocurrency" checked id="crypto_currency_no" value="no">
                                        <label for="crypto_currency_no"><?php echo app('translator')->getFromJson('app.no'); ?></label>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="company_email"><?php echo app('translator')->getFromJson('modules.currencySettings.currencySymbol'); ?></label>
                            <input type="text" class="form-control" id="currency_symbol" name="currency_symbol">
                        </div>
                        <div class="form-group">
                            <label for="company_phone"><?php echo app('translator')->getFromJson('modules.currencySettings.currencyCode'); ?></label>
                            <input type="text" class="form-control" id="currency_code" name="currency_code" >
                        </div>
                        <div class="form-group crypto-currency" style="display: none">
                            <label for="usd_price"><?php echo app('translator')->getFromJson('modules.currencySettings.usdPrice'); ?> <a class="mytooltip" href="javascript:void(0)"> <i class="fa fa-info-circle"></i><span class="tooltip-content5"><span class="tooltip-text3"><span class="tooltip-inner2"><?php echo app('translator')->getFromJson('modules.currencySettings.usdPriceInfo'); ?></span></span></span></a></label>
                            <input type="text" class="form-control" id="usd_price" name="usd_price" >
                        </div>

                        <button type="submit" id="save-form" class="btn btn-success waves-effect waves-light m-r-10">
                            <?php echo app('translator')->getFromJson('app.save'); ?>
                        </button>
                        <button type="reset" class="btn btn-inverse waves-effect waves-light"><?php echo app('translator')->getFromJson('app.reset'); ?></button>
                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .row -->

<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-script'); ?>
<script>

    $("input[name=is_cryptocurrency]").click(function () {
        if($(this).val() == 'yes'){
            $('.regular-currency').hide();
            $('.crypto-currency').show();
        }
        else{
            $('.crypto-currency').hide();
            $('.regular-currency').show();
        }
    })


    $('#save-form').click(function () {
        $.easyAjax({
            url: '<?php echo e(route('super-admin.currency.store')); ?>',
            container: '#createCurrency',
            type: "POST",
            redirect: true,
            data: $('#createCurrency').serialize()
        })
    });
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.super-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\noky\resources\views/super-admin/currency-settings/create.blade.php ENDPATH**/ ?>