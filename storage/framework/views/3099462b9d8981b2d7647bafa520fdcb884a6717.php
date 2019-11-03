<?php $__env->startSection('page-title'); ?>
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="<?php echo e($pageIcon); ?>"></i> <?php echo e(__($pageTitle)); ?> <?php echo app('translator')->getFromJson('modules.holiday.listOf'); ?> <?php echo e(\Carbon\Carbon::now()->format('Y')); ?></h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo app('translator')->getFromJson('app.menu.home'); ?></a></li>
                <li class="active"><?php echo e(__($pageTitle)); ?> <?php echo app('translator')->getFromJson('modules.holiday.listOf'); ?> <?php echo e(\Carbon\Carbon::now()->format('Y')); ?></li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('head-script'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">

        <div class="col-md-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group pull-left">
                            <a onclick="showAdd()" class="btn btn-outline btn-success btn-sm "><?php echo app('translator')->getFromJson('modules.holiday.addNewHoliday'); ?> <i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                        <div class="form-group pull-right">
                            <a href="javascript:;" onclick="calendarData()" class="btn btn-outline btn-info btn-sm "><?php echo app('translator')->getFromJson('modules.holiday.viewOnCalendar'); ?> <i class="fa fa-calendar" aria-hidden="true"></i></a>
                        </div>
                        <div class="pull-right" style="margin-right: 10px">
                            <a class="btn btn-outline btn-sm btn-primary markHoliday" onclick="showMarkHoliday()" style="display: none">
                                <?php echo app('translator')->getFromJson('modules.holiday.markSunday'); ?>
                                <i class="fa fa-check"></i> </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="form-group col-md-2 pull-right">
                                <label class="control-label"><?php echo app('translator')->getFromJson('app.select'); ?> <?php echo app('translator')->getFromJson('app.year'); ?></label>
                                <select onchange="showData()" class="select2 form-control" data-placeholder="<?php echo app('translator')->getFromJson('app.menu.projects'); ?> <?php echo app('translator')->getFromJson('app.status'); ?>" id="year">
                                    <?php $__empty_1 = true; $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $yr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option <?php if($yr == $year): ?> selected <?php endif; ?> value="<?php echo e($yr); ?>"><?php echo e($yr); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
                <hr>
                <div class="row" id="holidaySectionData" >

                </div>
            </div>
        </div>
    </div>
    <!-- .row -->
    
    <div class="modal fade bs-modal-md in" id="edit-column-form" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" id="modal-data-application">
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
        <?php if($number_of_sundays>$holidays_in_db): ?>
                $('.markHoliday').show();
        <?php endif; ?>

        showData();
       // Delete Holiday
        function del(id, date) {

            swal({
                title: "Are you sure?",
                text: "You will not be able to recover the deleted holiday!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel please!",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function (isConfirm) {
                if (isConfirm) {

                    var url = "<?php echo e(route('admin.holidays.destroy',':id')); ?>";
                    url = url.replace(':id', id);

                    var token = "<?php echo e(csrf_token()); ?>";

                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: {'_token': token, '_method': 'DELETE'},
                    });
                }
            });
        }
        // Show Create Holiday Modal
        function showAdd() {
            var url = "<?php echo e(route('admin.holidays.create')); ?>";
            $.ajaxModal('#edit-column-form', url);
        }
        // Show Create Holiday Modal
        function showMarkHoliday() {
            var url = "<?php echo e(route('admin.holidays.mark-holiday')); ?>?year"+ $('#year').val();
            $.ajaxModal('#edit-column-form', url);
        }
        // Show Create Holiday Modal
        function calendarData() {
            var year = $('#year').val();
            var url = "<?php echo e(route('admin.holidays.calendar', ':year')); ?>";
            url = url.replace(':year', year);
            window.location.href = url;
        }

        // Show Holiday
        function showData() {
            var year = $('#year').val();
            var url = "<?php echo e(route('admin.holidays.view-holiday',':year')); ?>"
            url = url.replace(':year', year);
            $.easyAjax({
                type: 'GET',
                url: url,
                container: '#holidaySectionData',
                success: function (response) {
                  $('#holidaySectionData').html(response.view);
                    if(response.number_of_sundays > response.holidays_in_db){
                        $('.markHoliday').show();
                    }
                    else{
                        $('.markHoliday').hide();
                    }
                }
            });
        }

    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/holidays/index.blade.php ENDPATH**/ ?>