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
                <li><a href="<?php echo e(route('admin.clients.index')); ?>"><?php echo e(__($pageTitle)); ?></a></li>
                <li class="active"><?php echo app('translator')->getFromJson('app.addNew'); ?></li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('head-script'); ?>
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-inverse">
                <div class="panel-heading"> <?php echo app('translator')->getFromJson('modules.client.createTitle'); ?></div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <?php echo Form::open(['id'=>'createClient','class'=>'ajax-form','method'=>'POST']); ?>

                        <?php if(isset($leadDetail->id)): ?>
                            <input type="hidden" name="lead" value="<?php echo e($leadDetail->id); ?>">
                        <?php endif; ?>
                            <div class="form-body">
                                <h3 class="box-title"><?php echo app('translator')->getFromJson('modules.client.companyDetails'); ?></h3>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo app('translator')->getFromJson('modules.client.companyName'); ?></label>
                                            <input type="text" id="company_name" name="company_name" value="<?php echo e($leadDetail->company_name ?? ''); ?>" class="form-control" >
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo app('translator')->getFromJson('modules.client.website'); ?></label>
                                            <input type="text" id="website" name="website" value="<?php echo e($leadDetail->website ?? ''); ?>" class="form-control" >
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <!--/row-->
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo app('translator')->getFromJson('app.address'); ?></label>
                                            <textarea name="address"  id="address"  rows="5" value="<?php echo e($leadDetail->address ?? ''); ?>" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <!--/span-->

                                </div>
                                <!--/row-->

                                <h3 class="box-title m-t-40"><?php echo app('translator')->getFromJson('modules.client.clientDetails'); ?></h3>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->getFromJson('modules.client.clientName'); ?></label>
                                            <input type="text" name="name" id="name"  value="<?php echo e($leadDetail->client_name ?? ''); ?>"   class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->getFromJson('modules.client.clientEmail'); ?></label>
                                            <input type="email" name="email" id="email" value="<?php echo e($leadDetail->client_email ?? ''); ?>"  class="form-control">
                                            <span class="help-block"><?php echo app('translator')->getFromJson('modules.client.emailNote'); ?></span>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->getFromJson('modules.client.mobile'); ?></label>
                                            <input type="tel" name="mobile" id="mobile" value="<?php echo e($leadDetail->mobile ?? ''); ?>" class="form-control">
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <!--/row-->
                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Skype</label>
                                            <input type="text" name="skype" id="skype" class="form-control">
                                        </div>
                                    </div>
                                    <!--/span-->

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Linkedin</label>
                                            <input type="text" name="linkedin" id="linkedin" class="form-control">
                                        </div>
                                    </div>
                                    <!--/span-->

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Twitter</label>
                                            <input type="text" name="twitter" id="twitter" class="form-control">
                                        </div>
                                    </div>
                                    <!--/span-->

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Facebook</label>
                                            <input type="text" name="facebook" id="facebook" class="form-control">
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <!--/row-->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gst_number"><?php echo app('translator')->getFromJson('app.gstNumber'); ?></label>
                                            <input type="text" id="gst_number" name="gst_number" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                                <!--/row-->

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
                                                                        <input type="radio" name="custom_fields_data[<?php echo e($field->name.'_'.$field->id); ?>]" id="optionsRadios<?php echo e($key.$field->id); ?>" value="<?php echo e($value); ?>" <?php if(isset($clientDetail) && $clientDetail->custom_fields_data['field_'.$field->id] == $value): ?> checked <?php elseif($key==0): ?> checked <?php endif; ?>>>
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
                                                        <input type="text" class="form-control form-control-inline date-picker" size="16" name="custom_fields_data[<?php echo e($field->name.'_'.$field->id); ?>]"
                                                                value="<?php echo e(isset($editUser->dob)?Carbon\Carbon::parse($editUser->dob)->format('Y-m-d'):Carbon\Carbon::now()->format('m/d/Y')); ?>">
                                                    <?php endif; ?>
                                                    <div class="form-control-focus"> </div>
                                                    <span class="help-block"></span>

                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>

                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <label><?php echo app('translator')->getFromJson('app.note'); ?></label>
                                        <div class="form-group">
                                            <textarea name="note" id="note" class="form-control" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" id="save-form" class="btn btn-success"> <i class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.save'); ?></button>
                                <button type="reset" class="btn btn-default"><?php echo app('translator')->getFromJson('app.reset'); ?></button>
                            </div>
                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>    <!-- .row -->

<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-script'); ?>
<script src="<?php echo e(asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js')); ?>"></script>

<script>
    $(".date-picker").datepicker({
        todayHighlight: true,
        autoclose: true
    });

    $('#save-form').click(function () {
        $.easyAjax({
            url: '<?php echo e(route('admin.clients.store')); ?>',
            container: '#createClient',
            type: "POST",
            redirect: true,
            data: $('#createClient').serialize()
        })
    });
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/clients/create.blade.php ENDPATH**/ ?>