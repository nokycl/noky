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
                <li><a href="{{ route('admin.projects.index') }}">{{ __($pageTitle) }}</a></li>
                <li class="active">@lang('app.addNew')</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css') }}">
    <link href="//cdn.dhtmlx.com/gantt/edge/skins/dhtmlxgantt_broadway.css" rel="stylesheet">
@endpush

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h2>@lang('modules.projects.viewGanttChart')</h2>
            <div id="gantt_here" style='width:100%; height:100vh;'></div>
        </div>
    </div>    <!-- .row -->

@endsection

@push('footer-script')
    <script src="//cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.js"></script>
    <script src="//cdn.dhtmlx.com/gantt/edge/locale/locale_{{ $global->locale }}.js"></script>
    <script type="text/javascript">

        gantt.config.xml_date = "%Y-%m-%d %H:%i:%s";

        gantt.templates.task_class = function (st, end, item) {
            return item.$level == 0 ? "gantt_project" : ""
        };

        gantt.config.scale_unit = "month";
        gantt.config.date_scale = "%F, %Y";

        gantt.config.scale_height = 50;

        gantt.config.subscales = [
            {unit: "day", step: 1, date: "%j, %D"}
        ];

        //defines the text inside the tak bars
        gantt.templates.task_text = function (start, end, task) {
            if ( task.$level > 0 ){
                return task.text + ", <b> @lang('modules.tasks.assignTo'):</b> " + task.users;
            }
            return task.text;

        };

        gantt.attachEvent("onTaskCreated", function(task){
            //any custom logic here
            return false;
        });

        gantt.attachEvent("onBeforeLightbox", function(id) {
            var task = gantt.getTask(id);
            if ( task.$level > 0 ){
                $(".right-sidebar").slideDown(50).addClass("shw-rside");

                var taskId = task.id;
                var url = "{{ route('admin.all-tasks.show',':id') }}";
                url = url.replace(':id', taskId);

                $.easyAjax({
                    type: 'GET',
                    url: url,
                    success: function (response) {
                        if (response.status == "success") {
                            $('#right-sidebar-content').html(response.view);
                        }
                    }
                });
            }
            return false;
        });

        gantt.attachEvent("onBeforeTaskDrag", function(id, mode, e){
            //any custom logic here
            return false;
        });

        gantt.init("gantt_here");

        gantt.load('{{ route("admin.projects.ganttData") }}');
    </script>
@endpush

