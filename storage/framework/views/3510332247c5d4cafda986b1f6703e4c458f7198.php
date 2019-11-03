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
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/bootstrap-daterangepicker/daterangepicker.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/morrisjs/morris.css')); ?>">

<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/custom-select/custom-select.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css')); ?>">

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <a href="<?php echo e(route('admin.attendances.create')); ?>"
                   class="btn btn-success btn-sm"><?php echo app('translator')->getFromJson('modules.attendance.markAttendance'); ?> <i class="fa fa-plus"
                                                                                                aria-hidden="true"></i></a>
            </div>
        </div>

        <div class="sttabs tabs-style-line col-md-12">
            <div class="white-box">
                <nav>
                    <ul>
                        <li class="tab-current"><a href="<?php echo e(route('admin.attendances.index')); ?>"><span><?php echo app('translator')->getFromJson('modules.attendance.attendanceByMember'); ?></span></a>
                        </li>
                        <li><a href="<?php echo e(route('admin.attendances.attendanceByDate')); ?>"><span><?php echo app('translator')->getFromJson('modules.attendance.attendanceByDate'); ?></span></a>
                        </li>

                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!-- .row -->

    <div class="row">
        <div class="col-md-12">
            <div class="white-box p-b-0 bg-inverse text-white">
                <div class="row">
                    <div class="col-md-4">
                        <label class="control-label"><?php echo app('translator')->getFromJson('app.selectDateRange'); ?></label>

                        <div class="form-group">
                            <input class="form-control input-daterange-datepicker" type="text" name="daterange"
                                   value="<?php echo e($startDate->format('m/d/Y').' - '.$endDate->format('m/d/Y')); ?>"/>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label"><?php echo app('translator')->getFromJson('modules.timeLogs.employeeName'); ?></label>
                            <select class="select2 form-control" data-placeholder="Choose Employee" id="user_id" name="user_id">
                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($employee->id); ?>"><?php echo e(ucwords($employee->name)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group m-t-25">
                            <button type="button" id="apply-filter" class="btn btn-success btn-block"><?php echo app('translator')->getFromJson('app.apply'); ?></button>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="white-box bg-inverse">
                        <h3 class="box-title text-white"><?php echo app('translator')->getFromJson('modules.attendance.totalWorkingDays'); ?></h3>
                        <ul class="list-inline two-part">
                            <li><i class="icon-clock text-white"></i></li>
                            <li class="text-right"><span id="totalWorkingDays" class="counter text-white"><?php echo e($totalWorkingDays); ?></span></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="white-box bg-success">
                        <h3 class="box-title text-white"><?php echo app('translator')->getFromJson('modules.attendance.daysPresent'); ?></h3>
                        <ul class="list-inline two-part">
                            <li><i class="icon-clock text-white"></i></li>
                            <li class="text-right"><span id="daysPresent" class="counter text-white"><?php echo e($daysPresent); ?></span></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="white-box bg-danger">
                        <h3 class="box-title text-white"><?php echo app('translator')->getFromJson('app.days'); ?> <?php echo app('translator')->getFromJson('modules.attendance.late'); ?></h3>
                        <ul class="list-inline two-part">
                            <li><i class="icon-clock text-white"></i></li>
                            <li class="text-right"><span id="daysLate" class="counter text-white"><?php echo e($daysLate); ?></span></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="white-box bg-warning">
                        <h3 class="box-title text-white"><?php echo app('translator')->getFromJson('modules.attendance.halfDay'); ?></h3>
                        <ul class="list-inline two-part">
                            <li><i class="icon-clock text-white"></i></li>
                            <li class="text-right"><span id="halfDays" class="counter text-white"><?php echo e($halfDays); ?></span></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="white-box bg-info">
                        <h3 class="box-title text-white"><?php echo app('translator')->getFromJson('app.days'); ?> <?php echo app('translator')->getFromJson('modules.attendance.absent'); ?></h3>
                        <ul class="list-inline two-part">
                            <li><i class="icon-clock text-white"></i></li>
                            <li class="text-right"><span id="absentDays" class="counter text-white"><?php echo e((($totalWorkingDays - $daysPresent) < 0) ? '0' : ($totalWorkingDays - $daysPresent)); ?></span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="white-box bg-primary">
                        <h3 class="box-title text-white"> <?php echo app('translator')->getFromJson('modules.attendance.holidays'); ?></h3>
                        <ul class="list-inline two-part">
                            <li><i class="icon-clock text-white"></i></li>
                            <li class="text-right"><span id="holidayDays" class="counter text-white"><?php echo e($holidays); ?></span></li>
                        </ul>
                    </div>
                </div>

            </div>

        </div>

        <div class="col-md-12">
            <div class="white-box">

            <table class="table">
                <thead>
                <tr>
                    <th><?php echo app('translator')->getFromJson('app.date'); ?></th>
                    <th><?php echo app('translator')->getFromJson('app.status'); ?></th>
                    <th><?php echo app('translator')->getFromJson('modules.attendance.clock_in'); ?></th>
                    <th><?php echo app('translator')->getFromJson('modules.attendance.clock_out'); ?></th>
                    <th><?php echo app('translator')->getFromJson('app.others'); ?></th>
                </tr>
                </thead>
                <tbody id="attendanceData">
                </tbody>
            </table>
            </div>

        </div>

    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-script'); ?>
