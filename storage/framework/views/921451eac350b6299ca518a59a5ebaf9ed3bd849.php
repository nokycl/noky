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

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-12 text-right">
            <a href="<?php echo e(route('admin.ticket-agents.index')); ?>" class="btn btn-inverse"><i class="fa fa-gear fa-spin"></i> <?php echo app('translator')->getFromJson('app.menu.ticketSettings'); ?></a>
        </div>
        <div class="col-md-12 m-t-10">
            <div class="white-box p-b-0">
                <div class="row">
                    <div class="col-sm-4">
                        <label class="control-label"><?php echo app('translator')->getFromJson('app.selectDateRange'); ?></label>

                        <div class="form-group">
                            <input class="form-control input-daterange-datepicker" type="text" name="daterange"
                                   value="<?php echo e($startDate.' - '.$endDate); ?>"/>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="white-box bg-inverse">
                                <h3 class="box-title text-white"><?php echo app('translator')->getFromJson('modules.tickets.totalTickets'); ?>
                                    <a class="mytooltip" href="javascript:void(0)"> <i class="fa fa-info-circle text-white"></i><span class="tooltip-content5"><span class="tooltip-text3"><span class="tooltip-inner2"><?php echo app('translator')->getFromJson('modules.tickets.totalTicketInfo'); ?></span></span></span></a>
                                </h3>
                                <ul class="list-inline two-part">
                                    <li><i class="ti-ticket text-white"></i></li>
                                    <li class="text-right"><span id="totalTickets" class="counter text-white">0</span></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="white-box bg-success">
                                <h3 class="box-title text-white"><?php echo app('translator')->getFromJson('modules.tickets.totalClosedTickets'); ?>
                                    <a class="mytooltip" href="javascript:void(0)"> <i class="fa fa-info-circle text-white"></i><span class="tooltip-content5"><span class="tooltip-text3"><span class="tooltip-inner2"><?php echo app('translator')->getFromJson('modules.tickets.closedTicketInfo'); ?></span></span></span></a>
                                </h3>
                                <ul class="list-inline two-part">
                                    <li><i class="ti-ticket text-white"></i></li>
                                    <li class="text-right"><span id="closedTickets" class="counter text-white">0</span></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="white-box p-t-10 p-b-10 bg-danger">
                                <h3 class="box-title text-white"><?php echo app('translator')->getFromJson('modules.tickets.totalOpenTickets'); ?>
                                    <a class="mytooltip" href="javascript:void(0)"> <i class="fa fa-info-circle text-white"></i><span class="tooltip-content5"><span class="tooltip-text3"><span class="tooltip-inner2"><?php echo app('translator')->getFromJson('modules.tickets.openTicketInfo'); ?></span></span></span></a>
                                </h3>
                                <ul class="list-inline two-part">
                                    <li><i class="ti-ticket text-white"></i></li>
                                    <li class="text-right"><span id="openTickets" class="counter text-white">0</span></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="white-box p-t-10 p-b-10 bg-warning">
                                <h3 class="box-title text-white"><?php echo app('translator')->getFromJson('modules.tickets.totalPendingTickets'); ?>
                                    <a class="mytooltip" href="javascript:void(0)"> <i class="fa fa-info-circle text-white"></i><span class="tooltip-content5"><span class="tooltip-text3"><span class="tooltip-inner2"><?php echo app('translator')->getFromJson('modules.tickets.pendingTicketInfo'); ?></span></span></span></a>
                                </h3>
                                <ul class="list-inline two-part">
                                    <li><i class="ti-ticket text-white"></i></li>
                                    <li class="text-right"><span id="pendingTickets" class="counter text-white">0</span></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="white-box p-t-10 p-b-10 bg-info">
                                <h3 class="box-title text-white"><?php echo app('translator')->getFromJson('modules.tickets.totalResolvedTickets'); ?>
                                    <a class="mytooltip" href="javascript:void(0)"> <i class="fa fa-info-circle text-white"></i><span class="tooltip-content5"><span class="tooltip-text3"><span class="tooltip-inner2"><?php echo app('translator')->getFromJson('modules.tickets.resolvedTicketInfo'); ?></span></span></span></a>
                                </h3>
                                <ul class="list-inline two-part">
                                    <li><i class="ti-ticket text-white"></i></li>
                                    <li class="text-right"><span id="resolvedTickets" class="counter text-white">0</span></li>
                                </ul>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="col-md-5">
                    <div class="white-box p-t-10 p-b-10">
                        <h3 class="box-title"><?php echo app('translator')->getFromJson('modules.tickets.ticketTrendGraph'); ?> </h3>
                        <ul class="list-inline text-right">
                            <li>
                                <h5><i class="fa fa-circle m-r-5" style="color: #4c5667;"></i><?php echo app('translator')->getFromJson('modules.invoices.total'); ?></h5>
                            </li>
                            <li>
                                <h5><i class="fa fa-circle m-r-5" style="color: #5475ed;"></i><?php echo app('translator')->getFromJson('modules.issues.resolved'); ?></h5>
                            </li>
                            <li>
                                <h5><i class="fa fa-circle m-r-5" style="color: #f1c411;"></i><?php echo app('translator')->getFromJson('modules.tickets.totalUnresolvedTickets'); ?></h5>
                            </li>
                        </ul>
                        <div id="morris-area-chart" style="height: 225px;"></div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="white-box">

                <h2><?php echo app('translator')->getFromJson('app.menu.tickets'); ?></h2>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <a href="<?php echo e(route('admin.tickets.create')); ?>"
                               class="btn btn-info btn-sm"><?php echo app('translator')->getFromJson('modules.tickets.addTicket'); ?> <i class="fa fa-plus"
                                                                                                 aria-hidden="true"></i></a>
                            <a href="javascript:;" id="toggle-filter" class="btn btn-outline btn-danger btn-sm toggle-filter"><i
                                        class="fa fa-sliders"></i> <?php echo app('translator')->getFromJson('app.filterResults'); ?></a>
                        </div>
                    </div>
                    <div class="col-sm-6 text-right hidden-xs">
                        <div class="form-group">
                            <a href="javascript:;" onclick="exportData()" class="btn btn-info btn-sm"><i class="ti-export" aria-hidden="true"></i> <?php echo app('translator')->getFromJson('app.exportExcel'); ?></a>
                        </div>
                    </div>
                </div>

                <div class="row b-b b-t" style="display: none; background: #fbfbfb;" id="ticket-filters">
                    <div class="col-md-12">
                        <h4><?php echo app('translator')->getFromJson('app.filterBy'); ?> <a href="javascript:;" class="pull-right toggle-filter"><i class="fa fa-times-circle-o"></i></a></h4>
                    </div>
                    <form action="" id="filter-form">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label"><?php echo app('translator')->getFromJson('modules.tickets.agent'); ?></label>
                            <select class="form-control selectpicker" name="agent_id" id="agent_id" data-style="form-control">
                                <option value=""><?php echo app('translator')->getFromJson('modules.tickets.nofilter'); ?></option>
                                <?php $__empty_1 = true; $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php if(count($group->enabled_agents) > 0): ?>
                                        <optgroup label="<?php echo e(ucwords($group->group_name)); ?>">
                                            <?php $__currentLoopData = $group->enabled_agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($agent->user->id); ?>"><?php echo e(ucwords($agent->user->name).' ['.$agent->user->email.']'); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </optgroup>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <option value=""><?php echo app('translator')->getFromJson('messages.noGroupAdded'); ?></option>
                                <?php endif; ?>
                            </select>
                        </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><?php echo app('translator')->getFromJson('app.status'); ?></label>
                                <select class="form-control selectpicker" name="status" id="status" data-style="form-control">
                                    <option value=""><?php echo app('translator')->getFromJson('modules.tickets.nofilter'); ?></option>
                                    <option value="open"><?php echo app('translator')->getFromJson('modules.tickets.totalOpenTickets'); ?></option>
                                    <option value="pending"><?php echo app('translator')->getFromJson('modules.tickets.totalPendingTickets'); ?></option>
                                    <option value="resolved"><?php echo app('translator')->getFromJson('modules.tickets.totalResolvedTickets'); ?></option>
                                    <option value="closed"><?php echo app('translator')->getFromJson('modules.tickets.totalClosedTickets'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><?php echo app('translator')->getFromJson('modules.tasks.priority'); ?></label>
                                <select class="form-control selectpicker" name="priority" id="priority" data-style="form-control">
                                    <option value=""><?php echo app('translator')->getFromJson('modules.tickets.nofilter'); ?></option>
                                    <option value="low"><?php echo app('translator')->getFromJson('modules.tasks.low'); ?></option>
                                    <option value="medium"><?php echo app('translator')->getFromJson('modules.tasks.medium'); ?></option>
                                    <option value="high"><?php echo app('translator')->getFromJson('modules.tasks.high'); ?></option>
                                    <option value="urgent"><?php echo app('translator')->getFromJson('modules.tickets.urgent'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><?php echo app('translator')->getFromJson('modules.tickets.channelName'); ?></label>
                                <select class="form-control selectpicker" name="channel_id" id="channel_id" data-style="form-control">
                                    <option value=""><?php echo app('translator')->getFromJson('modules.tickets.nofilter'); ?></option>
                                    <?php $__empty_1 = true; $__currentLoopData = $channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $channel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($channel->id); ?>"><?php echo e(ucwords($channel->channel_name)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <option value=""><?php echo app('translator')->getFromJson('messages.noTicketChannelAdded'); ?></option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><?php echo app('translator')->getFromJson('modules.invoices.type'); ?></label>
                                <select class="form-control selectpicker" name="type_id" id="type_id" data-style="form-control">
                                    <option value=""><?php echo app('translator')->getFromJson('modules.tickets.nofilter'); ?></option>
                                    <?php $__empty_1 = true; $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($type->id); ?>"><?php echo e(ucwords($type->type)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <option value=""><?php echo app('translator')->getFromJson('messages.noTicketTypeAdded'); ?></option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label col-xs-12">&nbsp;</label>
                                <button type="button" id="apply-filters" class="btn btn-success col-md-6"><i class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.apply'); ?></button>
                                <button type="button" id="reset-filters" class="btn btn-inverse col-md-5 col-md-offset-1"><i class="fa fa-refresh"></i> <?php echo app('translator')->getFromJson('app.reset'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="row">
                    <div class="col-sm-12 m-t-20">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover toggle-circle default footable-loaded footable"
                                   id="tasks-table">
                                <thead>
                                <tr>
                                    <th><?php echo app('translator')->getFromJson('modules.tickets.ticket'); ?> #</th>
                                    <th><?php echo app('translator')->getFromJson('modules.tickets.ticketSubject'); ?></th>
                                    <th><?php echo app('translator')->getFromJson('modules.tickets.requesterName'); ?></th>
                                    <th><?php echo app('translator')->getFromJson('modules.tickets.requestedOn'); ?></th>
                                    <th><?php echo app('translator')->getFromJson('app.others'); ?></th>
                                    <th><?php echo app('translator')->getFromJson('app.action'); ?></th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- .row -->

<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-script'); ?>
<script src="<?php echo e(asset('plugins/bower_components/moment/moment.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/bootstrap-daterangepicker/daterangepicker.js')); ?>"></script>

<script src="<?php echo e(asset('plugins/bower_components/datatables/jquery.dataTables.min.js')); ?>"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>

<script src="<?php echo e(asset('plugins/bower_components/raphael/raphael-min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/morrisjs/morris.js')); ?>"></script>

<script src="<?php echo e(asset('plugins/bower_components/waypoints/lib/jquery.waypoints.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/counterup/jquery.counterup.min.js')); ?>"></script>

<script>
    var startDate = '<?php echo e(\Carbon\Carbon::createFromFormat('m/d/Y', $startDate)->format('Y-m-d')); ?>';
    var endDate = '<?php echo e(\Carbon\Carbon::createFromFormat('m/d/Y', $endDate)->format('Y-m-d')); ?>';

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
                "<?php echo e(__('app.december')); ?>"
            ]
        }
    })

    $('.input-daterange-datepicker').on('apply.daterangepicker', function (ev, picker) {
        startDate = picker.startDate.format('YYYY-MM-DD');
        endDate = picker.endDate.format('YYYY-MM-DD');
        showTable();
    });

    $('.toggle-filter').click(function () {
        $('#ticket-filters').toggle('slide');
    })

    function ticketChart(chartData){
        Morris.Area({
            element: 'morris-area-chart',
            data: chartData,
            xkey: 'date',
            ykeys: ['total', 'resolved', 'unresolved'],
            labels: ['Total', 'Resolved', 'Unresolved'],
            pointSize: 3,
            fillOpacity: 0.3,
            pointStrokeColors: ['#4c5667', '#5475ed', '#f1c411'],
            behaveLikeLine: true,
            gridLineColor: '#e0e0e0',
            lineWidth: 3,
            hideHover: 'auto',
            lineColors: ['#4c5667', '#5475ed', '#f1c411'],
            resize: true

        });
    }

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

        var agentId = $('#agent_id').val();
        if (agentId == "") {
            agentId = 0;
        }

        var status = $('#status').val();
        if (status == "") {
            status = 0;
        }

        var priority = $('#priority').val();
        if (priority == "") {
            priority = 0;
        }

        var channelId = $('#channel_id').val();
        if (channelId == "") {
            channelId = 0;
        }

        var typeId = $('#type_id').val();
        if (typeId == "") {
            typeId = 0;
        }


        //refresh counts and chart
        var url = '<?php echo route('admin.tickets.refreshCount', [':startDate', ':endDate', ':agentId', ':status', ':priority', ':channelId', ':typeId']); ?>';
        url = url.replace(':startDate', startDate);
        url = url.replace(':endDate', endDate);
        url = url.replace(':agentId', agentId);
        url = url.replace(':status', status);
        url = url.replace(':priority', priority);
        url = url.replace(':channelId', channelId);
        url = url.replace(':typeId', typeId);

        $.easyAjax({
            type: 'GET',
            url: url,
            success: function (response) {
                $('#totalTickets').html(response.totalTickets);
                $('#closedTickets').html(response.closedTickets);
                $('#openTickets').html(response.openTickets);
                $('#pendingTickets').html(response.pendingTickets);
                $('#resolvedTickets').html(response.resolvedTickets);
                initConter();
                ticketChart(JSON.parse(response.chartData));
            }
        });

        //refresh datatable
        var url2 = '<?php echo route('admin.tickets.data', [':startDate', ':endDate', ':agentId', ':status', ':priority', ':channelId', ':typeId']); ?>';

        url2 = url2.replace(':startDate', startDate);
        url2 = url2.replace(':endDate', endDate);
        url2 = url2.replace(':agentId', agentId);
        url2 = url2.replace(':status', status);
        url2 = url2.replace(':priority', priority);
        url2 = url2.replace(':channelId', channelId);
        url2 = url2.replace(':typeId', typeId);

        table = $('#tasks-table').dataTable({
            destroy: true,
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: url2,
            deferRender: true,
            language: {
                "url": "<?php echo __("app.datatable") ?>"
            },
            "fnDrawCallback": function (oSettings) {
                $("body").tooltip({
                    selector: '[data-toggle="tooltip"]'
                });

                $('body').unblock();
            },
            "order": [[0, "desc"]],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'subject', name: 'subject', width: '25%'},
                {data: 'user_id', name: 'user_id', width: '20%'},
                {data: 'created_at', name: 'created_at'},
                {data: 'others', name: 'others', width: '20%'},
                {data: 'action', name: 'action', "searchable": false}
            ]
        });
    }

    $('#apply-filters').click(function () {
        showTable();
    });

    $('#reset-filters').click(function () {
        $('#filter-form')[0].reset();
        $('#filter-form').find('select').selectpicker('render');
        showTable();
    })


    $('body').on('click', '.sa-params', function () {
        var id = $(this).data('ticket-id');
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover the deleted ticket!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel please!",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {

                var url = "<?php echo e(route('admin.tickets.destroy',':id')); ?>";
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

    function initConter() {
        $(".counter").counterUp({
            delay: 100,
            time: 1200
        });
    }

    showTable();

    function exportData(){

        var agentId = $('#agent_id').val();
        if (agentId == "") {
            agentId = 0;
        }

        var status = $('#status').val();
        if (status == "") {
            status = 0;
        }

        var priority = $('#priority').val();
        if (priority == "") {
            priority = 0;
        }

        var channelId = $('#channel_id').val();
        if (channelId == "") {
            channelId = 0;
        }

        var typeId = $('#type_id').val();
        if (typeId == "") {
            typeId = 0;
        }


        //refresh counts and chart
        var url = '<?php echo route('admin.tickets.export', [':startDate', ':endDate', ':agentId', ':status', ':priority', ':channelId', ':typeId']); ?>';
        url = url.replace(':startDate', startDate);
        url = url.replace(':endDate', endDate);
        url = url.replace(':agentId', agentId);
        url = url.replace(':status', status);
        url = url.replace(':priority', priority);
        url = url.replace(':channelId', channelId);
        url = url.replace(':typeId', typeId);

        window.location.href = url;
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/tickets/index.blade.php ENDPATH**/ ?>