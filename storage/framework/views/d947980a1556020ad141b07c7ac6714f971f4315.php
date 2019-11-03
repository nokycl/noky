<?php if(isset($project)): ?>
    <?php $__currentLoopData = $project->tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="list-group-item <?php if($task->board_column->slug == 'completed'): ?> task-completed <?php endif; ?>">
            <div class="row">
                <div class="checkbox checkbox-success checkbox-circle task-checkbox col-md-10">
                    <input class="task-check" data-task-id="<?php echo e($task->id); ?>" id="checkbox<?php echo e($task->id); ?>" type="checkbox"
                           <?php if($task->board_column->slug == 'completed'): ?> checked <?php endif; ?>>
                    <label for="checkbox<?php echo e($task->id); ?>">&nbsp;</label>
                    <a href="javascript:;" class="text-muted edit-task"
                       data-task-id="<?php echo e($task->id); ?>"><?php echo e(ucfirst($task->heading)); ?></a>
                </div>
                <div class="col-md-2 text-right">
                    <span class="<?php if($task->due_date->isPast()): ?> text-danger <?php else: ?> text-success <?php endif; ?> m-r-10"><?php echo e($task->due_date->format('d M')); ?></span>
                    <?php echo ($task->user->image) ? '<img data-toggle="tooltip" data-original-title="' . ucwords($task->user->name) . '" src="' . asset('user-uploads/avatar/' . $task->user->image) . '"
                            alt="user" class="img-circle" height="35"> ' : '<img data-toggle="tooltip" data-original-title="' . ucwords($task->user->name) . '" src="' . asset('default-profile-2.png') . '"
                            alt="user" class="img-circle" height="35"> '; ?>

                </div>
            </div>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
    <li class="list-group-item <?php if($task->board_column->slug == 'completed'): ?> task-completed <?php endif; ?>">
        <div class="row">
            <div class="checkbox checkbox-success checkbox-circle task-checkbox col-md-10">
                <input class="task-check" data-task-id="<?php echo e($task->id); ?>" id="checkbox<?php echo e($task->id); ?>" type="checkbox"
                       <?php if($task->board_column->slug == 'completed'): ?> checked <?php endif; ?>>
                <label for="checkbox<?php echo e($task->id); ?>">&nbsp;</label>
                <a href="javascript:;" class="text-muted edit-task"
                   data-task-id="<?php echo e($task->id); ?>"><?php echo e(ucfirst($task->heading)); ?></a>
            </div>
            <div class="col-md-2 text-right">
                <span class="<?php if($task->due_date->isPast()): ?> text-danger <?php else: ?> text-success <?php endif; ?> m-r-10"><?php echo e($task->due_date->format('d M')); ?></span>
                <?php echo ($task->user->image) ? '<img data-toggle="tooltip" data-original-title="' . ucwords($task->user->name) . '" src="' . asset('user-uploads/avatar/' . $task->user->image) . '"
                        alt="user" class="img-circle" height="35"> ' : '<img data-toggle="tooltip" data-original-title="' . ucwords($task->user->name) . '" src="' . asset('default-profile-2.png') . '"
                        alt="user" class="img-circle" height="35"> '; ?>

            </div>
        </div>
    </li>
<?php endif; ?>
<?php /**PATH /var/www/html/resources/views/admin/projects/tasks/task-list-ajax.blade.php ENDPATH**/ ?>