<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title"><i class="fa fa-flag"></i> <?php echo app('translator')->getFromJson('app.update'); ?> <?php echo app('translator')->getFromJson('modules.projects.milestones'); ?></h4>
</div>
<div class="modal-body">
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-12">
                <?php echo Form::open(['id'=>'updateTime','class'=>'ajax-form','method'=>'PUT']); ?>

                <div class="form-body">
                        <div class="row">
                                <div class="col-md-12">

                                    <?php echo Form::hidden('project_id', $milestone->project_id); ?>


                                    <div class="form-body">
                                        <div class="row m-t-30">
                                            
                                            <div class="col-md-6 ">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->getFromJson('modules.projects.milestoneTitle'); ?></label>
                                                    <input id="milestone_title" name="milestone_title" type="text"
                                                class="form-control" value="<?php echo e($milestone->milestone_title); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4 ">
                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->getFromJson('app.status'); ?></label>
                                                        <select name="status" id="status" class="form-control">
                                                            <option 
                                                            <?php if($milestone->status == 'incomplete'): ?> selected <?php endif; ?>
                                                            value="incomplete"><?php echo app('translator')->getFromJson('app.incomplete'); ?></option>
                                                            <option 
                                                            <?php if($milestone->status == 'complete'): ?> selected <?php endif; ?>
                                                            value="complete"><?php echo app('translator')->getFromJson('app.complete'); ?></option>
                                                        </select>
                                                    </div>
                                            </div>
                                            <div class="col-md-3 ">
                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->getFromJson('modules.invoices.currency'); ?></label>
                                                        <select name="currency_id" id="currency_id" class="form-control">
                                                            <option value="">--</option>
                                                            <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option 
                                                                <?php if($item->id == $milestone->currency_id): ?> selected <?php endif; ?>
                                                                value="<?php echo e($item->id); ?>"><?php echo e($item->currency_code.' ('.$item->currency_symbol.')'); ?></option>           
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                            </div>
                                            <div class="col-md-3 ">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->getFromJson('modules.projects.milestoneCost'); ?></label>
                                                    <input id="cost" name="cost" type="number" value="<?php echo e($milestone->cost); ?>"
                                                           class="form-control" value="0" min="0" step=".01">
                                                </div>
                                            </div>
                                            
                                        </div>
                                        

                                        <div class="row m-t-20">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label for="memo"><?php echo app('translator')->getFromJson('modules.projects.milestoneSummary'); ?></label>
                                                    <textarea name="summary" id="" rows="4" class="form-control"><?php echo e($milestone->summary); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                

                                    <hr>
                                </div>
                            </div>
                </div>
                <div class="form-actions m-t-30">
                    <button type="button" id="update-form" class="btn btn-success"><i class="fa fa-check"></i> Save
                    </button>
                </div>
                <?php echo Form::close(); ?>


            </div>
        </div>

    </div>
</div>


<script>


    $('#update-form').click(function () {
        $.easyAjax({
            url: '<?php echo e(route('admin.milestones.update', $milestone->id)); ?>',
            container: '#updateTime',
            type: "POST",
            data: $('#updateTime').serialize(),
            success: function (response) {
                $('#editTimeLogModal').modal('hide');
                table._fnDraw();
            }
        })
    });
</script><?php /**PATH /var/www/html/resources/views/admin/projects/milestones/edit.blade.php ENDPATH**/ ?>