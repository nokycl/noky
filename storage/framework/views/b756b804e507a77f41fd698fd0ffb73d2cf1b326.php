<div class="panel panel-default">
    <div class="panel-heading "><i class="fa fa-stop-circle-o"></i> <?php echo app('translator')->getFromJson('modules.projects.activeTimers'); ?>
        <div class="panel-action">
            <a href="javascript:;" class="close" data-dismiss="modal"><i class="ti-close"></i></a>
        </div>
    </div>
    <div class="panel-wrapper collapse in">
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo app('translator')->getFromJson('modules.projects.whoWorking'); ?></th>
                        <th> <?php if($logTimeFor->log_time_for == 'task'): ?>
                                <?php echo app('translator')->getFromJson('app.task'); ?>
                            <?php else: ?>
                                <?php echo app('translator')->getFromJson('app.project'); ?>
                            <?php endif; ?>
                            <?php echo app('translator')->getFromJson('app.name'); ?></th>

                        <th><?php echo app('translator')->getFromJson('modules.employees.memo'); ?></th>
                        <th><?php echo app('translator')->getFromJson('modules.projects.activeSince'); ?></th>
                        <td> </td>
                    </tr>
                    </thead>
                    <tbody id="active-timer-list">
                    <?php $__empty_1 = true; $__currentLoopData = $activeTimers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$time): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($key+1); ?></td>
                            <td><?php echo e(ucwords($time->name)); ?></td>
                            <td><?php echo e(ucwords($time->project_name)); ?></td>
                            <td class="font-bold "><?php echo e(ucwords(substr($time->memo, 0, 50))); ?></td>
                            <td class="font-bold "><i class="ti-alarm-clock"></i> <span class="timer"><?php echo e($time->timer); ?></span></td>
                            <td><a href="javascript:;" data-time-id="<?php echo e($time->id); ?>" class="label label-danger stop-active-timer"><?php echo app('translator')->getFromJson('app.stop'); ?></a></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="3"><?php echo app('translator')->getFromJson('messages.noActiveTimer'); ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function(e) {
            function updateTimer($worked) {
                var myTime = $worked.html();
                var ss = myTime.split(":");
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

                $worked.html(ts);
            }
            $timers = $(".timer");
            $timers.each(function ($key, $timer) {
                setInterval(function() {
                    updateTimer($($timer))
                }, 1000);
            });

        $('#active-timer-list').on('click', '.stop-active-timer', function () {
            var id = $(this).data('time-id');
            var url = '<?php echo e(route('admin.all-time-logs.stopTimer', ':id')); ?>';
            url = url.replace(':id', id);
            var token = '<?php echo e(csrf_token()); ?>';
            $.easyAjax({
                url: url,
                type: "POST",
                data: {timeId: id, _token: token},
                success: function (data) {
                    $('#active-timer-list').html(data.html);
                    $('#activeCurrentTimerCount').html(data.activeTimers);
                }
            })

        });
    });

</script>
<?php /**PATH /var/www/html/resources/views/admin/time-logs/show-active-timer.blade.php ENDPATH**/ ?>