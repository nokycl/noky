<?php $__env->startSection('page-title'); ?>
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="<?php echo e($pageIcon); ?>"></i> <?php echo e(__($pageTitle)); ?></h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo app('translator')->getFromJson('app.menu.home'); ?></a></li>
                <li><a href="<?php echo e(route('admin.all-tasks.index')); ?>"><?php echo e(__($pageTitle)); ?></a></li>
                <li class="active"><?php echo app('translator')->getFromJson('app.addNew'); ?></li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('head-script'); ?>
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/custom-select/custom-select.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/summernote/dist/summernote.css')); ?>">
<style>
    .panel-black .panel-heading a, .panel-inverse .panel-heading a {
        color: unset!important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-8">

            <div class="panel panel-inverse">
                <div class="panel-heading"> <?php echo app('translator')->getFromJson('modules.tasks.newTask'); ?></div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <?php echo Form::open(['id'=>'storeTask','class'=>'ajax-form','method'=>'POST']); ?>


                        <div class="form-body">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo app('translator')->getFromJson('app.project'); ?></label>
                                        <select class="select2 form-control" data-placeholder="<?php echo app('translator')->getFromJson("app.selectProject"); ?>" id="project_id" name="project_id">
                                            <option value=""></option>
                                            <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option
                                                value="<?php echo e($project->id); ?>"><?php echo e(ucwords($project->project_name)); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo app('translator')->getFromJson('modules.tasks.taskCategory'); ?> <a href="javascript:;"
                                                                                                                      id="createTaskCategory"
                                                                                                                      class="btn btn-sm btn-outline btn-success"><i
                                                            class="fa fa-plus"></i> <?php echo app('translator')->getFromJson('modules.taskCategory.addTaskCategory'); ?></a>
                                            </label>
                                            <select class="selectpicker form-control" name="category_id" id="category_id"
                                                    data-style="form-control">
                                                <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <option value="<?php echo e($category->id); ?>"><?php echo e(ucwords($category->category_name)); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <option value=""><?php echo app('translator')->getFromJson('messages.noTaskCategoryAdded'); ?></option>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo app('translator')->getFromJson('app.title'); ?></label>
                                        <input type="text" id="heading" name="heading" class="form-control" >
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo app('translator')->getFromJson('app.description'); ?></label>
                                        <textarea id="description" name="description" class="form-control summernote"></textarea>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo app('translator')->getFromJson('app.startDate'); ?></label>
                                        <input type="text" name="start_date" id="start_date2" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <!--/span-->
                                <!--/span-->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo app('translator')->getFromJson('app.dueDate'); ?></label>
                                        <input type="text" name="due_date"  id="due_date2" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo app('translator')->getFromJson('modules.tasks.assignTo'); ?></label>
                                        <select class="select2 form-control" name="user_id" id="user_id" >
                                            <option value=""><?php echo app('translator')->getFromJson('modules.tasks.chooseAssignee'); ?></option>
                                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($employee->id); ?>"><?php echo e(ucwords($employee->name)); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo app('translator')->getFromJson('modules.tasks.priority'); ?></label>

                                        <div class="radio radio-danger">
                                            <input type="radio" name="priority" id="radio13"
                                                   value="high">
                                            <label for="radio13" class="text-danger">
                                                <?php echo app('translator')->getFromJson('modules.tasks.high'); ?> </label>
                                        </div>
                                        <div class="radio radio-warning">
                                            <input type="radio" name="priority"
                                                   id="radio14" checked value="medium">
                                            <label for="radio14" class="text-warning">
                                                <?php echo app('translator')->getFromJson('modules.tasks.medium'); ?> </label>
                                        </div>
                                        <div class="radio radio-success">
                                            <input type="radio" name="priority" id="radio15"
                                                   value="low">
                                            <label for="radio15" class="text-success">
                                                <?php echo app('translator')->getFromJson('modules.tasks.low'); ?> </label>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->

                            </div>
                            <!--/row-->

                        </div>
                        <div class="form-actions">
                            <button type="button" id="store-task" class="btn btn-success"><i class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.save'); ?></button>
                        </div>
                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>    <!-- .row -->

    
    <div class="modal fade bs-modal-md in" id="taskCategoryModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
                </div>
                <div class="modal-body">
                    Loading...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn blue">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->.
    </div>
    

<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-script'); ?>
<script src="<?php echo e(asset('plugins/bower_components/custom-select/custom-select.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/summernote/dist/summernote.min.js')); ?>"></script>

<script>
    $('.summernote').summernote({
        height: 200,                 // set editor height
        minHeight: null,             // set minimum height of editor
        maxHeight: null,             // set maximum height of editor
        focus: false                 // set focus to editable area after initializing summernote
    });

    //    update task
    $('#store-task').click(function () {
        $.easyAjax({
            url: '<?php echo e(route('admin.all-tasks.store')); ?>',
            container: '#storeTask',
            type: "POST",
            data: $('#storeTask').serialize(),
            success: function (data) {
                $('#storeTask').trigger("reset");
                $('.summernote').summernote('code', '');
            }
        })
    });

    jQuery('#due_date2, #start_date2').datepicker({
        autoclose: true,
        todayHighlight: true
    });

    $(".select2").select2({
        formatNoMatches: function () {
            return "<?php echo e(__('messages.noRecordFound')); ?>";
        }
    });

    $('#project_id').change(function () {
        var id = $(this).val();
        var url = '<?php echo e(route('admin.all-tasks.members', ':id')); ?>';
        url = url.replace(':id', id);

        $.easyAjax({
            url: url,
            type: "GET",
            redirect: true,
            success: function (data) {
                $('#user_id').html(data.html);
            }
        })
    });

</script>
<script>
    $('#createTaskCategory').click(function(){
        var url = '<?php echo e(route('admin.taskCategory.create-cat')); ?>';
        $('#modelHeading').html("<?php echo app('translator')->getFromJson('modules.taskCategory.manageTaskCategory'); ?>");
        $.ajaxModal('#taskCategoryModal', url);
    })
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/tasks/create.blade.php ENDPATH**/ ?>