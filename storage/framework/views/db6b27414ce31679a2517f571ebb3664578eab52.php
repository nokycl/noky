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
                <li class="active"><?php echo app('translator')->getFromJson('app.update'); ?></li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-6">
            <div class="white-box">
                <h3 class="box-title m-b-0"><?php echo app('translator')->getFromJson("modules.currencySettings.updateTitle"); ?></h3>

                <p class="text-muted m-b-30 font-13"></p>

                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <?php echo Form::open(['id'=>'updateCurrency','class'=>'ajax-form','method'=>'PUT']); ?>

                        <div class="form-group">
                            <label for="currency_name"><?php echo app('translator')->getFromJson("modules.currencySettings.currencyName"); ?></label>
                            <input type="text" class="form-control" id="currency_name" name="currency_name" value="<?php echo e($currency->currency_name); ?>">
                        </div>
                        <div class="form-group">
                            <label><?php echo app('translator')->getFromJson('modules.currencySettings.isCryptoCurrency'); ?>?</label>
                            <div class="radio-list">
                                <label class="radio-inline p-0">
                                    <div class="radio radio-info">
                                        <input type="radio" name="is_cryptocurrency" <?php if($currency->is_cryptocurrency == 'yes'): ?> checked <?php endif; ?> id="crypto_currency_yes" value="yes">
                                        <label for="crypto_currency_yes"><?php echo app('translator')->getFromJson('app.yes'); ?></label>
                                    </div>
                                </label>
                                <label class="radio-inline">
                                    <div class="radio radio-info">
                                        <input type="radio" name="is_cryptocurrency" <?php if($currency->is_cryptocurrency == 'no'): ?> checked <?php endif; ?> id="crypto_currency_no" value="no">
                                        <label for="crypto_currency_no"><?php echo app('translator')->getFromJson('app.no'); ?></label>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="form-group" >
                            <label for="currency_symbol"><?php echo app('translator')->getFromJson("modules.currencySettings.currencySymbol"); ?></label>
                            <input type="text" class="form-control" id="currency_symbol" name="currency_symbol" value="<?php echo e($currency->currency_symbol); ?>">
                        </div>
                        <div class="form-group">
                            <label for="currency_code"><?php echo app('translator')->getFromJson("modules.currencySettings.currencyCode"); ?></label>
                            <input type="text" class="form-control" id="currency_code" name="currency_code" value="<?php echo e($currency->currency_code); ?>">
                        </div>

                        <div class="form-group crypto-currency" <?php if($currency->is_cryptocurrency == 'no'): ?> style="display: none" <?php endif; ?>>
                            <label for="usd_price"><?php echo app('translator')->getFromJson('modules.currencySettings.usdPrice'); ?> <a class="mytooltip" href="javascript:void(0)"> <i class="fa fa-info-circle"></i><span class="tooltip-content5"><span class="tooltip-text3"><span class="tooltip-inner2"><?php echo app('translator')->getFromJson('modules.currencySettings.usdPriceInfo'); ?></span></span></span></a></label>
                            <input type="text" class="form-control" id="usd_price" name="usd_price" value="<?php echo e($currency->usd_price); ?>">
                        </div>

                        <div class="form-group regular-currency"  <?php if($currency->is_cryptocurrency == 'yes'): ?> style="display: none;" <?php endif; ?>>
                            <label for="exchange_rate"><?php echo app('translator')->getFromJson("modules.currencySettings.exchangeRate"); ?></label>
                            <input type="text" class="form-control" id="exchange_rate" name="exchange_rate" value="<?php echo e($currency->exchange_rate); ?>">
                            <a href="javascript:;" id="fetch-exchange-rate"><i class="fa fa-refresh fa-spin"></i> Fetch latest exchange rate</a>
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
    $('#save-form').click(function () {
        $.easyAjax({
            url: '<?php echo e(route('super-admin.currency.update', $currency->id )); ?>',
            container: '#updateCurrency',
            type: "POST",
            data: $('#updateCurrency').serialize()
        })
    });

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

    $('#fetch-exchange-rate').click(function () {
        var currencyCode = $('#currency_code').val();
        var url = '<?php echo e(route('super-admin.currency.exchange-rate', '#cc' )); ?>';
        url = url.replace('#cc', currencyCode);

        $.easyAjax({
            url: url,
            type: "GET",
            data: {currencyCode: currencyCode},
            success: function (response) {
                $('#exchange_rate').val(response);
            }
        })
    });
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.super-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\noky\resources\views/super-admin/currency-settings/edit.blade.php ENDPATH**/ ?>