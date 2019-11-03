<link rel="stylesheet" href="{{ asset('plugins/bower_components/summernote/dist/summernote.css') }}">

<div class="panel panel-default">
    <div class="panel-heading "><i class="ti-pencil"></i> @lang('modules.templateTasks.updateTask')
        <div class="panel-action">
            <a href="javascript:;" class="close" id="hide-edit-task-panel" data-dismiss="modal"><i class="ti-close"></i></a>
        </div>
    </div>
    <div class="panel-wrapper collapse in">
        <div class="panel-body">
            {!! Form::open(['id'=>'updateTask','class'=>'ajax-form','method'=>'PUT']) !!}
            {!! Form::hidden('project_id', $task->project_id) !!}

            <div class="form-body">
                <div class="row">
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
                            <label class="control-label">@lang('modules.templateTasks.assignTo')</label>
                            <select class="form-control" name="user_id" id="user_id" >
                                @foreach($task->projectTemplate->members as $member)
                                    <option @if($task->user_id == $member->user->id) selected @endif
                                    value="{{ $member->user->id }}">{{ $member->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">@lang('modules.templateTasks.priority')</label>

                            <div class="radio radio-danger">
                                <input type="radio" name="priority" id="radio13"
                                       @if($task->priority == 'high') checked @endif
                                       value="high">
                                <label for="radio13" class="text-danger">
                                    @lang('modules.templateTasks.high') </label>
                            </div>
                            <div class="radio radio-warning">
                                <input type="radio" name="priority"
                                       @if($task->priority == 'medium') checked @endif
                                       id="radio14" value="medium">
                                <label for="radio14" class="text-warning">
                                    @lang('modules.templateTasks.medium') </label>
                            </div>
                            <div class="radio radio-success">
                                <input type="radio" name="priority" id="radio15"
                                       @if($task->priority == 'low') checked @endif
                                       value="low">
                                <label for="radio15" class="text-success">
                                    @lang('modules.templateTasks.low') </label>
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

<script src="{{ asset('plugins/bower_components/summernote/dist/summernote.min.js') }}"></script>
<script>
    //    update task

    //    update task
    $('#update-task').click(function () {
        updateTask();
    });

    function updateTask(){
        $.easyAjax({
            url: '{{route('member.project-template-task.update', [$task->id])}}',
            container: '#updateTask',
            type: "POST",
            data: $('#updateTask').serialize(),
            success: function (data) {
                $('#task-list-panel ul.list-group').html(data.html);
            }
        })
    }

    $('.summernote').summernote({
        height: 100,                 // set editor height
        minHeight: null,             // set minimum height of editor
        maxHeight: null,             // set maximum height of editor
        focus: false                 // set focus to editable area after initializing summernote
    });
</script>
