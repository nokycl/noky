<div class="panel panel-default">
    <div class="panel-heading "><i class="ti-plus"></i> @lang('modules.timeLogs.startTimer')
        <div class="panel-action">
            <a href="javascript:;" class="close" data-dismiss="modal"><i class="ti-close"></i></a>
        </div>
    </div>
    <div class="panel-wrapper collapse in">
        <div class="panel-body">
            {!! Form::open(['id'=>'startTimer','class'=>'ajax-form','method'=>'POST', 'onSubmit' => 'return false']) !!}
            @if((isset($tasks) && count($tasks) > 0) || (isset($projects) && count($projects) > 0) )
            <div class="form-body">
                <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">
                                @if($logTimeFor->log_time_for == 'task')
                                    @lang('modules.timeLogs.selectTask')
                                @else
                                    @lang('modules.timeLogs.selectProject')
                                @endif
                                </label>
                            @if($logTimeFor->log_time_for == 'task')
                                <select class="select2 form-control" name="project_id" data-placeholder="@lang('app.selectTask')" id="task_id">
                                    <option value=""></option>
                                    @foreach($tasks as $task)
                                        <option value="{{ $task->id }}">{{ ucwords($task->heading) }}</option>
                                    @endforeach

                                </select>
                            @else
                                <select class="form-control" name="project_id" id="project_id" >
                                    @forelse($projects as $project)
                                        @if(!is_null($project->project))
                                        <option value="{{ $project->project_id }}">{{ ucwords($project->project->project_name) }}</option>
                                        @endif
                                    @empty
                                        <option value="">@lang('messages.noProjectAssigned')</option>
                                    @endforelse
                                </select>
                            @endif

                        </div>
                    </div>
                    <!--/span-->

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">@lang('modules.timeLogs.memo')</label>
                            <input type="text" id="memo" name="memo" class="form-control">
                        </div>
                    </div>

                    <!--/span-->

                </div>
                <!--/row-->

            </div>
            <div class="form-actions">
                <button type="button" id="start-timer-btn" class="btn btn-success"><i class="fa fa-check"></i> @lang('modules.timeLogs.startTimer')</button>
            </div>
            {!! Form::close() !!}
            @else
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <p>
                                @if((isset($tasks) && count($tasks) == 0))
                                    @lang('modules.timeLogs.noProjectFound')
                                @endif
                                @if(isset($projects) && count($projects) == 0)
                                @lang('modules.timeLogs.noTaskFound')
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>

    function updateTimer() {
        var $worked = $("#active-timer");
        var myTime = $worked.html();
        var ss = myTime.split(":");
//            console.log(ss);

        var hours = ss[0];
        var mins = ss[1];
        var secs = ss[2];
        secs = parseInt(secs)+1;

        if(secs > 59){
            secs = '00';
            mins = parseInt(mins)+1;
        }

        if(mins > 59){
            secs = '00';
            mins = '00';
            hours = parseInt(hours)+1;
        }

        if(hours.toString().length < 2) {
            hours = '0'+hours;
        }
        if(mins.toString().length < 2) {
            mins = '0'+mins;
        }
        if(secs.toString().length < 2) {
            secs = '0'+secs;
        }
        var ts = hours+':'+mins+':'+secs;

//            var dt = new Date();
//            dt.setHours(ss[0]);
//            dt.setMinutes(ss[1]);
//            dt.setSeconds(ss[2]);
//            var dt2 = new Date(dt.valueOf() + 1000);
//            var ts = dt2.toTimeString().split(" ")[0];
        $worked.html(ts);
        setTimeout(updateTimer, 1000);
    }

    //    save new task
    $('#start-timer-btn').click(function () {
        $.easyAjax({
            url: '{{route('member.time-log.store')}}',
            container: '#startTimer',
            type: "POST",
            data: $('#startTimer').serialize(),
            success: function (data) {
                $('#timer-section').html(data.html);
                $('#projectTimerModal').modal('hide');
                $('#projectTimerModal .modal-body').html('Loading...');
                updateTimer();
                var activeTimerCountContent = $('#activeCurrentTimerCount');
                activeTimerCountContent.html(parseInt(activeTimerCountContent.html())+1);
            }
        })
    });

</script>
