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
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/custom-select/custom-select.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/timepicker/bootstrap-timepicker.min.css')); ?>">

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>


    <h2><?php echo app('translator')->getFromJson('app.filterResults'); ?></h2>

    <div class="white-box">
        <div class="row m-b-10">
        <?php echo Form::open(['id'=>'storePayments','class'=>'ajax-form','method'=>'POST']); ?>

        <div class="col-md-4">
            <div class="example">
                <h5 class="box-title m-t-30"><?php echo app('translator')->getFromJson('app.selectDateRange'); ?></h5>
                <div class="input-daterange input-group" id="date-range">
                    <input type="text" class="form-control" id="start-date" placeholder="<?php echo app('translator')->getFromJson('app.startDate'); ?>" value="<?php echo e(\Carbon\Carbon::today()->subDays(7)->format('Y-m-d')); ?>" />
                    <span class="input-group-addon bg-info b-0 text-white"><?php echo app('translator')->getFromJson('app.to'); ?></span>
                    <input type="text" class="form-control" id="end-date" placeholder="<?php echo app('translator')->getFromJson('app.endDate'); ?>" value="<?php echo e(\Carbon\Carbon::today()->format('Y-m-d')); ?>" />
                </div>
            </div>
            </div>

        <div class="col-md-3">
            <h5 class="box-title m-t-30">
                <?php if($logTimeFor->log_time_for == 'task'): ?>
                    <?php echo app('translator')->getFromJson('app.selectTask'); ?>
                <?php else: ?>
                    <?php echo app('translator')->getFromJson('app.selectProject'); ?>
                <?php endif; ?></h5>
            <div class="form-group" >
                <div class="row">
                    <div class="col-md-12">
                        <?php if($logTimeFor->log_time_for == 'task'): ?>
                            <select class="select2 form-control" data-placeholder="<?php echo app('translator')->getFromJson('app.selectTask'); ?>" id="project_id">
                                <option value="all"><?php echo app('translator')->getFromJson('modules.client.all'); ?></option>
                                    <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($task->id); ?>"><?php echo e(ucwords($task->heading)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </select>
                        <?php else: ?>
                            <select class="select2 form-control" data-placeholder="<?php echo app('translator')->getFromJson('app.selectProject'); ?>" id="project_id">
                                <option value="all"><?php echo app('translator')->getFromJson('modules.client.all'); ?></option>
                                    <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($project->id); ?>"><?php echo e(ucwords($project->project_name)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <h5 class="box-title m-t-30"><?php echo app('translator')->getFromJson('modules.employees.title'); ?></h5>
                <select class="form-control select2" name="employee" id="employee" data-style="form-control">
                    <option value="all"><?php echo app('translator')->getFromJson('modules.client.all'); ?></option>
                    <?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <option value="<?php echo e($employee->id); ?>"><?php echo e(ucfirst($employee->name)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>

        <div class="col-md-2">
            <h5 class="box-title m-t-30">&nbsp;</h5>
            <button type="button" class="btn btn-success" id="filter-results"><i class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.apply'); ?></button>
        </div>
        <?php echo Form::close(); ?>

        <hr>

    </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title b-b"><i class="fa fa-clock-o"></i> <?php echo app('translator')->getFromJson('modules.projects.activeTimers'); ?></h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo app('translator')->getFromJson('modules.projects.whoWorking'); ?></th>
                            <th> <?php if($logTimeFor->log_time_for == 'task'): ?>
                               <?php echo app('translator')->getFromJson('app.task'); ?>
                            <?php else: ?>
                                <?php echo app('translator')->getFromJson('app.project'); ?>
                            <?php endif; ?>
                                <?php echo app('translator')->getFromJson('app.name'); ?></th>
                            <th><?php echo app('translator')->getFromJson('modules.projects.activeSince'); ?></th>
                            <td> </td>
                        </tr>
                        </thead>
                        <tbody id="timer-list">
                        <?php $__empty_1 = true; $__currentLoopData = $activeTimers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$time): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($key+1); ?></td>
                                <td><?php echo e(ucwords($time->name)); ?></td>
                                <td><?php echo e(ucwords($time->project_name)); ?></td>
                                <td class="font-bold timer"><?php echo e($time->duration); ?></td>
                                <td><a href="javascript:;" data-time-id="<?php echo e($time->id); ?>" class="label label-danger stop-timer"><?php echo app('translator')->getFromJson('app.stop'); ?></a></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="3"><?php echo app('translator')->getFromJson('messages.noActiveTimer'); ?></td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12" >
            <div class="white-box">

                <h2><?php echo app('translator')->getFromJson('app.menu.timeLogs'); ?></h2>

                <div class="row">
                    <div class="col-sm-12 text-right hidden-xs">
                        <div class="form-group pull-left">
                            <a href="javascript:;" id="show-add-form"
                               class="btn btn-success btn-outline"><i
                                        class="fa fa-clock-o"></i> <?php echo app('translator')->getFromJson('modules.timeLogs.logTime'); ?>
                            </a>
                        </div>
                        <div class="form-group pull-right">
                            <a onclick="exportTimeLog()" class="btn btn-info"><i class="ti-export" aria-hidden="true"></i> <?php echo app('translator')->getFromJson('app.exportExcel'); ?></a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 hide" id="hideShowTimeLogForm">
                        <?php echo Form::open(['id'=>'logTime','class'=>'ajax-form','method'=>'POST']); ?>

                            <div class="form-body">
                                <div class="row m-t-30">
                                    <div class="col-md-3 ">
                                        <div class="form-group">

                                            <label><?php if($logTimeFor->log_time_for == 'task'): ?>
                                                    <?php echo app('translator')->getFromJson('app.selectTask'); ?>
                                                <?php else: ?>
                                                    <?php echo app('translator')->getFromJson('app.selectProject'); ?>
                                                <?php endif; ?>
                                            </label>
                                            <?php if($logTimeFor->log_time_for == 'task'): ?>
                                                <select class="select2 form-control" name="task_id" data-placeholder="<?php echo app('translator')->getFromJson('app.selectTask'); ?>" id="task_id2">
                                                    <option value=""></option>
                                                    <?php $__currentLoopData = $timeLogTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($task->id); ?>"><?php echo e(ucwords($task->heading)); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                </select>
                                            <?php else: ?>
                                                <select class="select2 form-control" name="project_id" data-placeholder="<?php echo app('translator')->getFromJson('app.selectProject'); ?>"  id="project_id2">
                                                    <option value=""></option>
                                                    <?php $__currentLoopData = $timeLogProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($project->id); ?>"><?php echo e(ucwords($project->project_name)); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3 " id="employeeBox">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->getFromJson('modules.timeLogs.employeeName'); ?></label>
                                            <select class="form-control" name="user_id"
                                                    id="user_id" data-style="form-control">
                                            </select>
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
                    <table class="table table-bordered table-hover toggle-circle default footable-loaded footable" id="timelog-table">
                        <thead>
                        <tr>
                            <th><?php echo app('translator')->getFromJson('app.id'); ?></th>
                            <?php if($logTimeFor->log_time_for == 'task'): ?>
                                <th><?php echo app('translator')->getFromJson('app.task'); ?></th>
                            <?php else: ?>
                                <th><?php echo app('translator')->getFromJson('app.project'); ?></th>
                            <?php endif; ?>
                            <th><?php echo app('translator')->getFromJson('app.menu.employees'); ?></th>
                            <th><?php echo app('translator')->getFromJson('modules.timeLogs.startTime'); ?></th>
                            <th><?php echo app('translator')->getFromJson('modules.timeLogs.endTime'); ?></th>
                            <th><?php echo app('translator')->getFromJson('modules.timeLogs.totalHours'); ?></th>
                            <th><?php echo app('translator')->getFromJson('app.earnings'); ?></th>
                            <th><?php echo app('translator')->getFromJson('modules.timeLogs.memo'); ?></th>
                            <th><?php echo app('translator')->getFromJson('app.action'); ?></th>
                        </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>

    </div>
    <!-- .row -->

    
    <div class="modal fade bs-modal-md in" id="editTimeLogModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
