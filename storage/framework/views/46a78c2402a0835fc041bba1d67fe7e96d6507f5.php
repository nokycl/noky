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
                <li><a href="<?php echo e(route('admin.projects.index')); ?>"><?php echo e(__($pageTitle)); ?></a></li>
                <li class="active"><?php echo app('translator')->getFromJson('app.addNew'); ?></li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('head-script'); ?>
<link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/summernote/dist/summernote.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/custom-select/custom-select.css')); ?>">
<style>
    .panel-black .panel-heading a, .panel-inverse .panel-heading a {
        color: unset!important;
    }
    .bootstrap-select.btn-group .dropdown-menu li a span.text {
        color: #000;
    }
    .panel-black .panel-heading a:hover, .panel-inverse .panel-heading a:hover {
        color: #000 !important;
    }
    .panel-black .panel-heading a, .panel-inverse .panel-heading a {
        color: #000 !important;
    }
    .btn-info.active, .btn-info:active, .open>.dropdown-toggle.btn-info {
        background-color:unset !important; ;
        border-color: #269abc;
    }
    .note-editor{
        border: 1px solid #e4e7ea !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-inverse">
                <div class="panel-heading"> <?php echo app('translator')->getFromJson('modules.projects.createTitle'); ?>
                    <div class="pull-right">
                        <div class="btn-group m-r-10">
                            <button aria-expanded="true" data-toggle="dropdown" class="btn btn-block btn-info waves-effect dropdown-toggle waves-light" type="button"><?php echo app('translator')->getFromJson('app.menu.template'); ?> <span class="caret"></span></button>
                            <ul role="menu" class="dropdown-menu">
                                <?php $__empty_1 = true; $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <li onclick="setTemplate('<?php echo e($template->id); ?>')" role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i> <?php echo e(ucwords($template->project_name)); ?></a></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <li class="text-dark"><?php echo app('translator')->getFromJson('messages.noRecordFound'); ?></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <?php echo Form::open(['id'=>'createProject','class'=>'ajax-form','method'=>'POST']); ?>

                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 ">
                                    <div class="form-group">
                                        <label><?php echo app('translator')->getFromJson('modules.projects.projectName'); ?></label>
                                        <input type="text" name="project_name" id="project_name" class="form-control">
                                        <input type="hidden" name="template_id" id="template_id">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo app('translator')->getFromJson('modules.projects.projectCategory'); ?> <a href="javascript:;"
                                                                                         id="addProjectCategory"
                                                                                         class="btn btn-sm btn-outline btn-success"><i
                                                        class="fa fa-plus"></i> <?php echo app('translator')->getFromJson('modules.projectCategory.addProjectCategory'); ?></a>
                                        </label>
                                        <select class="selectpicker form-control" name="category_id" id="category_id"
                                                data-style="form-control">
                                            <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <option value="<?php echo e($category->id); ?>"><?php echo e(ucwords($category->category_name)); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <option value=""><?php echo app('translator')->getFromJson('messages.noProjectCategoryAdded'); ?></option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 ">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo app('translator')->getFromJson('modules.projects.selectClient'); ?></label>
                                        <select class="select2 form-control" name="client_id" id="client_id"
                                                data-style="form-control">
                                                <option value=""><?php echo app('translator')->getFromJson('modules.projects.selectClient'); ?></option>
                                            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($client->id); ?>"><?php echo e(ucwords($client->name)); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-xs-12 col-md-3">
                                    <div class="form-group">
                                        <div class="checkbox checkbox-info  col-md-10">
                                            <input id="client_view_task" onchange="checkTask()" name="client_view_task" value="true"
                                                   type="checkbox">
                                            <label for="client_view_task"><?php echo app('translator')->getFromJson('modules.projects.clientViewTask'); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-3" id="clientNotification">
                                    <div class="form-group">
                                        <div class="checkbox checkbox-info  col-md-10">
                                            <input id="client_task_notification" name="client_task_notification" value="true"
                                                   type="checkbox">
                                            <label for="client_task_notification"><?php echo app('translator')->getFromJson('modules.projects.clientTaskNotification'); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-3">
                                    <div class="form-group">
                                        <div class="checkbox checkbox-info  col-md-10">
                                            <input id="manual_timelog" name="manual_timelog" value="true"
                                                   type="checkbox">
                                            <label for="manual_timelog"><?php echo app('translator')->getFromJson('modules.projects.manualTimelog'); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-3">
                                    <div class="form-group">
                                        <div class="checkbox checkbox-info  col-md-10">
                                            <input id="default_project_member" name="default_project_member" value="true"
                                                   type="checkbox" checked>
                                            <label for="default_project_member"><?php echo app('translator')->getFromJson('modules.projects.selfAssignAsProjectMember'); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><?php echo app('translator')->getFromJson('modules.projects.startDate'); ?></label>
                                        <input type="text" name="start_date" id="start_date" autocomplete="off" class="form-control">
                                    </div>
                                </div>
                                <!--/span-->

                                <div class="col-md-4" id="deadlineBox">
                                    <div class="form-group">
                                        <label><?php echo app('translator')->getFromJson('modules.projects.deadline'); ?></label>
                                        <input type="text" name="deadline" id="deadline" autocomplete="off" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group" style="padding-top: 25px;">
                                        <div class="checkbox checkbox-info">
                                            <input id="without_deadline" name="without_deadline" value="true"
                                                   type="checkbox">
                                            <label for="without_deadline"><?php echo app('translator')->getFromJson('modules.projects.withoutDeadline'); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo app('translator')->getFromJson('modules.projects.projectSummary'); ?></label>
                                        <textarea name="project_summary" id="project_summary"
                                                  class="summernote"></textarea>
                                    </div>
                                </div>

                            </div>
                            <!--/span-->

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo app('translator')->getFromJson('modules.projects.note'); ?></label>
                                        <textarea name="notes" id="notes" rows="5" class="form-control"></textarea>
                                    </div>
                                </div>

                            </div>
                            <!--/span-->

                            <h3 class="box-title m-b-30"><?php echo app('translator')->getFromJson('modules.projects.budgetInfo'); ?></h3>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo app('translator')->getFromJson('modules.projects.projectBudget'); ?></label>
                                        <input type="text" class="form-control" name="project_budget">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo app('translator')->getFromJson('modules.invoices.currency'); ?></label>
                                        <select name="currency_id" id="" class="form-control">
                                            <option value="">--</option>
                                            <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($item->id); ?>"><?php echo e($item->currency_name); ?> (<?php echo e($item->currency_code); ?>)</option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo app('translator')->getFromJson('modules.projects.hours_allocated'); ?></label>
                                        <input type="text" name="hours_allocated" class="form-control">
                                    </div>
                                </div>
    

                            </div>
                            <!--/span-->

                            <div class="row">
                                <?php if(isset($fields)): ?>
                                    <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-md-6">
                                            <label><?php echo e(ucfirst($field->label)); ?></label>
                                            <div class="form-group">
                                                <?php if( $field->type == 'text'): ?>
                                                    <input type="text" name="custom_fields_data[<?php echo e($field->name.'_'.$field->id); ?>]" class="form-control" placeholder="<?php echo e($field->label); ?>" value="<?php echo e($editUser->custom_fields_data['field_'.$field->id] ?? ''); ?>">
                                                <?php elseif($field->type == 'password'): ?>
                                                    <input type="password" name="custom_fields_data[<?php echo e($field->name.'_'.$field->id); ?>]" class="form-control" placeholder="<?php echo e($field->label); ?>" value="<?php echo e($editUser->custom_fields_data['field_'.$field->id] ?? ''); ?>">
                                                <?php elseif($field->type == 'number'): ?>
                                                    <input type="number" name="custom_fields_data[<?php echo e($field->name.'_'.$field->id); ?>]" class="form-control" placeholder="<?php echo e($field->label); ?>" value="<?php echo e($editUser->custom_fields_data['field_'.$field->id] ?? ''); ?>">

                                                <?php elseif($field->type == 'textarea'): ?>
                                                    <textarea name="custom_fields_data[<?php echo e($field->name.'_'.$field->id); ?>]" class="form-control" id="<?php echo e($field->name); ?>" cols="3"><?php echo e($editUser->custom_fields_data['field_'.$field->id] ?? ''); ?></textarea>

                                                <?php elseif($field->type == 'radio'): ?>
                                                    <div class="radio-list">
                                                        <?php $__currentLoopData = $field->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <label class="radio-inline <?php if($key == 0): ?> p-0 <?php endif; ?>">
                                                                <div class="radio radio-info">
                                                                    <input type="radio" name="custom_fields_data[<?php echo e($field->name.'_'.$field->id); ?>]" id="optionsRadios<?php echo e($key.$field->id); ?>" value="<?php echo e($value); ?>" <?php if(isset($editUser) && $editUser->custom_fields_data['field_'.$field->id] == $value): ?> checked <?php elseif($key==0): ?> checked <?php endif; ?>>>
                                                                    <label for="optionsRadios<?php echo e($key.$field->id); ?>"><?php echo e($value); ?></label>
                                                                </div>
                                                            </label>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                <?php elseif($field->type == 'select'): ?>
                                                    <?php echo Form::select('custom_fields_data['.$field->name.'_'.$field->id.']',
                                                            $field->values,
                                                             isset($editUser)?$editUser->custom_fields_data['field_'.$field->id]:'',['class' => 'form-control gender']); ?>


                                                <?php elseif($field->type == 'checkbox'): ?>
                                                    <div class="mt-checkbox-inline">
                                                        <?php $__currentLoopData = $field->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <label class="mt-checkbox mt-checkbox-outline">
                                                                <input name="custom_fields_data[<?php echo e($field->name.'_'.$field->id); ?>][]" type="checkbox" value="<?php echo e($key); ?>"> <?php echo e($value); ?>

                                                                <span></span>
                                                            </label>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                <?php elseif($field->type == 'date'): ?>
                                                    <input type="text" class="form-control date-picker" size="16" name="custom_fields_data[<?php echo e($field->name.'_'.$field->id); ?>]"
                                                           value="<?php echo e(isset($editUser->dob)?Carbon\Carbon::parse($editUser->dob)->format('Y-m-d'):Carbon\Carbon::now()->format('m/d/Y')); ?>">
                                                <?php endif; ?>
                                                <div class="form-control-focus"> </div>
                                                <span class="help-block"></span>

                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>

                            </div>

                        </div>
                        <div class="form-actions">
                            <button type="submit" id="save-form" class="btn btn-success"><i class="fa fa-check"></i>
                                <?php echo app('translator')->getFromJson('app.save'); ?>
                            </button>
                            <button type="reset" class="btn btn-default"><?php echo app('translator')->getFromJson('app.reset'); ?></button>
                        </div>
                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>    <!-- .row -->

    
    <div class="modal fade bs-modal-md in" id="projectCategoryModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
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
        <!-- /.modal-dialog -->
    </div>
    
<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-script'); ?>
<script src="<?php echo e(asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/summernote/dist/summernote.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/custom-select/custom-select.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js')); ?>"></script>
<script>
    $(".select2").select2({
        formatNoMatches: function () {
            return "<?php echo e(__('messages.noRecordFound')); ?>";
        }
    });
    $('#clientNotification').hide();
    $("#start_date").datepicker({
        todayHighlight: true,
        autoclose: true,
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#deadline').datepicker('setStartDate', minDate);
    });

    // check client view task checked
    function checkTask()
    {
        var chVal = $('#client_view_task').is(":checked") ? true : false;
        if(chVal == true){
            $('#clientNotification').show();
        }
        else{
            $('#clientNotification').hide();
        }
    }

    $('#without_deadline').click(function () {
        var check = $('#without_deadline').is(":checked") ? true : false;
        if(check == true){
            $('#deadlineBox').hide();
        }
        else{
           $('#deadlineBox').show();
        }
    });

    // Set selected Template
    function setTemplate(id){
        var template = <?php echo $templates; ?>;
        var selectedTemplate = [];
        if(id != null && id != undefined && id != ""){
            $.each( template, function( key, value ) {
                if(value['id'] == id){
                    selectedTemplate = value;
                }
            });
            $('#project_name').val(selectedTemplate['project_name']);
            $('#category_id').selectpicker('val', selectedTemplate['category_id']);
            $('#project_summary').summernote('code', selectedTemplate['project_summary']);
            $('#notes').val(selectedTemplate['notes']);
            $('#template_id').val(selectedTemplate['id']);

            if(selectedTemplate['client_view_task'] == 'enable'){
                $("#client_view_task").prop('checked', true);
                $('#clientNotification').show();
                if(selectedTemplate['allow_client_notification'] == 'enable'){
                    $("#client_task_notification").prop('checked', 'checked');
                }
                else{
                    $("#client_task_notification").prop('checked', false);
                }
            }
            else{
                $("#client_view_task").prop('checked', false);
                $("#client_task_notification").prop('checked', false);
                $('#clientNotification').hide();
            }
            if(selectedTemplate['manual_timelog'] == 'enable'){
                $("#manual_timelog").prop('checked', true);
            }
            else{
                $("#manual_timelog").prop('checked', false);
            }
        }
    }


    $("#deadline").datepicker({
                autoclose: true
    }).on('changeDate', function (selected) {
                var maxDate = new Date(selected.date.valueOf());
                $('#start_date').datepicker('setEndDate', maxDate);
            });

    $('#save-form').click(function () {
        $.easyAjax({
            url: '<?php echo e(route('admin.projects.store')); ?>',
            container: '#createProject',
            type: "POST",
            redirect: true,
            data: $('#createProject').serialize()
        })
    });

    $('.summernote').summernote({
        height: 200,                 // set editor height
        minHeight: null,             // set minimum height of editor
        maxHeight: null,             // set maximum height of editor
        focus: false                 // set focus to editable area after initializing summernote
    });

    $(':reset').on('click', function(evt) {
        evt.preventDefault()
        $form = $(evt.target).closest('form')
        $form[0].reset()
        $form.find('select').selectpicker('render')
    });
</script>

<script>
    $('#createProject').on('click', '#addProjectCategory', function () {
        var url = '<?php echo e(route('admin.projectCategory.create-cat')); ?>';
        $('#modelHeading').html('Manage Project Category');
        $.ajaxModal('#projectCategoryModal', url);
    })
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/projects/create.blade.php ENDPATH**/ ?>