<script src="<?php echo e(asset('plugins/bower_components/moment/moment.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/bootstrap-daterangepicker/daterangepicker.js')); ?>"></script>

<script src="<?php echo e(asset('plugins/bower_components/datatables/jquery.dataTables.min.js')); ?>"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>

<script src="<?php echo e(asset('plugins/bower_components/custom-select/custom-select.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js')); ?>"></script>

<script src="<?php echo e(asset('plugins/bower_components/waypoints/lib/jquery.waypoints.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/counterup/jquery.counterup.min.js')); ?>"></script>

<script>
    var startDate = '<?php echo e($startDate->format('Y-m-d')); ?>';
    var endDate = '<?php echo e($endDate->format('Y-m-d')); ?>';

    $('.input-daterange-datepicker').daterangepicker({
        buttonClasses: ['btn', 'btn-sm'],
        cancelClass: 'btn-inverse',
        "locale": {
            "applyLabel": "<?php echo e(__('app.apply')); ?>",
            "cancelLabel": "<?php echo e(__('app.cancel')); ?>",
            "daysOfWeek": [
                "<?php echo e(__('app.su')); ?>",
                "<?php echo e(__('app.mo')); ?>",
                "<?php echo e(__('app.tu')); ?>",
                "<?php echo e(__('app.we')); ?>",
                "<?php echo e(__('app.th')); ?>",
                "<?php echo e(__('app.fr')); ?>",
                "<?php echo e(__('app.sa')); ?>"
            ],
            "monthNames": [
                "<?php echo e(__('app.january')); ?>",
                "<?php echo e(__('app.february')); ?>",
                "<?php echo e(__('app.march')); ?>",
                "<?php echo e(__('app.april')); ?>",
                "<?php echo e(__('app.may')); ?>",
                "<?php echo e(__('app.june')); ?>",
                "<?php echo e(__('app.july')); ?>",
                "<?php echo e(__('app.august')); ?>",
                "<?php echo e(__('app.september')); ?>",
                "<?php echo e(__('app.october')); ?>",
                "<?php echo e(__('app.november')); ?>",
                "<?php echo e(__('app.december')); ?>",
            ]
        }
    })

    $('.input-daterange-datepicker').on('apply.daterangepicker', function (ev, picker) {
        startDate = picker.startDate.format('YYYY-MM-DD');
        endDate = picker.endDate.format('YYYY-MM-DD');
        showTable();
    });

    $('#apply-filter').click(function () {
       showTable();
    });

    $(".select2").select2({
        formatNoMatches: function () {
            return "<?php echo e(__('messages.noRecordFound')); ?>";
        }
    });

    var table;

    function showTable() {

        $('body').block({
            message: '<p style="margin:0;padding:8px;font-size:24px;">Just a moment...</p>'
            , css: {
                color: '#fff'
                , border: '1px solid #fb9678'
                , backgroundColor: '#fb9678'
            }
        });

        var userId = $('#user_id').val();
        if (userId == "") {
            userId = 0;
        }


        //refresh counts
        var url = '<?php echo route('admin.attendances.refreshCount', [':startDate', ':endDate', ':userId']); ?>';
        url = url.replace(':startDate', startDate);
        url = url.replace(':endDate', endDate);
        url = url.replace(':userId', userId);

        $.easyAjax({
            type: 'GET',
            url: url,
            success: function (response) {
                $('#daysPresent').html(response.daysPresent);
                $('#daysLate').html(response.daysLate);
                $('#halfDays').html(response.halfDays);
                $('#totalWorkingDays').html(response.totalWorkingDays);
                $('#absentDays').html(response.absentDays);
                $('#holidayDays').html(response.holidays);
                initConter();
            }
        });

        //refresh datatable
        var url2 = '<?php echo route('admin.attendances.employeeData', [':startDate', ':endDate', ':userId']); ?>';

        url2 = url2.replace(':startDate', startDate);
        url2 = url2.replace(':endDate', endDate);
        url2 = url2.replace(':userId', userId);

        $.easyAjax({
            type: 'GET',
            url: url2,
            success: function (response) {
                $('#attendanceData').html(response.data);
            }
        });
    }

    $('#attendanceData').on('click', '.delete-attendance', function(){
        var id = $(this).data('attendance-id');
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover the deleted attendance record!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel please!",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function(isConfirm){
            if (isConfirm) {

                var url = "<?php echo e(route('admin.attendances.destroy',':id')); ?>";
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
                            showTable();
                        }
                    }
                });
            }
        });
    });

    function initConter() {
        $(".counter").counterUp({
            delay: 100,
            time: 1200
        });
    }

    showTable();

    function exportData(){

        var employee = $('#employee').val();
        var status   = $('#status').val();
        var role     = $('#role').val();

        var url = '<?php echo e(route('admin.employees.export', [':status' ,':employee', ':role'])); ?>';
        url = url.replace(':role', role);
        url = url.replace(':status', status);
        url = url.replace(':employee', employee);

        window.location.href = url;
    }

    function exportData(){

        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        var employee = $('#employee').val();

        var url = '<?php echo e(route('admin.attendances.export', [':startDate' ,':endDate' ,':employee'])); ?>';
        url = url.replace(':startDate', startDate);
        url = url.replace(':endDate', endDate);
        url = url.replace(':employee', employee);

        window.location.href = url;
    }

</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/attendance/index.blade.php ENDPATH**/ ?>