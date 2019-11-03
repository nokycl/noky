<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title"><?php echo app('translator')->getFromJson('modules.accountSettings.currencyConverterKey'); ?></h4>
</div>
<div class="modal-body">
    <div class="portlet-body">
        <div class="alert alert-info ">
            <i class="fa fa-info-circle"></i> <?php echo app('translator')->getFromJson('messages.currencyConvertApiKeyUrl'); ?> <a href="https://www.currencyconverterapi.com" target="_blank"> https://www.currencyconverterapi.com</a>
        </div>
        <?php echo Form::open(['id'=>'createCurrencyKey','class'=>'ajax-form','method'=>'POST']); ?>

        <div class="form-body">
            <div class="row">
                <div class="col-xs-12 ">
                    <div class="form-group">
                        <label><?php echo app('translator')->getFromJson('modules.accountSettings.currencyConverterKey'); ?></label>
                        <input type="text" name="currency_converter_key" id="currency_converter_key" value="<?php echo e($global->currency_converter_key); ?>" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="button" id="save-category" class="btn btn-success"> <i class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.save'); ?></button>
        </div>
        <?php echo Form::close(); ?>

    </div>
</div>

<script>

    $('#save-category').click(function () {
        $.easyAjax({
            url: '<?php echo e(route('super-admin.currency.exchange-key-store')); ?>',
            container: '#createCurrencyKey',
            type: "POST",
            data: $('#createCurrencyKey').serialize(),
            success: function (response) {
              $('#projectCategoryModal').modal('hide');
              window.location.reload();
            }
        })
    });
</script><?php /**PATH C:\xampp\htdocs\noky\resources\views/super-admin/currency-settings/currency_exchange_key.blade.php ENDPATH**/ ?>