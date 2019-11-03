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
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <div class="row">
                    <h3 class="box-title col-md-3"><?php echo app('translator')->getFromJson('app.menu.Events'); ?></h3>

                    <div class="col-md-9">
                        <a href="#" data-toggle="modal" data-target="#my-event" class="btn btn-sm btn-success waves-effect waves-light  pull-right">
                            <i class="ti-plus"></i> <?php echo app('translator')->getFromJson('modules.events.addEvent'); ?>
                        </a>

                    </div>

                </div>


                <div id="calendar"></div>
            </div>
        </div>
    </div>
    <!-- .row -->

    <!-- BEGIN MODAL -->
    <div class="modal fade bs-modal-md in" id="my-event" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="icon-plus"></i> <?php echo app('translator')->getFromJson('modules.events.addEvent'); ?></h4>
                </div>
                <div class="modal-body">
                    <?php echo Form::open(['id'=>'createEvent','class'=>'ajax-form','method'=>'POST']); ?>

                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6 ">
                                <div class="form-group">
                                    <label><?php echo app('translator')->getFromJson('modules.events.eventName'); ?></label>
                                    <input type="text" name="event_name" id="event_name" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-2 ">
                                <div class="form-group">
                                    <label><?php echo app('translator')->getFromJson('modules.sticky.colors'); ?></label>
                                    <select id="colorselector" name="label_color">
                                        <option value="bg-info" data-color="#5475ed" selected>Blue</option>
                                        <option value="bg-warning" data-color="#f1c411">Yellow</option>
                                        <option value="bg-purple" data-color="#ab8ce4">Purple</option>
                                        <option value="bg-danger" data-color="#ed4040">Red</option>
                                        <option value="bg-success" data-color="#00c292">Green</option>
                                        <option value="bg-inverse" data-color="#4c5667">Grey</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <label><?php echo app('translator')->getFromJson('modules.events.where'); ?></label>
                                    <input type="text" name="where" id="where" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 ">
                                <div class="form-group">
                                    <label><?php echo app('translator')->getFromJson('app.description'); ?></label>
                                    <textarea name="description" id="description" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-md-3 ">
                                <div class="form-group">
                                    <label><?php echo app('translator')->getFromJson('modules.events.startOn'); ?></label>
                                    <input type="text" name="start_date" id="start_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-5 col-md-3">
                                <div class="input-group bootstrap-timepicker timepicker">
                                    <label>&nbsp;</label>
                                    <input type="text" name="start_time" id="start_time"
                                           class="form-control">
                                </div>
                            </div>

                            <div class="col-xs-6 col-md-3">
                                <div class="form-group">
                                    <label><?php echo app('translator')->getFromJson('modules.events.endOn'); ?></label>
                                    <input type="text" name="end_date" id="end_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-5 col-md-3">
                                <div class="input-group bootstrap-timepicker timepicker">
                                    <label>&nbsp;</label>
                                    <input type="text" name="end_time" id="end_time"
                                           class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12"  id="attendees">
                                <div class="form-group">
                                    <label class="col-xs-3 m-t-10"><?php echo app('translator')->getFromJson('modules.events.addAttendees'); ?></label>
                                    <div class="col-xs-7">
                                        <div class="checkbox checkbox-info">
                                            <input id="all-employees" name="all_employees" value="true"
                                                   type="checkbox">
                                            <label for="all-employees"><?php echo app('translator')->getFromJson('modules.events.allEmployees'); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <select class="select2 m-b-10 select2-multiple " multiple="multiple"
                                            data-placeholder="<?php echo app('translator')->getFromJson('modules.messages.chooseMember'); ?>, <?php echo app('translator')->getFromJson('modules.projects.selectClient'); ?>" name="user_id[]">
                                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($emp->id); ?>"><?php echo e(ucwords($emp->name)); ?> <?php if($emp->id == $user->id): ?>
                                                    (YOU) <?php endif; ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <div class="checkbox checkbox-info">
                                        <input id="repeat-event" name="repeat" value="yes"
                                               type="checkbox">
                                        <label for="repeat-event"><?php echo app('translator')->getFromJson('modules.events.repeat'); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="repeat-fields" style="display: none">
                            <div class="col-xs-6 col-md-3 ">
                                <div class="form-group">
                                    <label><?php echo app('translator')->getFromJson('modules.events.repeatEvery'); ?></label>
                                    <input type="number" min="1" value="1" name="repeat_count" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-6 col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <select name="repeat_type" id="" class="form-control">
                                        <option value="day">Day(s)</option>
                                        <option value="week">Week(s)</option>
                                        <option value="month">Month(s)</option>
                                        <option value="year">Year(s)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-6 col-md-3">
                                <div class="form-group">
                                    <label><?php echo app('translator')->getFromJson('modules.events.cycles'); ?> <a class="mytooltip" href="javascript:void(0)"> <i class="fa fa-info-circle"></i><span class="tooltip-content5"><span class="tooltip-text3"><span class="tooltip-inner2"><?php echo app('translator')->getFromJson('modules.events.cyclesToolTip'); ?></span></span></span></a></label>
                                    <input type="text" name="repeat_cycles" id="repeat_cycles" class="form-control">
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php echo Form::close(); ?>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white waves-effect" data-dismiss="modal"><?php echo app('translator')->getFromJson('app.close'); ?></button>
                    <button type="button" class="btn btn-success save-event waves-effect waves-light"><?php echo app('translator')->getFromJson('app.submit'); ?></button>
                </div>
            </div>
        </div>
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
        <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        {
            id: '<?php echo e(ucfirst($event->id)); ?>',
            title: '<?php echo e(ucfirst($event->event_name)); ?>',
            start: '<?php echo e($event->start_date_time); ?>',
            end:  '<?php echo e($event->end_date_time); ?>',
            className: '<?php echo e($event->label_color); ?>'
        },
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
];

    var getEventDetail = function (id) {
        var url = '<?php echo e(route('admin.events.show', ':id')); ?>';
        url = url.replace(':id', id);

        $('#modelHeading').html('Event');
        $.ajaxModal('#eventDetailModal', url);
    }

    var calendarLocale = '<?php echo e($global->locale); ?>';
