@extends('layouts.member-app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }} #{{ $project->id }} - <span class="font-bold">{{ ucwords($project->project_name) }}</span></h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-6 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ route('member.dashboard') }}">@lang('app.menu.home')</a></li>
                <li><a href="{{ route('member.projects.index') }}">{{ __($pageTitle) }}</a></li>
                <li class="active">@lang('app.menu.tasks')</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
<link rel="stylesheet" href="{{ asset('plugins/bower_components/icheck/skins/all.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/multiselect/css/multi-select.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/summernote/dist/summernote.css') }}">

@endpush

@section('content')

    <div class="row">
        <div class="col-md-12">

            <section>
                <div class="sttabs tabs-style-line">
                    <div class="white-box">

                        <nav>
                            <ul>
                                <li><a href="{{ route('member.projects.show', $project->id) }}"><span>@lang('modules.projects.overview')</span></a></li>
                                @if(in_array('employees',$modules))
                                <li><a href="{{ route('member.project-members.show', $project->id) }}"><span>@lang('modules.projects.members')</span></a></li>
                                @endif

                                @if(in_array('tasks',$modules))
                                <li class="tab-current"><a href="{{ route('member.tasks.show', $project->id) }}"><span>@lang('app.menu.tasks')</span></a></li>
                                @endif

                                <li><a href="{{ route('member.files.show', $project->id) }}"><span>@lang('modules.projects.files')</span></a></li>
                                @if(in_array('timelogs',$modules))
                                <li><a href="{{ route('member.time-log.show-log', $project->id) }}"><span>@lang('app.menu.timeLogs')</span></a></li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                    <div class="content-wrap">
                        <section id="section-line-3" class="show">
                            <div class="row">
                                <div class="col-md-12" id="task-list-panel">
                                    <div class="white-box">
                                        <h2>@lang('app.menu.tasks')</h2>

                                        <div class="row m-b-10">
                                            @if($project->isProjectAdmin || $user->can('add_projects'))
                                                <div class="col-md-5">
                                                    <a href="javascript:;" id="show-new-task-panel"
                                                       class="btn btn-success btn-outline"><i class="fa fa-plus"></i> @lang('modules.tasks.newTask')</a>
                                                </div>
                                            @endif
                                            <div class="col-md-3 ">
                                                <div class="checkbox checkbox-info">
                                                    <input type="checkbox" id="hide-completed-tasks">
                                                    <label for="hide-completed-tasks">@lang('app.hideCompletedTasks')</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <select class="selectpicker" data-style="form-control" id="sort-task" data-project-id="{{ $project->id }}">
                                                    <option value="id">@lang('modules.tasks.lastCreated')</option>
                                                    <option value="due_date">@lang('modules.tasks.dueSoon')</option>
                                                </select>
                                            </div>
                                        </div>

                                        <ul class="list-group">
                                            @foreach($tasks as $task)
                                                <li class="list-group-item @if($task->board_column->slug == 'completed') task-completed @endif">
                                                    <div class="row">
                                                        <div class="checkbox checkbox-success checkbox-circle task-checkbox col-md-10">
                                                            <input class="task-check" data-task-id="{{ $task->id }}" id="checkbox{{ $task->id }}" type="checkbox"
                                                                   @if($task->board_column->slug == 'completed') checked @endif>
                                                            <label for="checkbox{{ $task->id }}">&nbsp;</label>
                                                            <a href="javascript:;" class="text-muted edit-task"
                                                               data-task-id="{{ $task->id }}">{{ ucfirst($task->heading) }}</a>
                                                        </div>
                                                        <div class="col-md-2 text-right">
                                                            <span class="@if($task->due_date->isPast()) text-danger @else text-success @endif m-r-10">{{ $task->due_date->format($global->date_format) }}</span>
                                                            {!! ($task->user->image) ? '<img data-toggle="tooltip" data-original-title="' . ucwords($task->user->name) . '" src="' . asset('user-uploads/avatar/' . $task->user->image) . '"
                        alt="user" class="img-circle" height="35"> ' : '<img data-toggle="tooltip" data-original-title="' . ucwords($task->user->name) . '" src="' . asset('default-profile-2.png') . '"
                        alt="user" class="img-circle" height="35"> ' !!}
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-6 hide" id="new-task-panel">
                                    <div class="panel panel-default">
                                        <div class="panel-heading "><i class="ti-plus"></i> New Task
                                            <div class="panel-action">
                                                <a href="javascript:;" id="hide-new-task-panel"><i class="ti-close"></i></a>
                                            </div>
                                        </div>
                                        <div class="panel-wrapper collapse in">
                                            <div class="panel-body">
                                                {!! Form::open(['id'=>'createTask','class'=>'ajax-form','method'=>'POST']) !!}

                                                {!! Form::hidden('project_id', $project->id) !!}

                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label">@lang('app.title')</label>
                                                                <input type="text" id="heading" name="heading"
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label">@lang('app.description')</label>
                                                                <textarea id="description" name="description"
                                                                          class="form-control summernote"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label">@lang('app.startDate')</label>
                                                                <input type="text" name="start_date" id="start_date2" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label">@lang('app.dueDate')</label>
                                                                <input type="text" name="due_date" id="due_date"
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                        <div class="col-md-12">
                                                            <label class="control-label">@lang('modules.tasks.assignTo')</label>
                                                            <div class="form-group">
                                                                <select class="selectpicker" name="user_id" id="user_id"
                                                                        data-style="form-control">
                                                                    <option value="">@lang('modules.tasks.chooseAssignee')</option>
                                                                    @forelse($project->members as $member)
                                                                        <option value="{{ $member->user->id }}">{{ $member->user->name }}</option>
                                                                    @empty
                                                                        <option value="">Add project member</option>
                                                                    @endforelse
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label">@lang('modules.tasks.taskCategory') </label>
                                                                <select class="selectpicker form-control" name="category_id" id="category_id"
                                                                        data-style="form-control">
                                                                    @forelse($categories as $category)
                                                                        <option value="{{ $category->id }}">{{ ucwords($category->category_name) }}</option>
                                                                    @empty
                                                                        <option value="">@lang('messages.noTaskCategoryAdded')</option>
                                                                    @endforelse
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label">@lang('modules.tasks.priority')</label>

                                                                <div class="radio radio-danger">
                                                                    <input type="radio" name="priority" id="radio13"
                                                                           value="high">
                                                                    <label for="radio13" class="text-danger">
                                                                        @lang('modules.tasks.high') </label>
                                                                </div>
                                                                <div class="radio radio-warning">
                                                                    <input type="radio" name="priority" checked
                                                                           id="radio14" value="medium">
                                                                    <label for="radio14" class="text-warning">
                                                                        @lang('modules.tasks.medium') </label>
                                                                </div>
                                                                <div class="radio radio-success">
                                                                    <input type="radio" name="priority" id="radio15"
                                                                           value="low">
                                                                    <label for="radio15" class="text-success">
                                                                        @lang('modules.tasks.low') </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                    </div>
                                                    <!--/row-->

                                                </div>
                                                <div class="form-actions">
                                                    <button type="submit" id="save-task" class="btn btn-success"><i
                                                                class="fa fa-check"></i> @lang('app.save')
                                                    </button>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 hide" id="edit-task-panel">
                                </div>
                            </div>
                        </section>

                    </div><!-- /content -->
                </div><!-- /tabs -->
            </section>
        </div>


    </div>
    <!-- .row -->

@endsection

@push('footer-script')
<script src="{{ asset('js/cbpFWTabs.js') }}"></script>
<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>

<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/summernote/dist/summernote.min.js') }}"></script>

<script type="text/javascript">
    //    (function () {
    //
    //        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
    //            new CBPFWTabs(el);
    //        });
    //
    //    })();

    var newTaskpanel = $('#new-task-panel');
    var taskListPanel = $('#task-list-panel');
    var editTaskPanel = $('#edit-task-panel');

    $(".select2").select2({
        formatNoMatches: function () {
            return "{{ __('messages.noRecordFound') }}";
        }
    });

    //    save new task
    $('#save-task').click(function () {
        $.easyAjax({
            url: '{{route('member.tasks.store')}}',
            container: '#createTask',
            type: "POST",
            data: $('#createTask').serialize(),
            success: function (data) {
                $('#createTask').trigger("reset");
                $('.summernote').summernote('code', '');
                $('#task-list-panel ul.list-group').html(data.html);
                $("body").tooltip({
                    selector: '[data-toggle="tooltip"]'
                });
            }
        })
    });

    //    change task status
    taskListPanel.on('click', '.task-check', function () {
        if ($(this).is(':checked')) {
            var status = 'completed';
        }else{
            var status = 'incomplete';
        }

        var sortBy = $('#sort-task').val();

        var id = $(this).data('task-id');


        if(status == 'completed'){
            var checkUrl = '{{route('member.tasks.checkTask', ':id')}}';
            checkUrl = checkUrl.replace(':id', id);
            $.easyAjax({
                url: checkUrl,
                type: "GET",
                data: {},
                success: function (data) {
                    console.log(data.taskCount);
                    if(data.taskCount > 0){
                        swal({
                            title: "Are you sure?",
                            text: "There is a incomplete sub-task in this task do you want to mark complete!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Yes, complete it!",
                            cancelButtonText: "No, cancel please!",
                            closeOnConfirm: true,
                            closeOnCancel: true
                        }, function (isConfirm) {
                            if (isConfirm) {
                                updateTask(id,status,sortBy)
                            }
                        });
                    }
                    else{
                        updateTask(id,status,sortBy)
                    }

                }
            });
        }
        else{
            updateTask(id,status,sortBy)
        }
    });

    function updateTask(id,status,sortBy){
        var url = "{{route('member.tasks.changeStatus')}}";
        var token = "{{ csrf_token() }}";
        $.easyAjax({
            url: url,
            type: "POST",
            data: {'_token': token, taskId: id, status: status, sortBy: sortBy},
            success: function (data) {
                $('#task-list-panel ul.list-group').html(data.html);
            }
        })
    }

    //    save new task
    taskListPanel.on('click', '.edit-task', function () {
        var id = $(this).data('task-id');
        var url = "{{route('member.tasks.edit', ':id')}}";
        url = url.replace(':id', id);

        $.easyAjax({
            url: url,
            type: "GET",
            data: {taskId: id},
            success: function (data) {
                editTaskPanel.html(data.html);
                taskListPanel.switchClass("col-md-12", "col-md-6", 1000, "easeInOutQuad");
                newTaskpanel.addClass('hide').removeClass('show');
                editTaskPanel.switchClass("hide", "show", 300, "easeInOutQuad");
            }
        })
    });

    //    save new task
    $('#sort-task, #hide-completed-tasks').change(function() {
        var sortBy = $('#sort-task').val();
        var id = $('#sort-task').data('project-id');

        var url = "{{route('member.tasks.sort')}}";
        var token = "{{ csrf_token() }}";

        if ($('#hide-completed-tasks').is(':checked')) {
            var hideCompleted = '1';
        }else {
            var hideCompleted = '0';
        }

        $.easyAjax({
            url: url,
            type: "POST",
            data: {'_token': token, projectId: id, sortBy: sortBy, hideCompleted: hideCompleted},
            success: function (data) {
                $('#task-list-panel ul.list-group').html(data.html);
            }
        })
    });

    $('#show-new-task-panel').click(function () {
//    taskListPanel.switchClass('col-md-12', 'col-md-8', 1000, 'easeInOutQuad');
        taskListPanel.switchClass("col-md-12", "col-md-6", 1000, "easeInOutQuad");
        editTaskPanel.addClass('hide').removeClass('show');
        newTaskpanel.switchClass("hide", "show", 300, "easeInOutQuad");
    });

    $('#hide-new-task-panel').click(function () {
        newTaskpanel.addClass('hide').removeClass('show');
        taskListPanel.switchClass("col-md-6", "col-md-12", 1000, "easeInOutQuad");
    });



    editTaskPanel.on('click', '#hide-edit-task-panel', function () {
        editTaskPanel.addClass('hide').removeClass('show');
        taskListPanel.switchClass("col-md-6", "col-md-12", 1000, "easeInOutQuad");
    });

    jQuery('#due_date, #start_date2').datepicker({
        autoclose: true,
        todayHighlight: true
    })
    $('#description').summernote({
        height: 100,                 // set editor height
        minHeight: null,             // set minimum height of editor
        maxHeight: null,             // set maximum height of editor
        focus: false                 // set focus to editable area after initializing summernote
    });

</script>
@endpush
