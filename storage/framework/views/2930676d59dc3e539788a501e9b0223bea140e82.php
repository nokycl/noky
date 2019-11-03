<?php $__env->startSection('content'); ?>

    <form class="form-horizontal form-material" id="loginform" action="<?php echo e(route('login')); ?>" method="POST">
        <?php echo e(csrf_field()); ?>



        <?php if(session('message')): ?>
            <div class="alert alert-danger m-t-10">
                <?php echo e(session('message')); ?>

            </div>
        <?php endif; ?>

        <div class="form-group <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
            <div class="col-xs-12">
                <input class="form-control" id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" autofocus required="" placeholder="<?php echo app('translator')->getFromJson('app.email'); ?>">
                <?php if($errors->has('email')): ?>
                    <div class="help-block with-errors"><?php echo e($errors->first('email')); ?></div>
                <?php endif; ?>

            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <input class="form-control" id="password" type="password" name="password" required="" placeholder="<?php echo app('translator')->getFromJson('modules.client.password'); ?>">
                <?php if($errors->has('password')): ?>
                    <div class="help-block with-errors"><?php echo e($errors->first('password')); ?></div>
                <?php endif; ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <div class="checkbox checkbox-primary pull-left p-t-0">
                    <input id="checkbox-signup" type="checkbox" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                    <label for="checkbox-signup"> <?php echo app('translator')->getFromJson('app.rememberMe'); ?> </label>
                </div>
                <a href="<?php echo e(route('password.request')); ?>"  class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> <?php echo app('translator')->getFromJson('app.forgotPassword'); ?>?</a> </div>
        </div>
        <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
                <button class="btn btn-info btn-lg btn-block btn-rounded text-uppercase waves-effect waves-light" type="submit"><?php echo app('translator')->getFromJson('app.login'); ?></button>
            </div>
        </div>

        
            
                
            
        
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/auth/login.blade.php ENDPATH**/ ?>