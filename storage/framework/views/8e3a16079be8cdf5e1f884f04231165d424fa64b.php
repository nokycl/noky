<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse slimscrollsidebar">

        <!-- .User Profile -->
        <ul class="nav" id="side-menu">
            <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                <!-- input-group -->
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search..."> <span class="input-group-btn">
                            <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
                            </span> </div>
                <!-- /input-group -->
            </li>
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
                    <li>
                        <a href="<?php echo e(route('member.dashboard')); ?>">
                            <i class="fa fa-sign-in"></i> <?php echo app('translator')->getFromJson('app.loginAsEmployee'); ?>
                        </a>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li><a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                        ><i class="fa fa-power-off"></i> <?php echo app('translator')->getFromJson('app.logout'); ?></a>
                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                            <?php echo e(csrf_field()); ?>

                        </form>
                    </li>
                </ul>
            </li>
            <li><a href="<?php echo e(route('admin.dashboard')); ?>" class="waves-effect"><i class="icon-speedometer"></i> <span class="hide-menu"><?php echo app('translator')->getFromJson('app.menu.dashboard'); ?> </span></a> </li>

            <?php if(in_array("clients", $modules)  && $company->status != 'license_expired'): ?>
                <li><a href="<?php echo e(route('admin.clients.index')); ?>" class="waves-effect"><i class="icon-people"></i> <span class="hide-menu"><?php echo app('translator')->getFromJson('app.menu.clients'); ?> </span></a> </li>
            <?php endif; ?>
            <?php if(in_array("leads", $modules)   && $company->status != 'license_expired'): ?>
                <li><a href="<?php echo e(route('admin.leads.index')); ?>" class="waves-effect"><i class="ti-receipt"></i> <span class="hide-menu"> <?php echo app('translator')->getFromJson('app.menu.lead'); ?></span></a>
                </li>
            <?php endif; ?>
            <?php if(in_array("projects", $modules)  && $company->status != 'license_expired'): ?>
                <li><a href="<?php echo e(route('admin.projects.index')); ?>" class="waves-effect"><i class="icon-layers"></i> <span class="hide-menu"><?php echo app('translator')->getFromJson('app.menu.projects'); ?> </span></a> </li>
            <?php endif; ?>

            <?php if(in_array("tasks", $modules)   && $company->status != 'license_expired'): ?>
                <li><a href="<?php echo e(route('admin.task.index')); ?>" class="waves-effect"><i class="ti-layout-list-thumb"></i> <span class="hide-menu"> <?php echo app('translator')->getFromJson('app.menu.tasks'); ?> <span class="fa arrow"></span> </span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="<?php echo e(route('admin.all-tasks.index')); ?>"><?php echo app('translator')->getFromJson('app.menu.tasks'); ?></a></li>
                        <li><a href="<?php echo e(route('admin.taskboard.index')); ?>"><?php echo app('translator')->getFromJson('modules.tasks.taskBoard'); ?></a></li>
                        <li><a href="<?php echo e(route('admin.task-calendar.index')); ?>"><?php echo app('translator')->getFromJson('app.menu.taskCalendar'); ?></a></li>
                    </ul>
                </li>
            <?php endif; ?>


            <?php if(in_array("products", $modules)  && $company->status != 'license_expired'): ?>
                <li><a href="<?php echo e(route('admin.products.index')); ?>" class="waves-effect"><i class="icon-basket"></i> <span class="hide-menu"><?php echo app('translator')->getFromJson('app.menu.products'); ?> </span></a> </li>
            <?php endif; ?>


            <?php if((in_array("estimates", $modules)  || in_array("invoices", $modules)  || in_array("payments", $modules) || in_array("expenses", $modules)  ) && $company->status != 'license_expired' ): ?>
                <li><a href="<?php echo e(route('admin.finance.index')); ?>" class="waves-effect"><i class="fa fa-money"></i> <span class="hide-menu"> <?php echo app('translator')->getFromJson('app.menu.finance'); ?> <?php if($unreadExpenseCount > 0): ?> <div class="notify notification-color"><span class="heartbit"></span><span class="point"></span></div><?php endif; ?> <span class="fa arrow"></span> </span></a>
                    <ul class="nav nav-second-level">
                        <?php if(in_array("estimates", $modules)  && $company->status != 'license_expired'): ?>
                            <li><a href="<?php echo e(route('admin.estimates.index')); ?>"><?php echo app('translator')->getFromJson('app.menu.estimates'); ?></a> </li>
                        <?php endif; ?>

                        <?php if(in_array("invoices", $modules)  && $company->status != 'license_expired'): ?>
                            <li><a href="<?php echo e(route('admin.all-invoices.index')); ?>"><?php echo app('translator')->getFromJson('app.menu.invoices'); ?></a> </li>
                        <?php endif; ?>

                        <?php if(in_array("payments", $modules)  && $company->status != 'license_expired'): ?>
                            <li><a href="<?php echo e(route('admin.payments.index')); ?>"><?php echo app('translator')->getFromJson('app.menu.payments'); ?></a> </li>
                        <?php endif; ?>

                        <?php if(in_array("expenses", $modules)  && $company->status != 'license_expired'): ?>
                            <li><a href="<?php echo e(route('admin.expenses.index')); ?>"><?php echo app('translator')->getFromJson('app.menu.expenses'); ?> <?php if($unreadExpenseCount > 0): ?> <div class="notify notification-color"><span class="heartbit"></span><span class="point"></span></div><?php endif; ?></a> </li>
                        <?php endif; ?>

                        <?php if(in_array("invoices", $modules)  && $company->status != 'license_expired'): ?>
                            <li><a href="<?php echo e(route('admin.all-credit-notes.index')); ?>"><?php echo app('translator')->getFromJson('app.menu.credit-note'); ?></a> </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if(in_array("timelogs", $modules)  && $company->status != 'license_expired'): ?>
                <li><a href="<?php echo e(route('admin.all-time-logs.index')); ?>" class="waves-effect"><i class="icon-clock"></i> <span class="hide-menu"><?php echo app('translator')->getFromJson('app.menu.timeLogs'); ?> </span></a> </li>
            <?php endif; ?>

            <?php if(in_array("tickets", $modules)  && $company->status != 'license_expired'): ?>
                <li><a href="<?php echo e(route('admin.tickets.index')); ?>" class="waves-effect"><i class="ti-ticket"></i> <span class="hide-menu"><?php echo app('translator')->getFromJson('app.menu.tickets'); ?></span> <?php if($unreadTicketCount > 0): ?> <div class="notify notification-color"><span class="heartbit"></span><span class="point"></span></div><?php endif; ?></a> </li>
            <?php endif; ?>


            <?php if(in_array("employees", $modules)  && $company->status != 'license_expired'): ?>
                <li><a href="<?php echo e(route('admin.employees.index')); ?>" class="waves-effect"><i class="ti-user"></i> <span class="hide-menu"> <?php echo app('translator')->getFromJson('app.menu.employees'); ?> <span class="fa arrow"></span> </span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="<?php echo e(route('admin.employees.index')); ?>"><?php echo app('translator')->getFromJson('app.menu.employeeList'); ?></a></li>
                        <li><a href="<?php echo e(route('admin.teams.index')); ?>"><?php echo app('translator')->getFromJson('app.menu.teams'); ?></a></li>
                    </ul>
                </li>
            <?php endif; ?>


            <?php if(in_array("attendance", $modules)  && $company->status != 'license_expired'): ?>
                <li><a href="<?php echo e(route('admin.attendances.index')); ?>" class="waves-effect"><i class="icon-clock"></i> <span class="hide-menu"><?php echo app('translator')->getFromJson('app.menu.attendance'); ?> </span></a> </li>
            <?php endif; ?>
            <?php if(in_array("holidays", $modules)  && $company->status != 'license_expired'): ?>
                <li><a href="<?php echo e(route('admin.holidays.index')); ?>" class="waves-effect"><i class="ti-calendar"></i> <span class="hide-menu"> <?php echo app('translator')->getFromJson('app.menu.holiday'); ?></span></a>
                </li>
            <?php endif; ?>


            <?php if(in_array("messages", $modules)   && $company->status != 'license_expired'): ?>
                <li><a href="<?php echo e(route('admin.user-chat.index')); ?>" class="waves-effect"><i class="icon-envelope"></i> <span class="hide-menu"><?php echo app('translator')->getFromJson('app.menu.messages'); ?> <?php if($unreadMessageCount > 0): ?><span class="label label-rouded label-custom pull-right"><?php echo e($unreadMessageCount); ?></span> <?php endif; ?></span></a> </li>
            <?php endif; ?>

            <?php if(in_array("events", $modules)  && $company->status != 'license_expired'): ?>
                <li><a href="<?php echo e(route('admin.events.index')); ?>" class="waves-effect"><i class="icon-calender"></i> <span class="hide-menu"><?php echo app('translator')->getFromJson('app.menu.Events'); ?></span></a> </li>
            <?php endif; ?>

            <?php if(in_array("leaves", $modules)  && $company->status != 'license_expired'): ?>
                <li><a href="<?php echo e(route('admin.leaves.index')); ?>" class="waves-effect"><i class="icon-logout"></i> <span class="hide-menu"><?php echo app('translator')->getFromJson('app.menu.leaves'); ?></span></a> </li>
            <?php endif; ?>

            <?php if(in_array("notices", $modules)  && $company->status != 'license_expired'): ?>
                <li><a href="<?php echo e(route('admin.notices.index')); ?>" class="waves-effect"><i class="ti-layout-media-overlay"></i> <span class="hide-menu"><?php echo app('translator')->getFromJson('app.menu.noticeBoard'); ?> </span></a> </li>
            <?php endif; ?>
            <?php if($company->status != 'license_expired'): ?>
            <li><a href="<?php echo e(route('admin.reports.index')); ?>" class="waves-effect"><i class="ti-pie-chart"></i> <span class="hide-menu"> <?php echo app('translator')->getFromJson('app.menu.reports'); ?> <span class="fa arrow"></span> </span></a>
                <ul class="nav nav-second-level">
                    <li><a href="<?php echo e(route('admin.task-report.index')); ?>"><?php echo app('translator')->getFromJson('app.menu.taskReport'); ?></a></li>
                    <li><a href="<?php echo e(route('admin.time-log-report.index')); ?>"><?php echo app('translator')->getFromJson('app.menu.timeLogReport'); ?></a></li>
                    <li><a href="<?php echo e(route('admin.finance-report.index')); ?>"><?php echo app('translator')->getFromJson('app.menu.financeReport'); ?></a></li>
                    <li><a href="<?php echo e(route('admin.income-expense-report.index')); ?>"><?php echo app('translator')->getFromJson('app.menu.incomeVsExpenseReport'); ?></a></li>
                    <li><a href="<?php echo e(route('admin.leave-report.index')); ?>"><?php echo app('translator')->getFromJson('app.menu.leaveReport'); ?></a></li>
                </ul>
            </li>
            <?php endif; ?>
            <?php if (\Entrust::hasRole('admin')) : ?>
            <li><a href="<?php echo e(route('admin.billing')); ?>" class="waves-effect"><i class="icon-book-open"></i> <span class="hide-menu"> <?php echo app('translator')->getFromJson('app.menu.billing'); ?></span></a>
            </li>
            <?php endif; // Entrust::hasRole ?>
            <?php if($company->status != 'license_expired'): ?>
                <li><a href="<?php echo e(route('admin.settings.index')); ?>" class="waves-effect"><i class="ti-settings"></i> <span class="hide-menu"> <?php echo app('translator')->getFromJson('app.menu.settings'); ?></span></a>
                </li>
            <?php endif; ?>


        </ul>
    </div>
</div><?php /**PATH /var/www/html/resources/views/sections/left_sidebar.blade.php ENDPATH**/ ?>