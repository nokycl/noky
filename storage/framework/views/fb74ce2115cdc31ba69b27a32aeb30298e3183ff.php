<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse slimscrollsidebar">
        <!-- .User Profile -->
        <ul class="nav" id="side-menu">

            <li class="user-pro">
                <?php if(is_null($user->image)): ?>
                    <a href="#" class="waves-effect"><img src="<?php echo e(asset('default-profile-3.png')); ?>" alt="user-img" class="img-circle"> <span class="hide-menu"><?php echo e((strlen($user->name) > 24) ? substr(ucwords($user->name), 0, 20).'..' : ucwords($user->name)); ?>

                            <span class="fa arrow"></span></span>
                    </a>
                <?php else: ?>
                    <a href="#" class="waves-effect"><img src="<?php echo e(asset('user-uploads/avatar/'.$user->image)); ?>" alt="user-img" class="img-circle"> <span class="hide-menu"><?php echo e(ucwords($user->name)); ?>

                            <span class="fa arrow"></span></span>
                    </a>
                <?php endif; ?>

                <ul class="nav nav-second-level">
                    
                    <li><a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                        ><i class="fa fa-power-off"></i> <?php echo app('translator')->getFromJson('app.logout'); ?></a>
                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                            <?php echo e(csrf_field()); ?>

                        </form>
                    </li>
                </ul>
            </li>

           <li><a href="<?php echo e(route('super-admin.dashboard')); ?>" class="waves-effect"><i class="icon-speedometer"></i> <span class="hide-menu"><?php echo app('translator')->getFromJson('app.menu.dashboard'); ?> </span></a> </li>

            <li><a href="<?php echo e(route('super-admin.profile.index')); ?>" class="waves-effect"><i class="icon-user"></i> <span class="hide-menu"><?php echo app('translator')->getFromJson('modules.employees.profile'); ?> </span></a> </li>
            <li><a href="<?php echo e(route('super-admin.packages.index')); ?>" class="waves-effect"><i class="icon-calculator"></i> <span class="hide-menu"><?php echo app('translator')->getFromJson('app.menu.packages'); ?> </span></a> </li>

            <li><a href="<?php echo e(route('super-admin.companies.index')); ?>" class="waves-effect"><i class="icon-layers"></i> <span class="hide-menu"><?php echo app('translator')->getFromJson('app.menu.companies'); ?> </span></a> </li>
            <li><a href="<?php echo e(route('super-admin.invoices.index')); ?>" class="waves-effect"><i class="icon-printer"></i> <span class="hide-menu"><?php echo app('translator')->getFromJson('app.menu.invoices'); ?> </span></a> </li>
            <li><a href="<?php echo e(route('super-admin.super-admin.index')); ?>" class="waves-effect"><i class="fa fa-user-secret"></i> <span class="hide-menu"><?php echo app('translator')->getFromJson('app.superAdmin'); ?> </span></a> </li>
            <li><a href="<?php echo e(route('super-admin.settings.index')); ?>" class="waves-effect"><i class="icon-settings"></i> <span class="hide-menu"><?php echo app('translator')->getFromJson('app.menu.settings'); ?> </span></a> </li>
        </ul>
    </div>
</div>
<?php /**PATH /var/www/html/resources/views/sections/super_admin_left_sidebar.blade.php ENDPATH**/ ?>