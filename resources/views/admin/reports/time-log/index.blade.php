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
                <li><a href="{{ route('admin.dashboard') }}">@lang("app.menu.home")</a></li>
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
@endpush

@section('content')



    <div class="white-box">
        <div class="row m-b-10">
            <h2>@lang("app.filterResults")</h2>
            {!! Form::open(['id'=>'storePayments','class'=>'ajax-form','method'=>'POST']) !!}
            <div class="col-md-5">
                <div class="example">
                    <h5 class="box-title m-t-30">@lang("app.selectDateRange")</h5>

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
                <h5 class="box-title m-t-30"> @if($logTimeFor->log_time_for == 'task')
                        @lang('app.selectTask')
                    @else
                        @lang('app.selectProject')
                    @endif
                </h5>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            @if($logTimeFor->log_time_for == 'task')
                                <select class="select2 form-control" data-placeholder="@lang('app.selectTask')" id="project_id">
                                    <option value=""></option>
                                    @foreach($tasks as $task)
                                        <option value="{{ $task->id }}">{{ ucwords($task->heading) }}</option>
                                    @endforeach

                                </select>
                            @else
                                <select class="select2 form-control" data-placeholder="@lang('app.selectProject')" id="project_id">
                                    <option value=""></option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}">{{ ucwords($project->project_name) }}</option>
                                    @endforeach
                                </select>
                            @endif

                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-12">
                <button type="button" class="btn btn-success" id="filter-results"><i class="fa fa-check"></i> @lang("app.apply")
                </button>
            </div>
            {!! Form::close() !!}

        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="white-box">
                <h3 class="box-title">@lang("modules.timeLogReport.chartTitle")</h3>
                <div id="morris-bar-chart"></div>
            </div>
        </div>

    </div>

@endsection

@push('footer-script')


<script src="{{ asset('plugins/bower_components/raphael/raphael-min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/morrisjs/morris.js') }}"></script>

<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

<script src="{{ asset('plugins/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

<script>

    $(".select2").select2({
        formatNoMatches: function () {
            return "{{ __('messages.noRecordFound') }}";
        }
    });

    jQuery('#date-range').datepicker({
        toggleActive: true,
        format: 'yyyy-mm-dd'
    });

    $('#filter-results').click(function () {
        var token = '{{ csrf_token() }}';
        var url = '{{ route('admin.time-log-report.store') }}';

        var startDate = $('#start-date').val();

        if (startDate == '') {
            startDate = null;
        }

        var endDate = $('#end-date').val();

        if (endDate == '') {
            endDate = null;
        }

        var projectID = $('#project_id').val();

        $.easyAjax({
            type: 'POST',
            url: url,
            data: {_token: token, startDate: startDate, endDate: endDate, projectId: projectID},
            success: function (response) {
                if(response.status == 'success'){
                    chartData = $.parseJSON(response.chartData);
                    $('#morris-bar-chart').html('');
                    barChart();
                }
            }
        });
    })

</script>

<script>
    var chartData = {!!  $chartData !!};
    function barChart() {

        Morris.Bar({
            element: 'morris-bar-chart',
            data: chartData,
            xkey: 'date',
            ykeys: ['total_hours'],
            labels: ['Hours Logged'],
            barColors:['#000000'],
            hideHover: 'auto',
            gridLineColor: '#ccccccc',
            resize: true
        });

    }

    @if($chartData != '[]')
    barChart();
    @endif

</script>
@endpush