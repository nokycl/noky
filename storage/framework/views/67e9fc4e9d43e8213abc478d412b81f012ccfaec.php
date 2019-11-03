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
                <li><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo app('translator')->getFromJson('app.menu.home'); ?></a></li>
                <li class="active"><?php echo e(__($pageTitle)); ?></li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('head-script'); ?>
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/calendar/dist/fullcalendar.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/morrisjs/morris.css')); ?>"><!--Owl carousel CSS -->
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/owl.carousel/owl.carousel.min.css')); ?>"><!--Owl carousel CSS -->
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/owl.carousel/owl.theme.default.css')); ?>"><!--Owl carousel CSS -->

<style>
    .col-in {
        padding: 0 20px !important;

    }

    .fc-event{
        font-size: 10px !important;
    }

    @media (min-width: 769px) {
        #wrapper .panel-wrapper{
            height: 500px;
            overflow-y: auto;
        }
    }

</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(!is_null($global->licence_expire_on) && $global->status == 'license_expired'): ?>
        <a href="<?php echo e(route('admin.billing')); ?>">
            <div class="alert alert-danger col-md-12">
                <h5 class="text-white"><?php echo app('translator')->getFromJson('messages.licenseExpiredNote'); ?></h5>
            </div>
        </a>
    <?php endif; ?>
    <?php if($company->package->default == 'yes' || $company->package->default == 'trial'): ?>
        <a href="<?php echo e(route('admin.billing')); ?>">
            <div class="alert alert-danger col-md-12">
                <h5 class="text-white"><?php echo app('translator')->getFromJson('messages.purchasePackageMessage'); ?></h5>
            </div>
        </a>
    <?php endif; ?>
    <div class="row dashboard-stats">


        <?php if(in_array('clients',$modules)): ?>
        <div class="col-md-3 col-sm-6">
            <a href="<?php echo e(route('admin.clients.index')); ?>">
                <div class="white-box">
                <div class="row">
                    <div class="col-sm-3">
                        <div>
                            <span class="bg-success-gradient"><i class="icon-user"></i></span>
                        </div>
                    </div>
                    <div class="col-sm-9 text-right">
                        <span class="widget-title"> <?php echo app('translator')->getFromJson('modules.dashboard.totalClients'); ?></span><br>
                        <span class="counter"><?php echo e($counts->totalClients); ?></span>
                    </div>
                </div>
                </div>
            </a>
        </div>
        <?php endif; ?>

        <?php if(in_array('employees',$modules)): ?>
        <div class="col-md-3 col-sm-6">
            <a href="<?php echo e(route('admin.employees.index')); ?>">
                <div class="white-box">
                    <div class="row">
                        <div class="col-sm-3">
                            <div>
                                <span class="bg-warning-gradient"><i class="icon-people"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-9 text-right">
                            <span class="widget-title"> <?php echo app('translator')->getFromJson('modules.dashboard.totalEmployees'); ?></span><br>
                            <span class="counter"><?php echo e($counts->totalEmployees); ?></span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php endif; ?>

        <?php if(in_array('projects',$modules)): ?>
        <div class="col-md-3 col-sm-6">
            <a href="<?php echo e(route('admin.projects.index')); ?>">
                <div class="white-box">
                    <div class="row">
                        <div class="col-sm-3">
                            <div>
                                <span class="bg-danger-gradient"><i class="icon-layers"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-9 text-right">
                            <span class="widget-title"> <?php echo app('translator')->getFromJson('modules.dashboard.totalProjects'); ?></span><br>
                            <span class="counter"><?php echo e($counts->totalProjects); ?></span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php endif; ?>

        <?php if(in_array('invoices',$modules)): ?>
        <div class="col-md-3 col-sm-6">
            <a href="<?php echo e(route('admin.all-invoices.index')); ?>">
                <div class="white-box">
                    <div class="row">
                        <div class="col-sm-3">
                            <div>
                                <span class="bg-inverse-gradient"><i class="ti-receipt"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-9 text-right">
                            <span class="widget-title"> <?php echo app('translator')->getFromJson('modules.dashboard.totalUnpaidInvoices'); ?></span><br>
                            <span class="counter"><?php echo e($counts->totalUnpaidInvoices); ?></span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php endif; ?>

        <?php if(in_array('timelogs',$modules)): ?>
            <div class="col-md-3 col-sm-6">
                <a href="<?php echo e(route('admin.all-time-logs.index')); ?>">
                <div class="white-box">
                    <div class="row">
                        <div class="col-sm-3">
                            <div>
                                <span class="bg-info-gradient"><i class="icon-clock"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-9 text-right">
                            <span class="widget-title"> <?php echo app('translator')->getFromJson('modules.dashboard.totalHoursLogged'); ?></span><br>
                            <span style="font-size: 20px;"><?php echo e($counts->totalHoursLogged); ?></span>
                        </div>
                    </div>
                </div>
                </a>
            </div>
        <?php endif; ?>

        <?php if(in_array('tasks',$modules)): ?>
            <div class="col-md-3 col-sm-6">
                <a href="<?php echo e(route('admin.all-tasks.index')); ?>">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-sm-3">
                                <div>
                                    <span class="bg-warning-gradient"><i class="ti-alert"></i></span>
                                </div>
                            </div>
                            <div class="col-sm-9 text-right">
                                <span class="widget-title"> <?php echo app('translator')->getFromJson('modules.dashboard.totalPendingTasks'); ?></span><br>
                                <span class="counter"><?php echo e($counts->totalPendingTasks); ?></span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endif; ?>

        <?php if(in_array('tasks',$modules)): ?>
            <div class="col-md-3 col-sm-6">
                <a href="<?php echo e(route('admin.all-tasks.index')); ?>">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-sm-3">
                                <div>
                                    <span class="bg-success-gradient"><i class="ti-check-box"></i></span>
                                </div>
                            </div>
                            <div class="col-sm-9 text-right">
                                <span class="widget-title"> <?php echo app('translator')->getFromJson('modules.dashboard.totalCompletedTasks'); ?></span><br>
                                <span class="counter"><?php echo e($counts->totalCompletedTasks); ?></span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endif; ?>

        <?php if(in_array('attendance',$modules)): ?>
            <div class="col-md-3 col-sm-6">
                <a href="<?php echo e(route('admin.attendances.index')); ?>">
                <div class="white-box">
                    <div class="row">
                        <div class="col-sm-3">
                            <div>
                                <span class="bg-danger-gradient"><i class="fa fa-percent" style="display: inherit;"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-9 text-right">
                            <span class="widget-title"> <?php echo app('translator')->getFromJson('modules.dashboard.totalTodayAttendance'); ?></span><br>
                            <span class="counter"><?php if($counts->totalEmployees > 0): ?><?php echo e(round((($counts->totalTodayAttendance/$counts->totalEmployees)*100), 2)); ?><?php else: ?> 0 <?php endif; ?></span>%
                            <span class="text-muted">(<?php echo e($counts->totalTodayAttendance.'/'.$counts->totalEmployees); ?>)</span>
                        </div>
                    </div>
                </div>
                </a>
            </div>
        <?php endif; ?>
    </div>
    <!-- .row -->

    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <?php if(in_array('tickets',$modules)): ?>
                    <div class="col-md-6 col-sm-12 dashboard-stats">
                        <a href="<?php echo e(route('admin.tickets.index')); ?>">
                        <div class="white-box">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div>
                                        <span class="bg-success-gradient"><i class="ti-ticket"></i></span>
                                    </div>
                                </div>
                                <div class="col-sm-9 text-right">
                                    <span class="widget-title"> <?php echo app('translator')->getFromJson('modules.tickets.totalResolvedTickets'); ?></span><br>
                                    <span class="counter"><?php echo e(floor($counts->totalResolvedTickets)); ?></span>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                <?php endif; ?>

                <?php if(in_array('tickets',$modules)): ?>
                    <div class="col-md-6 col-sm-12 dashboard-stats">
                        <a href="<?php echo e(route('admin.tickets.index')); ?>">
                            <div class="white-box">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div>
                                            <span class="bg-danger-gradient"><i class="ti-ticket"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-9 text-right">
                                        <span class="widget-title"> <?php echo app('translator')->getFromJson('modules.tickets.totalUnresolvedTickets'); ?></span><br>
                                        <span class="counter"><?php echo e(floor($counts->totalUnResolvedTickets)); ?></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>

                

                <div class="col-md-12 col-xs-12">
                    <div class="bg-theme-dark m-b-15">
                        <div id="myCarouse2" class="carousel vcarousel slide p-20">
                            <h4 class="text-white p-t-0 p-b-0"><?php echo app('translator')->getFromJson('modules.projects.clientFeedback'); ?></h4>
                            <!-- Carousel items -->
                            <div class="carousel-inner ">
                                <?php $__empty_1 = true; $__currentLoopData = $feedbacks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$feedback): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="<?php if($key == 0): ?> active <?php endif; ?> item">
                                        <h5 class="text-white"><?php echo substr($feedback->feedback,0,70).'...'; ?></h5>
                                        <?php if(!is_null($feedback->client)): ?>
                                        <div class="twi-user">
                                            <?php echo ($feedback->client->image) ? '<img src="'.asset('user-uploads/avatar/'.$feedback->client->image).'"
                                                                        alt="user" class="img-circle img-responsive pull-left">' : '<img src="'.asset('default-profile-2.png').'"
                                                                        alt="user" class="img-circle img-responsive pull-left">'; ?>

                                            <h5 class="text-white m-b-0"><?php echo e(ucwords($feedback->client->name)); ?></h5>
                                            <p class="text-white"><?php echo e(ucwords($feedback->project_name)); ?></p>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="active item">
                                        <h3 class="text-white"><?php echo app('translator')->getFromJson('messages.noFeedbackReceived'); ?></h3>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <?php if(in_array('payments',$modules)): ?>
        <div class="col-md-6">
            <div class="row">
                <div class="col-xs-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-0"><?php echo app('translator')->getFromJson('modules.dashboard.recentEarnings'); ?></h3>

                        <div id="morris-area-chart" style="height: 190px;"></div>
                        <h6 style="line-height: 2em;"><span class=" label label-danger"><?php echo app('translator')->getFromJson('app.note'); ?>:</span> <?php echo app('translator')->getFromJson('messages.earningChartNote'); ?> <a href="<?php echo e(route('admin.settings.index')); ?>"><i class="fa fa-arrow-right"></i></a></h6>
                    </div>
                </div>

            </div>

        </div>
        <?php endif; ?>
    </div>
    <!-- .row -->

    <div class="row">
        <?php if(in_array('leaves',$modules)): ?>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo app('translator')->getFromJson('app.menu.leaves'); ?></div>
                <div class="panel-wrapper collapse in" style="overflow: hidden">
                    <div class="panel-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if(in_array('tickets',$modules)): ?>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo app('translator')->getFromJson('modules.dashboard.newTickets'); ?></div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <ul class="list-task list-group" data-role="tasklist">
                            <?php $__empty_1 = true; $__currentLoopData = $newTickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$newTicket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <li class="list-group-item" data-role="task">
                                    <?php echo e(($key+1)); ?>. <a href="<?php echo e(route('admin.tickets.edit', $newTicket->id)); ?>" class="text-danger"> <?php echo e(ucfirst($newTicket->subject)); ?></a> <i><?php echo e(ucwords($newTicket->created_at->diffForHumans())); ?></i>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <li class="list-group-item" data-role="task">
                                    <?php echo app('translator')->getFromJson("messages.noTicketFound"); ?>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>

    <div class="row" >
        <?php if(in_array('tasks',$modules)): ?>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><?php echo app('translator')->getFromJson('modules.dashboard.overdueTasks'); ?></div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <ul class="list-task list-group" data-role="tasklist">
                                <li class="list-group-item" data-role="task">
                                    <strong><?php echo app('translator')->getFromJson('app.title'); ?></strong> <span
                                            class="pull-right"><strong><?php echo app('translator')->getFromJson('modules.dashboard.dueDate'); ?></strong></span>
                                </li>
                                <?php $__empty_1 = true; $__currentLoopData = $pendingTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li class="list-group-item row" data-role="task">
                                        <div class="col-xs-9">
                                            <?php echo e(($key+1).'. '.ucfirst($task->heading)); ?>

                                            <?php if(!is_null($task->project_id) && !is_null($task->project)): ?>
                                                <a href="<?php echo e(route('admin.projects.show', $task->project_id)); ?>" class="text-danger"><?php echo e(ucwords($task->project->project_name)); ?></a>
                                            <?php endif; ?>
                                        </div>
                                        <label class="label label-danger pull-right col-xs-3"><?php echo e($task->due_date->format($global->date_format)); ?></label>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <li class="list-group-item" data-role="task">
                                        <?php echo app('translator')->getFromJson("messages.noOpenTasks"); ?>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if(in_array('leads',$modules)): ?>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><?php echo app('translator')->getFromJson('modules.dashboard.pendingFollowUp'); ?></div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <ul class="list-task list-group" data-role="tasklist">
                                <li class="list-group-item" data-role="task">
                                    <strong><?php echo app('translator')->getFromJson('app.title'); ?></strong> <span
                                            class="pull-right"><strong><?php echo app('translator')->getFromJson('modules.dashboard.followUpDate'); ?></strong></span>
                                </li>
                                <?php $__empty_1 = true; $__currentLoopData = $pendingLeadFollowUps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$follows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li class="list-group-item row" data-role="task">
                                        <div class="col-xs-9">
                                            <?php echo e(($key+1)); ?>


                                            <a href="<?php echo e(route('admin.leads.show', $follows->lead_id)); ?>" class="text-danger"><?php echo e(ucwords($follows->lead->company_name)); ?></a>

                                        </div>
                                        <label class="label label-danger pull-right col-xs-3"><?php echo e($follows->next_follow_up_date->format($global->date_format)); ?></label>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <li class="list-group-item" data-role="task">
                                        <?php echo app('translator')->getFromJson("messages.noPendingLeadFollowUps"); ?>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>


        <?php if(in_array('projects',$modules)): ?>
        <div class="col-md-6" id="project-timeline">
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo app('translator')->getFromJson('modules.dashboard.projectActivityTimeline'); ?></div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="steamline">
                            <?php $__currentLoopData = $projectActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activ): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="sl-item">
                                    <div class="sl-left"><i class="fa fa-circle text-info"></i>
                                    </div>
                                    <div class="sl-right">
                                        <div><h6><a href="<?php echo e(route('admin.projects.show', $activ->project_id)); ?>" class="text-danger"><?php echo e(ucwords($activ->project->project_name)); ?>:</a> <?php echo e($activ->activity); ?></h6> <span class="sl-date"><?php echo e($activ->created_at->diffForHumans()); ?></span></div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if(in_array('employees',$modules)): ?>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo app('translator')->getFromJson('modules.dashboard.userActivityTimeline'); ?></div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="steamline">
                            <?php $__empty_1 = true; $__currentLoopData = $userActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="sl-item">
                                    <div class="sl-left">
                                        <?php echo ($activity->user->image) ? '<img src="'.asset('user-uploads/avatar/'.$activity->user->image).'"
                                                                    alt="user" class="img-circle">' : '<img src="'.asset('default-profile-2.png').'"
                                                                    alt="user" class="img-circle">'; ?>

                                    </div>
                                    <div class="sl-right">
                                        <div class="m-l-40"><a href="<?php echo e(route('admin.employees.show', $activity->user_id)); ?>" class="text-success"><?php echo e(ucwords($activity->user->name)); ?></a> <span  class="sl-date"><?php echo e($activity->created_at->diffForHumans()); ?></span>
                                            <p><?php echo ucfirst($activity->activity); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php if(count($userActivities) > ($key+1)): ?>
                                    <hr>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div><?php echo app('translator')->getFromJson("messages.noActivityByThisUser"); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>

    
    <div class="modal fade bs-modal-md in" id="eventDetailModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
                </div>
                <div class="modal-body">
                    Loading...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn blue">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    

