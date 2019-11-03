<?php $__env->startSection('content'); ?>


    <form class="form-horizontal"  method="POST" action="<?php echo e(route('password.email')); ?>">
        <?php echo e(csrf_field()); ?>


        <?php if(session('status')): ?>
            <div class="alert alert-success m-t-10">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <h3 class="box-title m-t-40 m-b-0"><?php echo app('translator')->getFromJson('app.recoverPassword'); ?></h3>

        <div class="form-group ">
            <div class="col-xs-12">
                <p class="text-muted"><?php echo app('translator')->getFromJson('app.enterEmailInstruction'); ?> </p>
            </div>
        </div>
        <div class="form-group <?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
            <div class="col-xs-12">
                <input class="form-control" type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" required="" placeholder="<?php echo app('translator')->getFromJson('app.email'); ?>">
                <?php if($errors->has('email')): ?>
                    <span class="help-block">
                        <?php echo e($errors->first('email')); ?>

                    </span>
                <?php endif; ?>
            </div>
        </div>
        <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
                <button class="btn btn-primary btn-rounded btn-lg btn-block text-uppercase waves-effect waves-light" type="submit"><?php echo app('translator')->getFromJson('app.sendPasswordLink'); ?></button>
            </div>
        </div>

        <div class="form-group m-b-0">
            <div class="col-sm-12 text-center">
                <p><a href="<?php echo e(route('login')); ?>" class="text-primary m-l-5"><b><?php echo app('translator')->getFromJson('app.login'); ?></b></a></p>
            </div>
        </div>

    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/auth/passwords/email.blade.php ENDPATH**/ ?>