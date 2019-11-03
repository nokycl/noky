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
                <li><a href="<?php echo e(route('super-admin.dashboard')); ?>"><?php echo app('translator')->getFromJson('app.menu.home'); ?></a></li>
                <li class="active"><?php echo e(__($pageTitle)); ?></li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('head-script'); ?>
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/switchery/dist/switchery.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-inverse">
                <div class="panel-heading"><?php echo app('translator')->getFromJson('modules.frontCms.updateTitle'); ?></div>

                <div class="vtabs customvtab m-t-10">
                    <?php echo $__env->make('sections.front_setting_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <div class="tab-content">
                        <div id="vhome3" class="tab-pane active">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="white-box">
                                        <h3 class="box-title m-b-0"> <?php echo app('translator')->getFromJson("modules.frontSettings.title"); ?></h3>

                                        <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <?php echo Form::open(['id'=>'editSettings','class'=>'ajax-form','method'=>'PUT']); ?>

                                            <h4><?php echo app('translator')->getFromJson('modules.frontCms.frontDetail'); ?></h4>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="company_name"><?php echo app('translator')->getFromJson('modules.frontCms.headerTitle'); ?></label>
                                                        <input type="text" class="form-control" id="header_title" name="header_title"
                                                               value="<?php echo e($frontDetail->header_title); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="address"><?php echo app('translator')->getFromJson('modules.frontCms.headerDescription'); ?></label>
                                                        <textarea class="form-control" id="header_description" rows="5"
                                                                  name="header_description"><?php echo e($frontDetail->header_description); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1"><?php echo app('translator')->getFromJson('modules.frontCms.mainImage'); ?></label>
                                                        <div class="col-md-12">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                <div class="fileinput-new thumbnail"
                                                                     style="width: 200px; height: 150px;">
                                                                    <?php if(is_null($frontDetail->image)): ?>
                                                                        <img src="<?php echo e(asset('front/img/demo/slack/dashboard.jpg')); ?>"
                                                                             alt=""/>
                                                                    <?php else: ?>
                                                                        <img src="<?php echo e(asset('front-uploads/'.$frontDetail->image)); ?>"
                                                                             alt=""/>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="fileinput-preview fileinput-exists thumbnail"
                                                                     style="max-width: 200px; max-height: 150px;"></div>
                                                                <div>
                                <span class="btn btn-info btn-file">
                                    <span class="fileinput-new"> <?php echo app('translator')->getFromJson('app.selectImage'); ?> </span>
                                    <span class="fileinput-exists"> <?php echo app('translator')->getFromJson('app.change'); ?> </span>
                                    <input type="file" name="image" id="image"> </span>
                                                                    <a href="javascript:;" class="btn btn-danger fileinput-exists"
                                                                       data-dismiss="fileinput"> <?php echo app('translator')->getFromJson('app.remove'); ?> </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="checkbox checkbox-info  col-md-10">
                                                            <input id="get_started_show" name="get_started_show" value="yes"
                                                                   <?php if($frontDetail->get_started_show == "yes"): ?> checked
                                                                   <?php endif; ?>
                                                                   type="checkbox">
                                                            <label for="get_started_show"><?php echo app('translator')->getFromJson('modules.frontCms.getStartedButtonShow'); ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="checkbox checkbox-info  col-md-10">
                                                            <input id="sign_in_show" name="sign_in_show" value="yes"
                                                                   <?php if($frontDetail->sign_in_show == "yes"): ?> checked
                                                                   <?php endif; ?>
                                                                   type="checkbox">
                                                            <label for="sign_in_show"><?php echo app('translator')->getFromJson('modules.frontCms.singInButtonShow'); ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo app('translator')->getFromJson('messages.headerImageSizeMessage'); ?></div>
                                                </div>
                                            </div>
                                            <h4><?php echo app('translator')->getFromJson('modules.frontCms.featureDetail'); ?></h4>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="feature_title"><?php echo app('translator')->getFromJson('modules.frontCms.featureTitle'); ?></label>
                                                        <input type="tel" class="form-control" id="feature_title" name="feature_title"
                                                               value="<?php echo e($frontDetail->feature_title); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="feature_description"><?php echo app('translator')->getFromJson('modules.frontCms.featureDescription'); ?></label>
                                                        <textarea class="form-control" id="feature_description" rows="5"
                                                                  name="feature_description"><?php echo e($frontDetail->feature_description); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <h4><?php echo app('translator')->getFromJson('modules.frontCms.priceDetail'); ?></h4>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="price_title"><?php echo app('translator')->getFromJson('modules.frontCms.priceTitle'); ?></label>
                                                        <input type="tel" class="form-control" id="price_title" name="price_title"
                                                               value="<?php echo e($frontDetail->price_title); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="price_description"><?php echo app('translator')->getFromJson('modules.frontCms.priceDescription'); ?></label>
                                                        <textarea class="form-control" id="price_description" rows="5"
                                                                  name="price_description"><?php echo e($frontDetail->price_description); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <h4><?php echo app('translator')->getFromJson('modules.frontCms.contactDetail'); ?></h4>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="email"><?php echo app('translator')->getFromJson('app.email'); ?></label>
                                                        <input type="email" class="form-control" id="email" name="email"
                                                               value="<?php echo e($frontDetail->email); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="phone"><?php echo app('translator')->getFromJson('modules.accountSettings.companyPhone'); ?></label>
                                                        <input type="tel" class="form-control" id="phone" name="phone"
                                                               value="<?php echo e($frontDetail->phone); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="address"><?php echo app('translator')->getFromJson('modules.accountSettings.companyAddress'); ?></label>
                                                        <textarea class="form-control" id="address" rows="5"
                                                                  name="address"><?php echo e($frontDetail->address); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" id="save-form"
                                                    class="btn btn-success waves-effect waves-light m-r-10">
                                                <?php echo app('translator')->getFromJson('app.update'); ?>
                                            </button>
                                            <button type="reset"
                                                    class="btn btn-inverse waves-effect waves-light"><?php echo app('translator')->getFromJson('app.reset'); ?></button>
                                            <?php echo Form::close(); ?>

                                        </div>
                                    </div>
                                    </div>
                                </div>

                            </div>
                            <!-- .row -->
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>
    <!-- .row -->



<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-script'); ?>
    <script>

        $('#save-form').click(function () {
            $.easyAjax({
                url: '<?php echo e(route('super-admin.front-settings.update', $frontDetail->id)); ?>',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true,
            })
        });

    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.super-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/super-admin/front-settings/index.blade.php ENDPATH**/ ?>