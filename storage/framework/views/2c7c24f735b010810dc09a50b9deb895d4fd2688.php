<nav class="topbar topbar-expand-sm topbar-sticky">
    <div class="container-wide">
        <div class="row h-full">
            <div class="offset-1 col-10 col-md-4 offset-md-1 align-self-center">
                <button class="topbar-toggler">&#9776;</button>
                <a class="topbar-brand" href="<?php echo e(route('front.home')); ?>">
                    <?php if(is_null($setting->logo)): ?>
                        <img src="<?php echo e(asset('front/img/worksuite-logo.png')); ?>" alt="home" class="logo-default" />
                    <?php else: ?>
                        <img src="<?php echo e(asset('user-uploads/app-logo/'.$setting->logo)); ?>" class="logo-default" alt="home" />
                    <?php endif; ?>
                </a>
            </div>

            <div class="col-1 col-md-5 text-md-right">
                <?php $routeName = request()->route()->getName(); ?>
                <ul class="topbar-nav nav">
                    <li class="nav-item"><a class="nav-link" <?php if($routeName != 'front.home'): ?> href="<?php echo e(route('front.home').'#home'); ?>" <?php else: ?> href="javascript:;" data-scrollto="home" <?php endif; ?> ><?php echo app('translator')->getFromJson('app.menu.home'); ?> </a></li>
                    <li class="nav-item"><a class="nav-link" <?php if($routeName != 'front.home'): ?> href="<?php echo e(route('front.home').'#section-features'); ?>" <?php else: ?> href="javascript:;" data-scrollto="section-features" <?php endif; ?>><?php echo app('translator')->getFromJson('app.menu.features'); ?></a></li>
                    <li class="nav-item"><a class="nav-link" <?php if($routeName != 'front.home'): ?> href="<?php echo e(route('front.home').'#section-pricing'); ?>" <?php else: ?> href="javascript:;" data-scrollto="section-pricing" <?php endif; ?>><?php echo app('translator')->getFromJson('app.menu.pricing'); ?></a></li>
                    <li class="nav-item"><a class="nav-link" <?php if($routeName != 'front.home'): ?> href="<?php echo e(route('front.home').'#section-contact'); ?>" <?php else: ?> href="javascript:;" data-scrollto="section-contact" <?php endif; ?>><?php echo app('translator')->getFromJson('app.menu.contact'); ?></a></li>
                </ul>
            </div>
        </div>
    </div>
</nav><?php /**PATH /var/www/html/resources/views/sections/front_header.blade.php ENDPATH**/ ?>