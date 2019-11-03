<style>
    .stripe-button-el{
        display: none;
    }
</style>
<div id="event-detail">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="fa fa-cash"></i> Choose Payment Method</h4>
    </div>
    <div class="modal-body">
        <div class="form-body">
            <div class="row">
                <div class="col-12 col-sm-12 mt-40 text-center" style="margin-left: 14rem">
                    <?php if($stripeSettings->paypal_client_id != null && $stripeSettings->paypal_secret != null && $stripeSettings->paypal_status == 'active'): ?>
                        <button type="submit" class="btn btn-warning waves-effect waves-light paypalPayment pull-left" data-toggle="tooltip" data-placement="top" title="Choose Plan">
                            <i class="icon-anchor display-small"></i><span>
                                    <i class="fa fa-paypal"></i> <?php echo app('translator')->getFromJson('modules.invoices.payPaypal'); ?></span>
                        </button>
                    <?php endif; ?>
                    <?php if($stripeSettings->api_key != null && $stripeSettings->api_secret != null  && $stripeSettings->stripe_status == 'active'): ?>
                        <div class="pull-left m-l-10">
                            <form action="<?php echo e(route('admin.payments.stripe')); ?>" method="POST">
                            <input type="hidden" name="plan_id" value="<?php echo e($package->id); ?>">
                            <input type="hidden" name="type" value="<?php echo e($type); ?>">
                            <?php echo e(csrf_field()); ?>

                            <script
                                    src="https://checkout.stripe.com/checkout.js"
                                    class="stripe-button d-flex flex-wrap justify-content-between align-items-center"
                                    data-email="<?php echo e($company->company_email); ?>"
                                    data-key="<?php echo e(config('services.stripe.key')); ?>"
                                    <?php if($type == 'annual'): ?>
                                        data-amount="<?php echo e(round($package->annual_price) * 100); ?>"
                                    <?php else: ?>
                                        data-amount="<?php echo e(round($package->monthly_price) * 100); ?>"
                                    <?php endif; ?>
                                    data-button-name="Choose Plan"
                                    data-description="Payment through debit card."
                                    data-image="<?php echo e($logo); ?>"
                                    data-locale="auto"
                                    data-currency="<?php echo e($superadmin->currency->currency_code); ?>">
                            </script>

                            <button type="submit" class="btn btn-success waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="Choose Plan">
                                <i class="icon-anchor display-small"></i><span>
                            <i class="fa fa-cc-stripe"></i> <?php echo app('translator')->getFromJson('modules.invoices.payStripe'); ?></span></button>
                        </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
    </div>
</div>
<script src="<?php echo e(asset('pricing/js/index.js')); ?>"></script>
<script>

    // redirect on paypal payment page
    $('body').on('click', '.paypalPayment', function(){
        $.easyBlockUI('#package-select-form', 'Redirecting Please Wait...');
        var url = "<?php echo e(route('admin.paypal', [$package->id, $type])); ?>";
        window.location.href = url;
    });
</script>

<?php /**PATH /var/www/html/resources/views/admin/billing/payment-method-show.blade.php ENDPATH**/ ?>