<script src="<?php echo e(asset('plugins/bower_components/custom-select/custom-select.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/timepicker/bootstrap-timepicker.min.js')); ?>"></script>

<script src="<?php echo e(asset('plugins/bower_components/datatables/jquery.dataTables.min.js')); ?>"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>

<script src="<?php echo e(asset('plugins/bower_components/bootstrap-daterangepicker/daterangepicker.js')); ?>"></script>


<script>

    $('#employeeBox').hide();

    $('#save-form').click(function () {
        $.easyAjax({
            url: '<?php echo e(route('admin.time-logs.store')); ?>',
            container: '#logTime',
            type: "POST",
            data: $('#logTime').serialize(),
            success: function (data) {
                if (data.status == 'success') {
                    showTable();
                    $('#hideShowTimeLogForm').toggleClass('hide', 'show');
                }
            }
        })
    });

    $('#project_id2').change(function () {
        var id = $(this).val();
        var url = '<?php echo e(route('admin.all-time-logs.members', ':id')); ?>';
        url = url.replace(':id', id);
        $('#employeeBox').show();
        $.easyAjax({
            url: url,
            type: "GET",
            redirect: true,
            success: function (data) {
                $('#user_id').html(data.html);
            }
        })
    });

    $('#show-add-form').click(function () {
        $('#hideShowTimeLogForm').toggleClass('hide', 'show');
    });
    $(".select2").select2({
        formatNoMatches: function () {
            return "<?php echo e(__('messages.noRecordFound')); ?>";
        }
    });

    jQuery('#date-range').datepicker({
        toggleActive: true,
        format: 'yyyy-mm-dd'
    });

    var table;

    function showTable(){

        var startDate = $('#start-date').val();

        if(startDate == ''){
            startDate = null;
        }

        var endDate = $('#end-date').val();

        if(endDate == ''){
            endDate = null;
        }

        var projectID = $('#project_id').val();
        var employee = $('#employee').val();
        console.log(employee);
        var url = '<?php echo e(route('admin.all-time-logs.data', [':startDate', ':endDate', ':projectId', ':employee'])); ?>';
        url = url.replace(':startDate', startDate);
        url = url.replace(':endDate', endDate);
        url = url.replace(':projectId', projectID);
        url = url.replace(':employee', employee);

        table = $('#timelog-table').dataTable({
            destroy: true,
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: url,
            deferRender: true,
            language: {
                "url": "<?php echo __("app.datatable") ?>"
            },
            "fnDrawCallback": function( oSettings ) {
                $("body").tooltip({
                    selector: '[data-toggle="tooltip"]'
                });
            },
            "order": [[ 0, "desc" ]],
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'project_name', name: 'project_name' },
                { data: 'name', name: 'name' },
                { data: 'start_time', name: 'start_time' },
                { data: 'end_time', name: 'end_time' },
                { data: 'total_hours', name: 'total_hours' },
                { data: 'earnings', name: 'earnings' },
                { data: 'memo', name: 'memo' },
                { data: 'action', name: 'action', "searchable": false }
            ]
        });
    }

    $('#filter-results').click(function () {
        showTable();
    });


    $('body').on('click', '.sa-params', function(){
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
        }, function(isConfirm){
            if (isConfirm) {

                var url = "<?php echo e(route('admin.all-time-logs.destroy',':id')); ?>";
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

    showTable();

    $('#timer-list').on('click', '.stop-timer', function () {
        var id = $(this).data('time-id');
        var url = '<?php echo e(route('admin.all-time-logs.stopTimer', ':id')); ?>';
        url = url.replace(':id', id);
        var token = '<?php echo e(csrf_token()); ?>';
        $.easyAjax({
            url: url,
            type: "POST",
            data: {timeId: id, _token: token},
            success: function (data) {
                $('#timer-list').html(data.html);
                $('#activeCurrentTimerCount').html(data.activeTimers);
            }
        })

    });

    $('body').on('click', '.edit-time-log', function () {
        var id = $(this).data('time-id');

        var url = '<?php echo e(route('admin.time-logs.edit', ':id')); ?>';
        url = url.replace(':id', id);

        $('#modelHeading').html('Update Time Log');
        $.ajaxModal('#editTimeLogModal', url);

    });

    function exportTimeLog(){

        var startDate = $('#start-date').val();

        if(startDate == ''){
            startDate = null;
        }

        var endDate = $('#end-date').val();

        if(endDate == ''){
            endDate = null;
        }

        var projectID = $('#project_id').val();
        var employee = $('#employee').val();

        var url = '<?php echo e(route('admin.all-time-logs.export', [':startDate', ':endDate', ':projectId', ':employee'])); ?>';
        url = url.replace(':startDate', startDate);
        url = url.replace(':endDate', endDate);
        url = url.replace(':projectId', projectID);
        url = url.replace(':employee', employee);

        window.location.href = url;
    }

    $('#start_time, #end_time').timepicker().on('hide.timepicker', function (e) {
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
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/time-logs/index.blade.php ENDPATH**/ ?>