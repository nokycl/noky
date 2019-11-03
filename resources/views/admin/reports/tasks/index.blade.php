@extends('layouts.app')

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
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">

<link rel="stylesheet" href="{{ asset('plugins/bower_components/morrisjs/morris.css') }}">

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
@endpush

@section('content')



    <div class="white-box">
        <div class="row m-b-10">
            <h2>@lang("app.filterResults")</h2>
            {!! Form::open(['id'=>'storePayments','class'=>'ajax-form','method'=>'POST']) !!}
            <div class="col-md-4">
                <div class="example">
                    <h5 class="box-title m-t-30">@lang('app.selectDateRange')</h5>

                    <div class="input-daterange input-group" id="date-range">
                        <input type="text" class="form-control" id="start-date" placeholder="@lang('app.startDate')"
                               value="{{ $fromDate->format('Y-m-d') }}"/>
                        <span class="input-group-addon bg-info b-0 text-white">@lang('app.to')</span>
                        <input type="text" class="form-control" id="end-date" placeholder="@lang('app.endDate')"
                               value="{{ $toDate->format('Y-m-d') }}"/>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <h5 class="box-title m-t-30">@lang('app.selectProject')</h5>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <select class="select2 form-control" data-placeholder="@lang('app.selectProject')" id="project_id">
                                <option value=""></option>
                                @foreach($projects as $project)
                                    <option
                                            value="{{ $project->id }}">{{ ucwords($project->project_name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-4">
                <h5 class="box-title m-t-30">@lang('modules.employees.employeeName')</h5>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <select class="select2 form-control" data-placeholder="@lang('modules.employees.employeeName')" id="employeeId">
                                <option value=""></option>
                                @foreach($employees as $employee)
                                    <option
                                            value="{{ $employee->id }}">{{ ucwords($employee->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-12">
                <button type="button" class="btn btn-success" id="filter-results"><i class="fa fa-check"></i> @lang('app.apply')
                </button>
            </div>
            {!! Form::close() !!}

        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="white-box">
                <div class="row row-in">
                    <div class="col-lg-4 col-sm-6 row-in-br">
                        <div class="col-in row">
                            <h3 class="box-title">@lang("modules.taskReport.taskToComplete")</h3>
                            <ul class="list-inline two-part">
                                <li><i class="ti-layout-list-thumb text-info"></i></li>
                                <li class="text-right"><span id="total-counter" class="counter">{{ $totalTasks }}</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 row-in-br  b-r-none">
                        <div class="col-in row">
                            <h3 class="box-title">@lang("modules.taskReport.completedTasks")</h3>
                            <ul class="list-inline two-part">
                                <li><i class="ti-check-box text-success"></i></li>
                                <li class="text-right"><span id="completed-counter" class="counter">{{ $completedTasks }}</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 b-0">
                        <div class="col-in row">
                            <h3 class="box-title">@lang("modules.taskReport.pendingTasks")</h3>
                            <ul class="list-inline two-part">
                                <li><i class="ti-alert text-warning"></i></li>
                                <li class="text-right"><span id="pending-counter" class="counter">{{ $pendingTasks }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    <!-- .row -->

    <div class="row">
        <div class="col-lg-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-sm-6">

                    </div>
                    <div class="col-sm-6 text-right hidden-xs">
                        <div class="form-group">
                            <a href="javascript:;" onclick="exportData()" class="btn btn-info btn-sm"><i class="ti-export" aria-hidden="true"></i> @lang('app.exportExcel')</a>
                        </div>
                    </div>
                </div>
                <h3 class="box-title">@lang("modules.taskReport.chartTitle")</h3>
                <div>
                    <canvas id="chart3" height="50"></canvas>
                </div>


                <div class="table-responsive">
                    <table class="table table-bordered table-hover toggle-circle default footable-loaded footable"
                           id="tasks-table">
                        <thead>
                        <tr>
                            <th>@lang('app.id')</th>
                            <th>@lang('app.project')</th>
                            <th>@lang('app.title')</th>
                            <th>@lang('modules.tasks.assignTo')</th>
                            <th>@lang('app.dueDate')</th>
                            <th>@lang('app.status')</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>

    </div>

@endsection

@push('footer-script')


<script src="{{ asset('plugins/bower_components/Chart.js/Chart.min.js') }}"></script>

<script src="{{ asset('plugins/bower_components/raphael/raphael-min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/morrisjs/morris.js') }}"></script>

<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

<script src="{{ asset('plugins/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('plugins/bower_components/waypoints/lib/jquery.waypoints.js') }}"></script>
<script src="{{ asset('plugins/bower_components/counterup/jquery.counterup.min.js') }}"></script>



<script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>

<script>

    $(".select2").select2({
        formatNoMatches: function () {
            return "{{ __('messages.noRecordFound') }}";
        }
    });
    initConter();

    jQuery('#date-range').datepicker({
        toggleActive: true,
        format: 'yyyy-mm-dd'
    });

    $('#filter-results').click(function () {
        var token = '{{ csrf_token() }}';
        var url = '{{ route('admin.task-report.store') }}';

        var startDate = $('#start-date').val();

        if (startDate == '') {
            startDate = null;
        }

        var endDate = $('#end-date').val();

        if (endDate == '') {
            endDate = null;
        }

        var projectID = $('#project_id').val();
        var employeeId = $('#employeeId').val();

        $.easyAjax({
            type: 'POST',
            url: url,
            data: {_token: token, startDate: startDate, endDate: endDate, projectId: projectID, employeeId: employeeId},
            success: function (response) {

                $('#completed-counter').html(response.completedTasks);
                $('#total-counter').html(response.totalTasks);
                $('#pending-counter').html(response.pendingTasks);

                pieChart(response.completedTasks, response.pendingTasks);
                initConter();
            }
        });
    })

    function initConter() {
        $(".counter").counterUp({
            delay: 100,
            time: 1200
        });
    }
</script>

<script>
    function pieChart(count1, count2) {
        var ctx3 = document.getElementById("chart3").getContext("2d");
        var data3 = [
            {
                value: parseInt(count1),
                color:"#00c292",
                highlight: "#57ecc8",
                label: "Completed Tasks"
            },
            {
                value: parseInt(count2),
                color: "#f1c411",
                highlight: "#f1d877",
                label: "Pending Tasks"
            }
        ];

        var myPieChart = new Chart(ctx3).Pie(data3,{
            segmentShowStroke : true,
            segmentStrokeColor : "#fff",
            segmentStrokeWidth : 0,
            animationSteps : 100,
            tooltipCornerRadius: 0,
            animationEasing : "easeOutBounce",
            animateRotate : true,
            animateScale : false,
            legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>",
            responsive: true
        });

        showTable();
    }

    pieChart('{{ $completedTasks }}', '{{ $pendingTasks }}');

    var table;

    function showTable() {

        var startDate = $('#start-date').val();

        if (startDate == '') {
            startDate = null;
        }

        var endDate = $('#end-date').val();

        if (endDate == '') {
            endDate = null;
        }

        var projectID = $('#project_id').val();
        if (!projectID) {
            projectID = 0;
        }

        var employeeId = $('#employeeId').val();
        if (!employeeId) {
            employeeId = 0;
        }
        var url = '{!!  route('admin.task-report.data', [':startDate', ':endDate', ':employeeId', ':projectId']) !!}';

        url = url.replace(':startDate', startDate);
        url = url.replace(':endDate', endDate);
        url = url.replace(':employeeId', employeeId);
        url = url.replace(':projectId', projectID);

        table = $('#tasks-table').dataTable({
            destroy: true,
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: url,
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
                {data: 'project_name', name: 'projects.project_name', width: '20%'},
                {data: 'heading', name: 'heading', width: '20%'},
                {data: 'name', name: 'users.name', width: '25%'},
                {data: 'due_date', name: 'due_date'},
                {data: 'column_name', name: 'taskboard_columns.column_name'}
            ]
        });
    }

    function exportData(){
        var startDate = $('#start-date').val();

        if (startDate == '') {
            startDate = 0;
        }

        var endDate = $('#end-date').val();

        if (endDate == '') {
            endDate = 0;
        }

        var projectID = $('#project_id').val();
        if (!projectID) {
            projectID = 0;
        }

        var employeeId = $('#employeeId').val();
        if (!employeeId) {
            employeeId = 0;
        }
        var url = '{!!  route('admin.task-report.export', [':startDate', ':endDate', ':employeeId', ':projectId']) !!}';

        url = url.replace(':startDate', startDate);
        url = url.replace(':endDate', endDate);
        url = url.replace(':employeeId', employeeId);
        url = url.replace(':projectId', projectID);

        window.location.href = url;
    }

</script>
@endpush