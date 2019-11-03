<link rel="stylesheet" href="{{ asset('plugins/bower_components/summernote/dist/summernote.css') }}">

<div class="rpanel-title"> @lang('app.task') <span><i class="ti-close right-side-toggle"></i></span> </div>
<div class="r-panel-body">

    <div class="row">
        <div class="col-xs-12">
            <h3>{{ ucwords($task->heading) }}</h3>
        </div>
        <div class="col-xs-6">
            <label for="">@lang('modules.tasks.assignTo')</label><br>
            @if($task->user->image)
                <img src="{{ asset('user-uploads/avatar/'.$task->user->image) }}" class="img-circle" width="30" alt="">
            @else
                <img src="{{ asset('default-profile-2.png') }}" class="img-circle" width="30" alt="">
            @endif

            {{ ucwords($task->user->name) }}
        </div>
        <div class="col-xs-6">
            <label for="">@lang('app.dueDate')</label><br>
            <span @if($task->due_date->isPast()) class="text-danger" @endif>{{ $task->due_date->format($global->date_format) }}</span>
        </div>
        <div class="col-xs-12 task-description">
            {!! ucfirst($task->description) !!}
        </div>


        <div class="col-xs-12 m-t-20 m-b-10">
            <ul class="list-group" id="sub-task-list">
                @foreach($task->subtasks as $subtask)
                    <li class="list-group-item row">
                        <div class="col-xs-6">
                            <div class="checkbox checkbox-success checkbox-circle task-checkbox">
                                <input class="task-check" data-sub-task-id="{{ $subtask->id }}" id="checkbox{{ $subtask->id }}" type="checkbox"
                                       @if($subtask->status == 'complete') checked @endif>
                                <label for="checkbox{{ $subtask->id }}">&nbsp;</label>

                                <a href="#" class="text-muted edit-sub-task" data-name="title"  data-url="{{ route('admin.sub-task.update', $subtask->id) }}" data-pk="{{ $subtask->id }}" data-type="text" data-value="{{ ucfirst($subtask->title) }}"></a>
                            </div>
                        </div>
                            <div class="col-xs-5 text-right">
                                <a href="#"  data-type="combodate" data-name="due_date" data-url="{{ route('admin.sub-task.update', $subtask->id) }}"  data-emptytext="@lang('app.dueDate')" class="m-r-10 edit-sub-task-date"  data-format="YYYY-MM-DD" data-viewformat="DD/MM/YYYY" data-template="D / MMM / YYYY" data-value="@if($subtask->due_date){{ $subtask->due_date->format('Y-m-d') }}@endif" data-pk="{{ $subtask->id }}" data-title="@lang('app.dueDate')">@if($subtask->due_date){{ $subtask->due_date->format('d M, Y') }}@endif</a>
                            </div>
                        <div class="col-xs-1">
                            <a href="javascript:;" data-sub-task-id="{{ $subtask->id }}" class="btn btn-danger btn-xs delete-sub-task"><i class="fa fa-times"></i></a>
                        </div>
                    </li>
                @endforeach

            </ul>

            <div class="row b-all m-t-10 p-10"  id="new-sub-task" style="display: none">
                <div class="col-xs-11 ">
                    <a href="javascript:;" id="create-sub-task" data-name="title"  data-url="{{ route('admin.sub-task.store') }}" class="text-muted" data-type="text"></a>
                </div>

                <div class="col-xs-1 text-right">
                    <a href="javascript:;" id="cancel-sub-task" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></a>
                </div>
            </div>

        </div>

        <div class="col-xs-12 m-t-15">
            <h5>@lang('modules.tasks.comment')</h5>
        </div>

        <div class="col-xs-12" id="comment-container">
            <div id="comment-list">
                @forelse($task->comments as $comment)
                    <div class="row b-b m-b-5 font-12">
                        <div class="col-xs-8">
                            {{ ucfirst($comment->comment) }}<br>
                            @if($comment->user_id == $user->id)
                                <a href="javascript:;" data-comment-id="{{ $comment->id }}" class="text-danger delete-task-comment">@lang('app.delete')</a>
                            @endif
                        </div>
                        <div class="col-xs-4 text-right">
                            {{ ucfirst($comment->created_at->diffForHumans()) }}
                        </div>
                        <div class="col-xs-12 text-right m-t-5 m-b-5">
                            &mdash; <i>{{ ucwords($comment->user->name) }}</i>
                        </div>
                    </div>
                @empty
                    <div class="col-xs-12">
                        @lang('messages.noRecordFound')
                    </div>
                @endforelse
            </div>
        </div>

        <div class="form-group" id="comment-box">
            <div class="col-xs-12">
                <textarea name="comment" id="task-comment" class="summernote" placeholder="@lang('modules.tasks.comment')"></textarea>
            </div>
            <div class="col-xs-3">
                <a href="javascript:;" id="submit-comment" class="btn btn-success"><i class="fa fa-send"></i> @lang('app.submit')</a>
            </div>
        </div>

    </div>

</div>

<script src="{{ asset('plugins/bower_components/summernote/dist/summernote.min.js') }}"></script>

<script>
    $('.summernote').summernote({
        height: 100,                 // set editor height
        minHeight: null,             // set minimum height of editor
        maxHeight: null,             // set maximum height of editor
        focus: false,                 // set focus to editable area after initializing summernote,
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']]
        ]
    });

    //    change sub task status

    $('#submit-comment').click(function () {
        var comment = $('#task-comment').val();
        var token = '{{ csrf_token() }}';
        $.easyAjax({
            url: '{{ route("client.task-comment.store") }}',
            type: "POST",
            data: {'_token': token, comment: comment, taskId: '{{ $task->id }}'},
            success: function (response) {
                if (response.status == "success") {
                    $('#comment-list').html(response.view);
                    $('#task-comment').val('');
                }
            }
        })
    })

    $('body').on('click', '.delete-task-comment', function () {
        var commentId = $(this).data('comment-id');
        var token = '{{ csrf_token() }}';

        var url = '{{ route("client.task-comment.destroy", ':id') }}';
        url = url.replace(':id', commentId);

        $.easyAjax({
            url: url,
            type: "POST",
            data: {'_token': token, '_method': 'DELETE', commentId: commentId},
            success: function (response) {
                if (response.status == "success") {
                    $('#comment-list').html(response.view);
                }
            }
        })
    })


</script>