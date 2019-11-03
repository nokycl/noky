<div id="event-detail">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="fa fa-flag"></i> <?php echo app('translator')->getFromJson('modules.projects.milestones'); ?> <?php echo app('translator')->getFromJson('app.details'); ?></h4>
        </div>
        <div class="modal-body">
            <?php echo Form::open(['id'=>'updateEvent','class'=>'ajax-form','method'=>'GET']); ?>

            <div class="form-body">
                <div class="row">
                    <div class="col-md-12 ">
                        <div class="form-group">
                            <label><?php echo app('translator')->getFromJson('modules.projects.milestoneTitle'); ?></label>
                            <p>
                                <?php echo e($milestone->milestone_title); ?>

                            </p>
                        </div>
                    </div>
    
                </div>
    
                <div class="row">
                    <div class="col-xs-12 ">
                        <div class="form-group">
                            <label><?php echo app('translator')->getFromJson('modules.projects.milestoneSummary'); ?></label>
                            <p><?php echo e($milestone->summary); ?></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php if(!is_null($milestone->currency_id)): ?>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('modules.projects.milestoneCost'); ?></label>
                                <p>
                                    <?php echo e($milestone->currency->currency_symbol.$milestone->cost); ?>


                                    <?php if($milestone->cost > 0 && $milestone->invoice_created == 0): ?>
                                        <a href="<?php echo e(route('admin.all-invoices.convert-milestone', $milestone->id)); ?>" class="btn btn-xs btn-info btn-rounded m-l-15"><?php echo app('translator')->getFromJson('app.create'); ?> <?php echo app('translator')->getFromJson('app.invoice'); ?></a>
                                    <?php elseif($milestone->cost > 0 && $milestone->invoice_created == 1): ?>
                                        <a href="<?php echo e(route('admin.all-invoices.show', $milestone->invoice_id)); ?>" class="btn btn-xs btn-info btn-rounded m-l-15"><?php echo app('translator')->getFromJson('app.view'); ?> <?php echo app('translator')->getFromJson('app.invoice'); ?></a>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>

                      
                                
                    <?php endif; ?>

                    <div class="col-xs-6 col-md-3">
                        <div class="form-group">
                            <label><?php echo app('translator')->getFromJson('app.status'); ?></label>
                            <p>
                                <?php if($milestone->status == 'incomplete'): ?> 
                                    <label class="label label-danger"><?php echo app('translator')->getFromJson('app.incomplete'); ?></label>
                                <?php else: ?>
                                    <label class="label label-success"><?php echo app('translator')->getFromJson('app.complete'); ?></label>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>

                    <div class="col-xs-12">
                            <h4><?php echo app('translator')->getFromJson('app.menu.tasks'); ?></h4>
                            <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo app('translator')->getFromJson('app.task'); ?></th>
                                            <th><?php echo app('translator')->getFromJson('modules.tasks.assignTo'); ?></th>
                                            <th><?php echo app('translator')->getFromJson('modules.tasks.assignBy'); ?></th>
                                            <th><?php echo app('translator')->getFromJson('app.dueDate'); ?></th>
                                            <th><?php echo app('translator')->getFromJson('app.status'); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__empty_1 = true; $__currentLoopData = $milestone->tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr>
                                                    <td><?php echo e(($key+1)); ?></td>
                                                    <td><?php echo e(ucfirst($item->heading)); ?></td>
                                                    <td><?php echo e(ucwords($item->user->name)); ?></td>
                                                    <td><?php echo e(ucwords($item->create_by->name)); ?></td>
                                                    <td><?php echo e($item->due_date->format($global->date_format)); ?></td>
                                                <td><label class="label" style="background-color: <?php echo e($item->board_column->label_color); ?>"><?php echo e($item->board_column->column_name); ?></label></td>
                                                </tr>
                                                    
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                    <td colspan="5"><?php echo app('translator')->getFromJson('messages.noRecordFound'); ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                    </div>
    
                </div>
            </div>
            <?php echo Form::close(); ?>

    
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
        </div>
    
    </div>
  <?php /**PATH /var/www/html/resources/views/admin/projects/milestones/detail.blade.php ENDPATH**/ ?>