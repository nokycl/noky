
<?php $__currentLoopData = $dateWiseData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $dateData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $currentDate = \Carbon\Carbon::parse($key);
    ?>
    <?php if($dateData['attendance']): ?>

        <tr>
            <td>
                <?php echo e($currentDate->format($global->date_format)); ?>

                <br>
                <label class="label label-success"><?php echo e($currentDate->format('l')); ?></label>
            </td>
            <td><label class="label label-success"><?php echo app('translator')->getFromJson('modules.attendance.present'); ?></label></td>
            <td colspan="3">
                <table width="100%" >
                    <?php $__currentLoopData = $dateData['attendance']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td width="25%" class="al-center bt-border">
                                <?php echo e($attendance->clock_in_time->timezone($global->timezone)->format($global->time_format)); ?>

                            </td>
                            <td width="25%" class="al-center bt-border">
                                <?php if(!is_null($attendance->clock_out_time)): ?> <?php echo e($attendance->clock_out_time->timezone($global->timezone)->format($global->time_format)); ?> <?php else: ?> - <?php endif; ?>
                            </td>
                            <td class="bt-border" style="padding-bottom: 5px;">
                                <strong><?php echo app('translator')->getFromJson('modules.attendance.clock_in'); ?> IP: </strong> <?php echo e($attendance->clock_in_ip); ?><br>
                                <strong><?php echo app('translator')->getFromJson('modules.attendance.clock_out'); ?> IP: </strong> <?php echo e($attendance->clock_out_ip); ?><br>
                                <strong><?php echo app('translator')->getFromJson('modules.attendance.working_from'); ?>: </strong> <?php echo e($attendance->working_from); ?><br>
                                <a href="javascript:;" data-attendance-id="<?php echo e($attendance->aId); ?>" class="delete-attendance btn btn-outline btn-danger btn-xs m-t-5"><i class="fa fa-times"></i> <?php echo app('translator')->getFromJson('app.delete'); ?></a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </table>
            </td>

        </tr>
    <?php else: ?>
        <tr>
            <td>
                <?php echo e($currentDate->format($global->date_format)); ?>

                 <br>
                <label class="label label-success"><?php echo e($currentDate->format('l')); ?></label>
            </td>
            <td>
                <?php if(!$dateData['holiday'] && !$dateData['leave']): ?>
                    <label class="label label-info"><?php echo app('translator')->getFromJson('modules.attendance.absent'); ?></label>
                <?php elseif($dateData['leave']): ?>
                    <label class="label label-primary"><?php echo app('translator')->getFromJson('modules.attendance.leave'); ?></label>
                <?php else: ?>
                    <label class="label label-megna"><?php echo app('translator')->getFromJson('modules.attendance.holiday'); ?></label>
                <?php endif; ?>
            </td>
            <td colspan="3">
                <table width="100%">
                    <tr>
                        <td width="25%" class="al-center">-</td>
                        <td width="25%" class="al-center">-</td>
                        <td style="padding-bottom: 5px;text-align: left;">
                            <?php if($dateData['holiday']  && !$dateData['leave']): ?>
                                <?php echo app('translator')->getFromJson('modules.attendance.holidayfor'); ?> <?php echo e(ucwords($dateData['holiday']->occassion)); ?>

                            <?php elseif($dateData['leave']): ?>
                                <?php echo app('translator')->getFromJson('modules.attendance.leaveFor'); ?> <?php echo e(ucwords($dateData['leave']['reason'])); ?>

                            <?php else: ?>
                                -
                            <?php endif; ?>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php /**PATH /var/www/html/resources/views/admin/attendance/user_attendance.blade.php ENDPATH**/ ?>