@extends('layouts.member-app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ route('member.dashboard') }}">@lang('app.menu.home')</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/morrisjs/morris.css') }}">

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
@endpush

@section('content')

    <div class="row">
        <div class="col-md-12 m-t-10">
            <div class="white-box p-b-0">
                <div class="row">
                    <div class="col-sm-4">
                        <label class="control-label">@lang('app.selectDateRange')</label>

                        <div class="form-group">
                            <input class="form-control input-daterange-datepicker" type="text" name="daterange"
                                   value="{{ $startDate.' - '.$endDate }}"/>
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
                                <h3 class="box-title text-white">@lang('modules.tickets.totalTickets')
                                    <a class="mytooltip" href="javascript:void(0)"> <i class="fa fa-info-circle text-white"></i><span class="tooltip-content5"><span class="tooltip-text3"><span class="tooltip-inner2">@lang('modules.tickets.totalTicketInfo')</span></span></span></a>
                                </h3>
                                <ul class="list-inline two-part">
                                    <li><i class="ti-ticket text-white"></i></li>
                                    <li class="text-right"><span id="totalTickets" class="counter text-white">0</span></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="white-box bg-success">
                                <h3 class="box-title text-white">@lang('modules.tickets.totalClosedTickets')
                                    <a class="mytooltip" href="javascript:void(0)"> <i class="fa fa-info-circle text-white"></i><span class="tooltip-content5"><span class="tooltip-text3"><span class="tooltip-inner2">@lang('modules.tickets.closedTicketInfo')</span></span></span></a>
                                </h3>
                                <ul class="list-inline two-part">
                                    <li><i class="ti-ticket text-white"></i></li>
                                    <li class="text-right"><span id="closedTickets" class="counter text-white">0</span></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="white-box p-t-10 p-b-10 bg-danger">
                                <h3 class="box-title text-white">@lang('modules.tickets.totalOpenTickets')
                                    <a class="mytooltip" href="javascript:void(0)"> <i class="fa fa-info-circle text-white"></i><span class="tooltip-content5"><span class="tooltip-text3"><span class="tooltip-inner2">@lang('modules.tickets.openTicketInfo')</span></span></span></a>
                                </h3>
                                <ul class="list-inline two-part">
                                    <li><i class="ti-ticket text-white"></i></li>
                                    <li class="text-right"><span id="openTickets" class="counter text-white">0</span></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="white-box p-t-10 p-b-10 bg-warning">
                                <h3 class="box-title text-white">@lang('modules.tickets.totalPendingTickets')
                                    <a class="mytooltip" href="javascript:void(0)"> <i class="fa fa-info-circle text-white"></i><span class="tooltip-content5"><span class="tooltip-text3"><span class="tooltip-inner2">@lang('modules.tickets.pendingTicketInfo')</span></span></span></a>
                                </h3>
                                <ul class="list-inline two-part">
                                    <li><i class="ti-ticket text-white"></i></li>
                                    <li class="text-right"><span id="pendingTickets" class="counter text-white">0</span></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="white-box p-t-10 p-b-10 bg-info">
                                <h3 class="box-title text-white">@lang('modules.tickets.totalResolvedTickets')
                                    <a class="mytooltip" href="javascript:void(0)"> <i class="fa fa-info-circle text-white"></i><span class="tooltip-content5"><span class="tooltip-text3"><span class="tooltip-inner2">@lang('modules.tickets.resolvedTicketInfo')</span></span></span></a>
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
                        <h3 class="box-title">Ticket Trend Graph </h3>
                        <ul class="list-inline text-right">
                            <li>
                                <h5><i class="fa fa-circle m-r-5" style="color: #4c5667;"></i>Total</h5>
                            </li>
                            <li>
                                <h5><i class="fa fa-circle m-r-5" style="color: #5475ed;"></i>Resolved</h5>
                            </li>
                            <li>
                                <h5><i class="fa fa-circle m-r-5" style="color: #f1c411;"></i>Unresolved</h5>
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

                <h2>@lang('app.menu.tickets')</h2>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            @if($user->can('add_tickets'))
                            <a href="{{ route('member.tickets.create') }}"
                               class="btn btn-info btn-sm">@lang('modules.tickets.addTicket') <i class="fa fa-plus" aria-hidden="true"></i></a>
                            @endif
                            <a href="javascript:;" id="toggle-filter" class="btn btn-outline btn-danger btn-sm toggle-filter"><i
                                        class="fa fa-sliders"></i> @lang('app.filterResults')</a>
                        </div>
                    </div>
                </div>

                <div class="row b-b b-t" style="display: none; background: #fbfbfb;" id="ticket-filters">
                    <div class="col-md-12">
                        <h4>@lang('app.filterBy') <a href="javascript:;" class="pull-right toggle-filter"><i class="fa fa-times-circle-o"></i></a></h4>
                    </div>
                    <form action="" id="filter-form">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">@lang('modules.tickets.agent')</label>
                            <select class="form-control selectpicker" name="agent_id" id="agent_id" data-style="form-control">
                                <option value="">No Filter</option>
                                @forelse($groups as $group)
                                    @if(count($group->enabled_agents) > 0)
                                        <optgroup label="{{ ucwords($group->group_name) }}">
                                            @foreach($group->enabled_agents as $agent)
                                                <option value="{{ $agent->user->id }}">{{ ucwords($agent->user->name).' ['.$agent->user->email.']' }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endif
                                @empty
                                    <option value="">@lang('messages.noGroupAdded')</option>
                                @endforelse
                            </select>
                        </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">@lang('app.status')</label>
                                <select class="form-control selectpicker" name="status" id="status" data-style="form-control">
                                    <option value="">No Filter</option>
                                    <option>open</option>
                                    <option>pending</option>
                                    <option>resolved</option>
                                    <option>closed</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">@lang('modules.tasks.priority')</label>
                                <select class="form-control selectpicker" name="priority" id="priority" data-style="form-control">
                                    <option value="">No Filter</option>
                                    <option>low</option>
                                    <option>medium</option>
                                    <option>high</option>
                                    <option>urgent</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">@lang('modules.tickets.channelName')</label>
                                <select class="form-control selectpicker" name="channel_id" id="channel_id" data-style="form-control">
                                    <option value="">No Filter</option>
                                    @forelse($channels as $channel)
                                        <option value="{{ $channel->id }}">{{ ucwords($channel->channel_name) }}</option>
                                    @empty
                                        <option value="">@lang('messages.noTicketChannelAdded')</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">@lang('modules.invoices.type')</label>
                                <select class="form-control selectpicker" name="type_id" id="type_id" data-style="form-control">
                                    <option value="">No Filter</option>
                                    @forelse($types as $type)
                                        <option value="{{ $type->id }}">{{ ucwords($type->type) }}</option>
                                    @empty
                                        <option value="">@lang('messages.noTicketTypeAdded')</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label col-xs-12">&nbsp;</label>
                                <button type="button" id="apply-filters" class="btn btn-success col-md-6"><i class="fa fa-check"></i> @lang('app.apply')</button>
                                <button type="button" id="reset-filters" class="btn btn-inverse col-md-5 col-md-offset-1"><i class="fa fa-refresh"></i> @lang('app.reset')</button>
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
                                    <th>@lang('modules.tickets.ticket') #</th>
                                    <th>@lang('modules.tickets.ticketSubject')</th>
                                    <th>@lang('modules.tickets.requesterName')</th>
                                    <th>@lang('modules.tickets.requestedOn')</th>
                                    <th>@lang('app.others')</th>
                                    <th>@lang('app.action')</th>
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

@endsection

@push('footer-script')
<script src="{{ asset('plugins/bower_components/moment/moment.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

<script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>

<script src="{{ asset('plugins/bower_components/raphael/raphael-min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/morrisjs/morris.js') }}"></script>

<script src="{{ asset('plugins/bower_components/waypoints/lib/jquery.waypoints.js') }}"></script>
<script src="{{ asset('plugins/bower_components/counterup/jquery.counterup.min.js') }}"></script>

<script>
    var startDate = '{{ \Carbon\Carbon::createFromFormat('m/d/Y', $startDate)->format('Y-m-d') }}';
    var endDate = '{{ \Carbon\Carbon::createFromFormat('m/d/Y', $endDate)->format('Y-m-d') }}';

    $('.input-daterange-datepicker').daterangepicker({
        buttonClasses: ['btn', 'btn-sm'],
        cancelClass: 'btn-inverse',
        "locale": {
            "applyLabel": "{{ __('app.apply') }}",
            "cancelLabel": "{{ __('app.cancel') }}",
            "daysOfWeek": [
                "{{ __('app.su') }}",
                "{{ __('app.mo') }}",
                "{{ __('app.tu') }}",
                "{{ __('app.we') }}",
                "{{ __('app.th') }}",
                "{{ __('app.fr') }}",
                "{{ __('app.sa') }}"
            ],
            "monthNames": [
                "{{ __('app.january') }}",
                "{{ __('app.february') }}",
                "{{ __('app.march') }}",
                "{{ __('app.april') }}",
                "{{ __('app.may') }}",
                "{{ __('app.june') }}",
                "{{ __('app.july') }}",
                "{{ __('app.august') }}",
                "{{ __('app.september') }}",
                "{{ __('app.october') }}",
                "{{ __('app.november') }}",
                "{{ __('app.december') }}",
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
        var url = '{!!  route('member.tickets.refreshCount', [':startDate', ':endDate', ':agentId', ':status', ':priority', ':channelId', ':typeId']) !!}';
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
        var url2 = '{!!  route('member.tickets.adminData', [':startDate', ':endDate', ':agentId', ':status', ':priority', ':channelId', ':typeId']) !!}';

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

                var url = "{{ route('member.tickets.destroy',':id') }}";
                url = url.replace(':id', id);

                var token = "{{ csrf_token() }}";

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
</script>
@endpush