<?php $__env->stopSection(); ?>


<?php $__env->startPush('footer-script'); ?>
<script>
    var taskEvents = [
            <?php $__currentLoopData = $leaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            {
            id: '<?php echo e(ucfirst($leave->id)); ?>',
            title: '<?php echo e(ucfirst($leave->user->name)); ?>',
            start: '<?php echo e($leave->leave_date); ?>',
            end:  '<?php echo e($leave->leave_date); ?>',
            className: 'bg-<?php echo e($leave->type->color); ?>'
        },
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
];

    var getEventDetail = function (id) {
        var url = '<?php echo e(route('admin.leaves.show', ':id')); ?>';
        url = url.replace(':id', id);

        $('#modelHeading').html('Event');
        $.ajaxModal('#eventDetailModal', url);
    }

    var calendarLocale = '<?php echo e($global->locale); ?>';

    $('.leave-action').click(function () {
        var action = $(this).data('leave-action');
        var leaveId = $(this).data('leave-id');
        var url = '<?php echo e(route("admin.leaves.leaveAction")); ?>';

        $.easyAjax({
            type: 'POST',
            url: url,
            data: { 'action': action, 'leaveId': leaveId, '_token': '<?php echo e(csrf_token()); ?>' },
            success: function (response) {
                if(response.status == 'success'){
                    window.location.reload();
                }
            }
        });
    })
