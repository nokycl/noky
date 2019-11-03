@if(isset($project))
    @foreach($project->tasks as $task)
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
                    <span class="@if($task->due_date->isPast()) text-danger @else text-success @endif m-r-10">{{ $task->due_date->format('d M') }}</span>
                    {!! ($task->user->image) ? '<img data-toggle="tooltip" data-original-title="' . ucwords($task->user->name) . '" src="' . asset('user-uploads/avatar/' . $task->user->image) . '"
                            alt="user" class="img-circle" height="35"> ' : '<img data-toggle="tooltip" data-original-title="' . ucwords($task->user->name) . '" src="' . asset('default-profile-2.png') . '"
                            alt="user" class="img-circle" height="35"> ' !!}
                </div>
            </div>
        </li>
    @endforeach
@else
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
                <span class="@if($task->due_date->isPast()) text-danger @else text-success @endif m-r-10">{{ $task->due_date->format('d M') }}</span>
                {!! ($task->user->image) ? '<img data-toggle="tooltip" data-original-title="' . ucwords($task->user->name) . '" src="' . asset('user-uploads/avatar/' . $task->user->image) . '"
                        alt="user" class="img-circle" height="35"> ' : '<img data-toggle="tooltip" data-original-title="' . ucwords($task->user->name) . '" src="' . asset('default-profile-2.png') . '"
                        alt="user" class="img-circle" height="35"> ' !!}
            </div>
        </div>
    </li>
@endif
