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
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/timepicker/bootstrap-timepicker.min.css')); ?>">

<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/custom-select/custom-select.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/multiselect/css/multi-select.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bootstrap-colorselector/bootstrap-colorselector.min.css')); ?>">

<style>
    .fc-event{
        font-size: 10px !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">

        <div class="col-md-3">
            <div class="white-box p-t-10 p-b-10 bg-warning">
                <h3 class="box-title text-white"><?php echo app('translator')->getFromJson('modules.leaves.pendingLeaves'); ?></h3>
                <ul class="list-inline two-part">
                    <li><i class="icon-logout text-white"></i></li>
                    <li class="text-right"><span id="pendingLeaves" class="counter text-white"><?php echo e(count($pendingLeaves)); ?></span></li>
                </ul>
            </div>
        </div>
        <div class="col-md-12 m-b-10">
            <a href="<?php echo e(route('admin.leave.all-leaves')); ?>" class="btn btn-sm btn-success waves-effect waves-light pull-left">
                <i class="fa fa-table"></i> <?php echo app('translator')->getFromJson('app.tableView'); ?>
            </a>
        </div>

    </div>

    <div class="row">
        <div class="col-md-7">
            <div class="white-box">
                <div class="row">
                    <h3 class="box-title col-md-3"><?php echo app('translator')->getFromJson('app.menu.leaves'); ?></h3>

                    <div class="col-md-9">
                        <a href="<?php echo e(route('admin.leaves.create')); ?>" class="btn btn-sm btn-success waves-effect waves-light  pull-right">
                            <i class="ti-plus"></i> <?php echo app('translator')->getFromJson('modules.leaves.assignLeave'); ?>
                        </a>

                    </div>

                </div>


                <div id="calendar"></div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo app('translator')->getFromJson('modules.leaves.pendingLeaves'); ?></div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <ul class="list-task list-group" data-role="tasklist">
                            <?php $__empty_1 = true; $__currentLoopData = $pendingLeaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$pendingLeave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <li class="list-group-item" data-role="task">
                                    <?php echo e(($key+1)); ?>. <strong><?php echo e(ucwords($pendingLeave->user->name)); ?></strong> for <?php echo e($pendingLeave->leave_date->format($global->date_format)); ?> (<?php echo e($pendingLeave->leave_date->format('l')); ?>)
                                    <br>
                                    <strong><?php echo app('translator')->getFromJson('app.reason'); ?>: </strong><?php echo e($pendingLeave->reason); ?>

                                    <br>
                                    <div class="m-t-10"></div>
                                    <a href="javascript:;" data-leave-id="<?php echo e($pendingLeave->id); ?>" data-leave-action="approved" class="btn btn-xs btn-success btn-rounded m-r-5 leave-action"><i class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.accept'); ?></a>

                                    <a href="javascript:;" data-leave-id="<?php echo e($pendingLeave->id); ?>" data-leave-action="rejected" class="btn btn-xs btn-danger btn-rounded leave-action-reject"><i class="fa fa-times"></i> <?php echo app('translator')->getFromJson('app.reject'); ?></a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php echo app('translator')->getFromJson('messages.noPendingLeaves'); ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- .row -->

    
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

    $('.leave-action-reject').click(function () {
        var action = $(this).data('leave-action');
        var leaveId = $(this).data('leave-id');
        var searchQuery = "?leave_action="+action+"&leave_id="+leaveId;
        var url = '<?php echo route('admin.leaves.show-reject-modal'); ?>'+searchQuery;
        $('#modelHeading').html('Reject Reason');
        $.ajaxModal('#eventDetailModal', url);
    });

    $('.leave-action').on('click', function() {
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

<script src="<?php echo e(asset('plugins/bower_components/calendar/jquery-ui.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/moment/moment.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/calendar/dist/fullcalendar.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/calendar/dist/jquery.fullcalendar.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/calendar/dist/locale-all.js')); ?>"></script>
<script src="<?php echo e(asset('js/event-calendar.js')); ?>"></script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/leaves/index.blade.php ENDPATH**/ ?>