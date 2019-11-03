<div class="col-lg-12 col-sm-12 col-xs-12">
    <div class="white-box">
        <div class="vtabs">
            <ul class="nav tabs-vertical">
                <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="tab nav-item <?php if($month == $currentMonth): ?> active <?php endif; ?>">
                        <a data-toggle="tab" href="#<?php echo e($month); ?>" class="nav-link " aria-expanded="<?php if($month == $currentMonth): ?> true <?php else: ?> false <?php endif; ?> ">
                            <i class="fa fa-calendar"></i> <?php echo app('translator')->getFromJson('app.'.strtolower($month)); ?></a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <div class="tab-content" style="padding-top: 0;">
                <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div id="<?php echo e($month); ?>" class="tab-pane <?php if($month == $currentMonth): ?> active <?php endif; ?>">
                        <div class="panel panel-info block4">
                            <div class="panel-heading">
                                <div class="caption">
                                    <i class="fa fa-calendar"> </i> <?php echo app('translator')->getFromJson('app.'.strtolower($month)); ?>
                                </div>

                            </div>
                            <div class="portlet-body">
                                <div class="table-scrollable">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th> # </th>
                                            <th> <?php echo app('translator')->getFromJson('app.date'); ?> </th>
                                            <th> <?php echo app('translator')->getFromJson('modules.holiday.occasion'); ?> </th>
                                            <th> <?php echo app('translator')->getFromJson('app.day'); ?> </th>
                                            <th> <?php echo app('translator')->getFromJson('app.action'); ?> </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(isset($holidaysArray[$month])): ?>

                                            <?php for($i=0;$i<count($holidaysArray[$month]['date']);$i++): ?>

                                                <tr id="row<?php echo e($holidaysArray[$month]['id'][$i]); ?>">
                                                    <td> <?php echo e(($i+1)); ?> </td>
                                                    <td> <?php echo e($holidaysArray[$month]['date'][$i]); ?> </td>
                                                    <td> <?php echo e($holidaysArray[$month]['ocassion'][$i]); ?> </td>
                                                    <td> <?php echo e($holidaysArray[$month]['day'][$i]); ?> </td>
                                                    <td>
                                                        <button type="button" onclick="del('<?php echo e($holidaysArray[$month]['id'][$i]); ?>',' <?php echo e($holidaysArray[$month]['date'][$i]); ?>')" href="#" class="btn btn-xs btn-danger">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endfor; ?>
                                        <?php endif; ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div><?php /**PATH /var/www/html/resources/views/admin/holidays/holiday-view.blade.php ENDPATH**/ ?>