<?php $__env->startSection('content'); ?>
    <style>
        .has-danger .help-block {
            display: block;
            margin-top: 5px;
            margin-bottom: 10px;
            color: #ff4954;
        }
    </style>
    <section class="section bg-img" id="section-contact" style="background-image: url(<?php echo e(asset('front/img/bg-cup.jpg')); ?>)" data-overlay="8">
        <div class="container">
            <div class="row gap-y">
                <div class="col-12 col-md-6 offset-md-3 form-section">
                    <div class="col-12 col-md-10 bg-white px-30 py-45 rounded">
                        <div class="alert alert-<?php echo e($class); ?>">
                            <?php echo $messsage; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('footer-script'); ?>
    <script>
        $('#save-form').click(function () {
            $.easyAjax({
                url: '<?php echo e(route('front.signup.store')); ?>',
                container: '.form-section',
                type: "POST",
                data: $('#register').serialize(),
                messagePosition: "inline",
                success: function (response) {
                    if(response.status == 'success'){
                        $('#form-box').remove();
                    }
                }
            })
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.front-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/front/email-verification.blade.php ENDPATH**/ ?>