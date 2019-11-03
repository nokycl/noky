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
            <li><a href="{{ route('admin.all-tasks.index') }}">{{ __($pageTitle) }}</a></li>
            <li class="active">@lang('app.edit')</li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
@endsection
 @push('head-script')
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/summernote/dist/summernote.css') }}">
<style>
    .panel-black .panel-heading a,
    .panel-inverse .panel-heading a {
        color: unset!important;
    }
</style>

@endpush 
@section('content')

<div class="row">
    <div class="col-md-8">

        <div class="panel panel-inverse">
            <div class="panel-heading"> @lang('modules.tasks.updateTask')</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    {!! Form::open(['id'=>'updateTask','class'=>'ajax-form','method'=>'PUT']) !!}

                    <div class="form-body">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">@lang('app.project')</label>
                                    <select class="select2 form-control" data-placeholder="@lang('app.selectProject')" id="project_id" name="project_id">
                                            <option value=""></option>
                                            @foreach($projects as $project)
                                                <option
                                                        @if($project->id == $task->project_id) selected @endif
                                                        value="{{ $project->id }}">{{ ucwords($project->project_name) }}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="form-group">
                                    <label class="control-label">@lang('modules.tasks.taskCategory') <a
                                                        href="javascript:;" id="createTaskCategory"
                                                        class="btn btn-sm btn-outline btn-success"><i
                                                            class="fa fa-plus"></i> @lang('modules.taskCategory.addTaskCategory')</a>
                                            </label>
                                    <select class="selectpicker form-control" name="category_id" id="category_id" data-style="form-control">
                                                @forelse($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                            @if($task->task_category_id == $category->id)
                                                            selected
                                                            @endif
                                                    >{{ ucwords($category->category_name) }}</option>
                                                @empty
                                                    <option value="">@lang('messages.noTaskCategoryAdded')</option>
                                                @endforelse
                                            </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">@lang('app.title')</label>
                                    <input type="text" id="heading" name="heading" class="form-control" value="{{ $task->heading }}">
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">@lang('app.description')</label>
                                    <textarea id="description" name="description" class="form-control summernote">{{ $task->description }}</textarea>
                                </div>
                            </div>
                            <!--/span-->

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">@lang('app.startDate')</label>
                                    <input type="text" name="start_date" id="start_date2" class="form-control" autocomplete="off" value="@if($task->start_date != '-0001-11-30 00:00:00' && $task->start_date != null) {{ $task->start_date->format('m/d/Y') }} @endif">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">@lang('app.dueDate')</label>
                                    <input type="text" name="due_date" id="due_date2" class="form-control" autocomplete="off" value="@if($task->due_date != '-0001-11-30 00:00:00') {{ $task->due_date->format('m/d/Y') }} @endif">
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">@lang('modules.tasks.assignTo')</label>
                                    <select class="select2 form-control" data-placeholder="@lang('modules.tasks.chooseAssignee')" name="user_id" id="user_id">
                                            @if(is_null($task->project_id))
                                                @foreach($employees as $employee)
                                                    <option @if($task->user_id == $employee->id) selected @endif
                                                    value="{{ $employee->id }}">{{ ucwords($employee->name) }}</option>
                                                @endforeach
                                            @else
                                                @foreach($task->project->members as $member)
                                                    <option @if($task->user_id == $member->user->id) selected @endif
                                                    value="{{ $member->user->id }}">{{ $member->user->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('app.status')</label>
                                    <select name="status" id="status" class="form-control">
                                        @foreach($taskBoardColumns as $taskBoardColumn)
                                            <option @if($task->board_column_id == $taskBoardColumn->id) selected @endif value="{{$taskBoardColumn->id}}">{{ $taskBoardColumn->column_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!--/span-->
                            <!--/span-->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">@lang('modules.tasks.priority')</label>

                                    <div class="radio radio-danger">
                                        <input type="radio" name="priority" id="radio13" @if($task->priority == 'high') checked
                                        @endif value="high">
                                        <label for="radio13" class="text-danger">
                                                @lang('modules.tasks.high') </label>
                                    </div>
                                    <div class="radio radio-warning">
                                        <input type="radio" name="priority" @if($task->priority == 'medium') checked @endif
                                        id="radio14" value="medium">
                                        <label for="radio14" class="text-warning">
                                                @lang('modules.tasks.medium') </label>
                                    </div>
                                    <div class="radio radio-success">
                                        <input type="radio" name="priority" id="radio15" @if($task->priority == 'low') checked
                                        @endif value="low">
                                        <label for="radio15" class="text-success">
                                                @lang('modules.tasks.low') </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--/row-->

                    </div>
                    <div class="form-actions">
                        <button type="button" id="update-task" class="btn btn-success"><i class="fa fa-check"></i> @lang('app.save')</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- .row -->

{{--Ajax Modal--}}
<div class="modal fade bs-modal-md in" id="taskCategoryModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
    <!-- /.modal-dialog -->.
</div>
{{--Ajax Modal Ends--}}
@endsection
 @push('footer-script')
<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/summernote/dist/summernote.min.js') }}"></script>

<script>
    //    update task
    $('#update-task').click(function () {

        var status = '{{ $task->board_column->slug }}';
        var currentStatus =  $('#status').val();

        if(status == 'incomplete' && currentStatus == 'completed'){

            $.easyAjax({
                url: '{{route('admin.tasks.checkTask', [$task->id])}}',
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
                                updateTask();
                            }
                        });
                    }
                    else{
                        updateTask();
                    }

                }
            });
        }
        else{
            updateTask();
        }

    });

    function updateTask(){
        $.easyAjax({
            url: '{{route('admin.all-tasks.update', [$task->id])}}',
            container: '#updateTask',
            type: "POST",
            data: $('#updateTask').serialize()
        })
    }

    jQuery('#due_date2, #start_date2').datepicker({
        autoclose: true,
        todayHighlight: true
    });

    $(".select2").select2({
        formatNoMatches: function () {
            return "{{ __('messages.noRecordFound') }}";
        }
    });

    $('.summernote').summernote({
        height: 200,                 // set editor height
        minHeight: null,             // set minimum height of editor
        maxHeight: null,             // set maximum height of editor
        focus: false                 // set focus to editable area after initializing summernote
    });

</script>
<script>
    $('#createTaskCategory').click(function(){
        var url = '{{ route('admin.taskCategory.create-cat')}}';
        $('#modelHeading').html("@lang('modules.taskCategory.manageTaskCategory')");
        $.ajaxModal('#taskCategoryModal', url);
    })

</script>

@endpush
