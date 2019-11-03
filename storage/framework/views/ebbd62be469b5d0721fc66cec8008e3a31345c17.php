<?php $__env->startSection('page-title'); ?>
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="<?php echo e($pageIcon); ?>"></i> <?php echo e(__($pageTitle)); ?> #<?php echo e($project->id); ?> - <span
                        class="font-bold"><?php echo e(ucwords($project->project_name)); ?></span></h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-6 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo app('translator')->getFromJson('app.menu.home'); ?></a></li>
                <li><a href="<?php echo e(route('admin.projects.index')); ?>"><?php echo e(__($pageTitle)); ?></a></li>
                <li class="active">Time Logs</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('head-script'); ?>
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/timepicker/bootstrap-timepicker.min.css')); ?>">

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-12">

            <section>
                <div class="sttabs tabs-style-line">
                    <div class="white-box">
                        <nav>
                            <ul>
                                <li>
                                    <a href="<?php echo e(route('admin.projects.show', $project->id)); ?>"><span><?php echo app('translator')->getFromJson('modules.projects.overview'); ?></span></a></li>
                                <?php if(in_array('employees',$modules)): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.project-members.show', $project->id)); ?>"><span><?php echo app('translator')->getFromJson('modules.projects.members'); ?></span></a>
                                </li>
                                <?php endif; ?>

                                <li><a href="<?php echo e(route('admin.milestones.show', $project->id)); ?>"><span><?php echo app('translator')->getFromJson('modules.projects.milestones'); ?></span></a></li>

                                <?php if(in_array('tasks',$modules)): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.tasks.show', $project->id)); ?>"><span><?php echo app('translator')->getFromJson('app.menu.tasks'); ?></span></a>
                                </li>
                                <?php endif; ?>

                                <li>
                                    <a href="<?php echo e(route('admin.files.show', $project->id)); ?>"><span><?php echo app('translator')->getFromJson('modules.projects.files'); ?></span></a>
                                </li>

                                <?php if(in_array('invoices',$modules)): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.invoices.show', $project->id)); ?>"><span><?php echo app('translator')->getFromJson('app.menu.invoices'); ?></span></a>
                                </li>
                                <?php endif; ?>

                                <?php if(in_array('timelogs',$modules)): ?>
                                <li class="tab-current"><a
                                            href="<?php echo e(route('admin.time-logs.show', $project->id)); ?>"><span><?php echo app('translator')->getFromJson('app.menu.timeLogs'); ?></span></a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                    <div class="content-wrap">
                        <section id="section-line-3" class="show">
                            <div class="row">
                                <div class="col-md-12" id="issues-list-panel">
                                    <div class="white-box">
                                        <h2><?php echo app('translator')->getFromJson('app.menu.timeLogs'); ?></h2>

                                        <div class="row m-b-10">
                                            <div class="col-md-12">
                                                <a href="javascript:;" id="show-add-form"
                                                   class="btn btn-success btn-outline"><i
                                                            class="fa fa-clock-o"></i> <?php echo app('translator')->getFromJson('modules.timeLogs.logTime'); ?>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php echo Form::open(['id'=>'logTime','class'=>'ajax-form hide','method'=>'POST']); ?>


                                                <?php if($logTimeFor->log_time_for == 'project'): ?> <?php echo Form::hidden('project_id', $project->id); ?> <?php endif; ?>

                                                <div class="form-body">
                                                    <div class="row m-t-30">
                                                        <div class="col-md-3 ">
                                                            <div class="form-group">
                                                                <?php if($logTimeFor->log_time_for == 'task'): ?>
                                                                    <label><?php echo app('translator')->getFromJson('modules.timeLogs.task'); ?></label>
                                                                    <select class="selectpicker form-control" name="task_id"
                                                                            id="task_id" data-style="form-control">
                                                                        <?php $__empty_1 = true; $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                            <option value="<?php echo e($task->id); ?>"><?php echo e(ucfirst($task->heading)); ?></option>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                            <option value=""><?php echo app('translator')->getFromJson('messages.noTaskAddedToProject'); ?></option>
                                                                        <?php endif; ?>
                                                                    </select>
                                                                <?php else: ?>
                                                                    <label><?php echo app('translator')->getFromJson('modules.timeLogs.employeeName'); ?></label>
                                                                    <select class="selectpicker form-control" name="user_id"
                                                                            id="user_id" data-style="form-control">
                                                                        <?php $__empty_1 = true; $__currentLoopData = $project->members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                            <option value="<?php echo e($member->user->id); ?>"><?php echo e($member->user->name); ?></option>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                            <option value=""><?php echo app('translator')->getFromJson('messages.noMemberAddedToProject'); ?></option>
                                                                        <?php endif; ?>
                                                                    </select>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 ">
                                                            <div class="form-group">
                                                                <label><?php echo app('translator')->getFromJson('modules.timeLogs.startDate'); ?></label>
                                                                <input id="start_date" name="start_date" type="text"
                                                                       class="form-control"
                                                                       value="<?php echo e(\Carbon\Carbon::today()->format('m/d/Y')); ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 ">
                                                            <div class="form-group">
                                                                <label><?php echo app('translator')->getFromJson('modules.timeLogs.endDate'); ?></label>
                                                                <input id="end_date" name="end_date" type="text"
                                                                       class="form-control"
                                                                       value="<?php echo e(\Carbon\Carbon::today()->format('m/d/Y')); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="input-group bootstrap-timepicker timepicker">
                                                                <label><?php echo app('translator')->getFromJson('modules.timeLogs.startTime'); ?></label>
                                                                <input type="text" name="start_time" id="start_time"
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="input-group bootstrap-timepicker timepicker">
                                                                <label><?php echo app('translator')->getFromJson('modules.timeLogs.endTime'); ?></label>
                                                                <input type="text" name="end_time" id="end_time"
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for=""><?php echo app('translator')->getFromJson('modules.timeLogs.totalHours'); ?></label>

                                                            <p id="total_time" class="form-control-static">0 Hrs</p>
                                                        </div>
                                                    </div>

                                                    <div class="row m-t-20">
                                                        <div class="col-md-9">
                                                            <div class="form-group">
                                                                <label for="memo"><?php echo app('translator')->getFromJson('modules.timeLogs.memo'); ?></label>
                                                                <input type="text" name="memo" id="memo"
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-actions m-t-30">
                                                    <button type="button" id="save-form" class="btn btn-success"><i
                                                                class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.save'); ?></button>
                                                </div>
                                                <?php echo Form::close(); ?>


                                                <hr>
                                            </div>
                                        </div>

                                        <div class="table-responsive m-t-30">
                                            <table class="table table-bordered table-hover toggle-circle default footable-loaded footable"
                                                   id="timelog-table">
                                                <thead>
                                                <tr>
                                                    <th><?php echo app('translator')->getFromJson('app.id'); ?></th>
                                                    <th><?php echo app('translator')->getFromJson('modules.timeLogs.whoLogged'); ?></th>
                                                    <th><?php echo app('translator')->getFromJson('modules.timeLogs.startTime'); ?></th>
                                                    <th><?php echo app('translator')->getFromJson('modules.timeLogs.endTime'); ?></th>
                                                    <th><?php echo app('translator')->getFromJson('modules.timeLogs.totalHours'); ?></th>
                                                    <th><?php echo app('translator')->getFromJson('modules.timeLogs.memo'); ?></th>
                                                    <th><?php echo app('translator')->getFromJson('modules.timeLogs.lastUpdatedBy'); ?></th>
                                                    <th><?php echo app('translator')->getFromJson('app.action'); ?></th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </section>

                    </div><!-- /content -->
                </div><!-- /tabs -->
            </section>
        </div>


    </div>
    <!-- .row -->

    
    <div class="modal fade bs-modal-md in" id="editTimeLogModal" role="dialog" aria-labelledby="myModalLabel"
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
<script src="<?php echo e(asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/timepicker/bootstrap-timepicker.min.js')); ?>"></script>

