@foreach($boardColumns as $key=>$column)
    <div class="panel col-md-3 board-column p-0" data-column-id="{{ $column->id }}" >
        <div class="panel-heading p-t-5 p-b-5" style="background-color: {{ $column->label_color }}" >
            <div class="panel-title">
                <h6 class="text-white">{{ ucwords($column->column_name) }}

                    <div style="position: relative;" class=" pull-right">
                        <a href="javascript:;"  data-toggle="dropdown"  class="dropdown-toggle "><i class="ti-settings text-white font-normal"></i></a>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="javascript:;" data-column-id="{{ $column->id }}" class="add-task">@lang('modules.tasks.newTask')</a></li>
                            <li><a href="javascript:;" data-column-id="{{ $column->id }}" class="edit-column" >@lang('app.edit')</a>
                            </li>
                            @if($column->slug != 'completed' && $column->slug != 'incomplete')
                                <li><a href="javascript:;" data-column-id="{{ $column->id }}" class="delete-column"  >@lang('app.delete')</a></li>
                            @endif
                        </ul>

                    </div>
                </h6>
            </div>
        </div>
        <div class="panel-body" id="taskBox_{{ $column->id }}">
            <div class="row">
                <div class="col-xs-12">
                    @foreach($column->tasks as $task)
                        <div class="panel panel-default lobipanel view-task" data-task-id="{{ $task->id }}" id="sectionTask{{ $task->id }}" data-sortable="true">
                            <div class="panel-body">
                                <div class="p-10 font-12">{{ ucfirst($task->heading) }}</div>
                              
                                <div class="b-t p-t-10 p-b-10 p-10">
                                    {!!  ($task->user->image) ? '<img src="'.asset('user-uploads/avatar/'.$task->user->image).'" 
                                                            alt="user" class="img-circle" width="30">' : '<img src="'.asset('default-profile-2.png').'" 
                                                            alt="user" class="img-circle" width="30">' !!}
                                    <span>{{ ucwords($task->user->name) }}</span>
                                </div>
                                <div class="bg-grey p-10">
                                    <span><i class="icon-calender"></i> {{ $task->due_date->format($global->date_format) }}</span>
                                    <span class="pull-right" data-toggle="tooltip" data-original-title="@lang('modules.tasks.comment')" data-placement="left" >
                                        <i class="ti-comment"></i> {{ count($task->comments) }}
                                    </span>

                                    @if(count($task->subtasks) > 0)
                                        <span class="pull-right m-r-5" data-toggle="tooltip" data-original-title="@lang('modules.tasks.subTask')" data-placement="left" >
                                            <i class="ti-check-box"></i> {{ count($task->completedSubtasks) }} / {{ count($task->subtasks) }}
                                        </span>
                                    @endif

                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="panel panel-default lobipanel"  data-sortable="true"></div>
                </div>
            </div>
        </div>
    </div>
@endforeach
<script>
    $(function () {
        @foreach($boardColumns as $key=>$column)
        $('#taskBox_{{ $column->id }}').slimScroll({
            height: '450px'
        });
        @endforeach


        $('.lobipanel').on('dragged.lobiPanel', function () {
            var $parent = $(this).parent(),
                $children = $parent.children();

            var boardColumnIds = [];
            var taskIds = [];
            var prioritys = [];

            $children.each(function (ind, el) {
//                console.log(el, $(el).index());
                boardColumnIds.push($(el).closest('.board-column').data('column-id'));
                taskIds.push($(el).data('task-id'));
                prioritys.push($(el).index());
            });

            // update values for all tasks
            $.easyAjax({
                url: '{{ route("admin.taskboard.updateIndex") }}',
                type: 'POST',
                data:{boardColumnIds: boardColumnIds, taskIds: taskIds, prioritys: prioritys,'_token':'{{ csrf_token() }}'},
                success: function (response) {
                }
            });

            $("body").tooltip({
                selector: '[data-toggle="tooltip"]'
            });

        }).lobiPanel({
            sortable: true,
            reload: false,
            editTitle: false,
            close: false,
            minimize: false,
            unpin: false,
            expand: false

        });


        $('.view-task').click(function () {
            $(".right-sidebar").slideDown(50).addClass("shw-rside");

            var id = $(this).data('task-id');
            console.log([id, 'hello', this.id]);
            var url = "{{ route('admin.all-tasks.show',':id') }}";
            url = url.replace(':id', id);

            $.easyAjax({
                type: 'GET',
                url: url,
                success: function (response) {
                    if (response.status == "success") {
                        $('#right-sidebar-content').html(response.view);
                    }
                }
            });
        })



        $('.add-task').click(function () {
            var id = $(this).data('column-id');
            var url = '{{ route('admin.all-tasks.ajaxCreate', ':id')}}';
            url = url.replace(':id', id);

            $('#modelHeading').html('Add Task');
            $.ajaxModal('#eventDetailModal', url);
        })


        $('.delete-column').click(function () {
            var id = $(this).data('column-id');
            var url = '{{ route('admin.taskboard.destroy', ':id')}}';
            url = url.replace(':id', id);

            swal({
                title: "Are you sure?",
                text: "You will not be able to recover the deleted column!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel please!",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm){
                if (isConfirm) {
                    $.easyAjax({
                        url: url,
                        type: 'POST',
                        data: { '_token': '{{ csrf_token() }}', '_method': 'DELETE'},
                        success: function (response) {
                            if(response.status == 'success'){
                                window.location.reload();
                            }
                        }
                    });

                }
            });

        })


        $('.edit-column').click(function () {
            var id = $(this).data('column-id');
            var url = '{{ route("admin.taskboard.edit", ':id') }}';
            url = url.replace(':id', id);

            $.easyAjax({
                url: url,
                type: "GET",
                success: function (response) {
                    $('#edit-column-form').html(response.view);
                    $(".colorpicker").asColorPicker();
                    $('#edit-column-form').show();
                }
            })
        })

    });
</script>