</script>


<script src="<?php echo e(asset('plugins/bower_components/raphael/raphael-min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/morrisjs/morris.js')); ?>"></script>

<script src="<?php echo e(asset('plugins/bower_components/waypoints/lib/jquery.waypoints.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/counterup/jquery.counterup.min.js')); ?>"></script>

<!-- jQuery for carousel -->
<script src="<?php echo e(asset('plugins/bower_components/owl.carousel/owl.carousel.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/owl.carousel/owl.custom.js')); ?>"></script>

<!--weather icon -->
<script src="<?php echo e(asset('plugins/bower_components/skycons/skycons.js')); ?>"></script>

<script src="<?php echo e(asset('plugins/bower_components/calendar/jquery-ui.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/moment/moment.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/calendar/dist/fullcalendar.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/calendar/dist/jquery.fullcalendar.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/calendar/dist/locale-all.js')); ?>"></script>
<script src="<?php echo e(asset('js/event-calendar.js')); ?>"></script>

<script>
    $(document).ready(function () {
        var chartData = <?php echo $chartData; ?>;
        function barChart() {

            Morris.Line({
                element: 'morris-area-chart',
                data: chartData,
                xkey: 'date',
                ykeys: ['total'],
                labels: ['Earning'],
                pointSize: 3,
                fillOpacity: 0,
                pointStrokeColors:['#e20b0b'],
                behaveLikeLine: true,
                gridLineColor: '#e0e0e0',
                lineWidth: 2,
                hideHover: 'auto',
                lineColors: ['#e20b0b'],
                resize: true

            });

        }

        <?php if(in_array('payments',$modules)): ?>
        barChart();
        <?php endif; ?>

        $(".counter").counterUp({
            delay: 100,
            time: 1200
        });

        $('.vcarousel').carousel({
            interval: 3000
        })


        var icons = new Skycons({"color": "#ffffff"}),
                list  = [
                    "clear-day", "clear-night", "partly-cloudy-day",
                    "partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind",
                    "fog"
                ],
                i;
        for(i = list.length; i--; ) {
            var weatherType = list[i],
                    elements = document.getElementsByClassName( weatherType );
            for (e = elements.length; e--;){
                icons.set( elements[e], weatherType );
            }
        }
        icons.play();
    })

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/dashboard/index.blade.php ENDPATH**/ ?>