<script src="<?php echo e(asset('plugins/bower_components/datatables/jquery.dataTables.min.js')); ?>"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>

<script>
    var table = $('#timelog-table').dataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: '<?php echo route('admin.time-logs.data', $project->id); ?>',
        deferRender: true,
        language: {
            "url": "<?php echo __("app.datatable") ?>"
        },
        "fnDrawCallback": function (oSettings) {
            $("body").tooltip({
                selector: '[data-toggle="tooltip"]'
            });
        },
        "order": [[0, "desc"]],
        columns: [
            {data: 'id', name: 'id'},
            {data: 'user_id', name: 'user_id'},
            {data: 'start_time', name: 'start_time'},
            {data: 'end_time', name: 'end_time'},
            {data: 'total_hours', name: 'total_hours'},
            {data: 'memo', name: 'memo'},
            {data: 'edited_by_user', name: 'edited_by_user'},
            {data: 'action', name: 'action'}
        ]
    });


    $('#start_time, #end_time').timepicker().on('hide.timepicker', function (e) {
//        console.log('The time is ' + e.time.value);
//        console.log('The hour is ' + e.time.hours);
//        console.log('The minute is ' + e.time.minutes);
//        console.log('The meridian is ' + e.time.meridian);
        calculateTime();
    });

    jQuery('#start_date, #end_date').datepicker({
        autoclose: true,
        todayHighlight: true
    }).on('hide', function (e) {
        calculateTime();
    });

    function calculateTime() {
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        var startTime = $("#start_time").val();
        var endTime = $("#end_time").val();

        var timeStart = new Date(startDate + " " + startTime);
        var timeEnd = new Date(endDate + " " + endTime);

        var diff = (timeEnd - timeStart) / 60000; //dividing by seconds and milliseconds

        var minutes = diff % 60;
        var hours = (diff - minutes) / 60;

        if (hours < 0 || minutes < 0) {
            var numberOfDaysToAdd = 1;
            timeEnd.setDate(timeEnd.getDate() + numberOfDaysToAdd);
            var dd = timeEnd.getDate();

            if (dd < 10) {
                dd = "0" + dd;
            }

            var mm = timeEnd.getMonth() + 1;

            if (mm < 10) {
                mm = "0" + mm;
            }

            var y = timeEnd.getFullYear();

            $('#end_date').val(mm + '/' + dd + '/' + y);
            calculateTime();
        } else {
            $('#total_time').html(hours + "Hrs " + minutes + "Mins");
        }

//        console.log(hours+" "+minutes);
    }

    $('#save-form').click(function () {
        $.easyAjax({
            url: '<?php echo e(route('admin.time-logs.store')); ?>',
            container: '#logTime',
            type: "POST",
            data: $('#logTime').serialize(),
            success: function (data) {
                if (data.status == 'success') {
                    table._fnDraw();
                }
            }
        })
    });

    $('#show-add-form').click(function () {
        $('#logTime').toggleClass('hide', 'show');
    });


    $('body').on('click', '.sa-params', function () {
        var id = $(this).data('time-id');
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover the deleted time log!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel please!",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {

                var url = "<?php echo e(route('admin.time-logs.destroy',':id')); ?>";
                url = url.replace(':id', id);

                var token = "<?php echo e(csrf_token()); ?>";

                $.easyAjax({
                    type: 'POST',
                            url: url,
                            data: {'_token': token, '_method': 'DELETE'},
                    success: function (response) {
                        if (response.status == "success") {
                            $.unblockUI();
//                                    swal("Deleted!", response.message, "success");
                            table._fnDraw();
                        }
                    }
                });
            }
        });
    });

    $('body').on('click', '.edit-time-log', function () {
        var id = $(this).data('time-id');

        var url = '<?php echo e(route('admin.time-logs.edit', ':id')); ?>';
        url = url.replace(':id', id);

        $('#modelHeading').html('Update Time Log');
        $.ajaxModal('#editTimeLogModal', url);

    });


</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/projects/time-logs/show.blade.php ENDPATH**/ ?>