</script>

<script src="<?php echo e(asset('plugins/bower_components/calendar/jquery-ui.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/moment/moment.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/calendar/dist/fullcalendar.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/calendar/dist/jquery.fullcalendar.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/calendar/dist/locale-all.js')); ?>"></script>
<script src="<?php echo e(asset('js/event-calendar.js')); ?>"></script>

<script src="<?php echo e(asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/timepicker/bootstrap-timepicker.min.js')); ?>"></script>

<script src="<?php echo e(asset('js/cbpFWTabs.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/custom-select/custom-select.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/multiselect/js/jquery.multi-select.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bootstrap-colorselector/bootstrap-colorselector.min.js')); ?>"></script>

<script>
    jQuery('#start_date, #end_date').datepicker({
        autoclose: true,
        todayHighlight: true
    })

    $('#colorselector').colorselector();

    $('#start_time, #end_time').timepicker();

    $(".select2").select2({
        formatNoMatches: function () {
            return "<?php echo e(__('messages.noRecordFound')); ?>";
        }
    });

    function addEventModal(start, end, allDay){
        if(start){
            var sd = new Date(start);
            var curr_date = sd.getDate();
            if(curr_date < 10){
                curr_date = '0'+curr_date;
            }
            var curr_month = sd.getMonth();
            curr_month = curr_month+1;
            if(curr_month < 10){
                curr_month = '0'+curr_month;
            }
            var curr_year = sd.getFullYear();

            $('#start_date').val(curr_month+'/'+curr_date+'/'+curr_year);

            var ed = new Date(start);
            var curr_date = sd.getDate();
            if(curr_date < 10){
                curr_date = '0'+curr_date;
            }
            var curr_month = sd.getMonth();
            curr_month = curr_month+1;
            if(curr_month < 10){
                curr_month = '0'+curr_month;
            }
            var curr_year = ed.getFullYear();
            $('#end_date').val(curr_month+'/'+curr_date+'/'+curr_year);

            $('#start_date, #end_date').datepicker('destroy');
            jQuery('#start_date, #end_date').datepicker({
                autoclose: true,
                todayHighlight: true
            })
        }

        $('#my-event').modal('show');

    }

    $('.save-event').click(function () {
        $.easyAjax({
            url: '<?php echo e(route('admin.events.store')); ?>',
            container: '#createEvent',
            type: "POST",
            data: $('#createEvent').serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    window.location.reload();
                }
            }
        })
    })

    $('#repeat-event').change(function () {
        if($(this).is(':checked')){
            $('#repeat-fields').show();
        }
        else{
            $('#repeat-fields').hide();
        }
    })

</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/event-calendar/index.blade.php ENDPATH**/ ?>