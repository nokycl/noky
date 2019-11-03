<?php $__env->startPush('head-script'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('pricing/css/style.css')); ?>">
    <style>
        .text-danger {
            color: red !important;
        }
        h3 {
            line-height: 30px;
            font-size: 10px;
        }
        .display-small {
            display: block;
            width: fit-content;
        }
        .display-big {
            display: none;
        }
        .price {
            font-size: 1em;
        }
        body {
            background: #4f5467;
            font-family: Poppins,sans-serif;
            margin: 0;
            overflow-x: hidden;
            color: #686868;
            font-weight: 300;
            font-size: 5px;
            line-height: 1.42857143;
        }
        @media (min-width: 767px) {
            .display-small {
                display: none;
            }
            .display-big {
                display: block;
            }
            .price {
                font-size: 3em;
            }
            body {
                font-size: 14px;
            }
        }
        @media (min-width: 1200px) {
            h3 {
                line-height: 30px;
                font-size: 21px;
            }
        }
        .selected-plan, body .table>tbody>tr.active>th.selected-plan {
            background-color:#a6ebff5e !important;
            font-weight: 600;
        }
    </style>
<?php $__env->stopPush(); ?>

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
                <li class="active"><?php echo e(__($pageTitle)); ?></li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('head-script'); ?>

<?php $__env->stopPush(); ?>


<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                <?php Session::forget('success');?>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
                <?php Session::forget('error');?>
            <?php endif; ?>
                <div class="white-box ">
                    <h1><?php echo app('translator')->getFromJson('app.monthly'); ?> <?php echo app('translator')->getFromJson('app.menu.packages'); ?></h1>
                    
                        <table class="table table-hover table-bordered" style="text-align:center;padding-left:200px; padding-right:200px;">
                            <thead>
                            <tr class="active">
                                <th style="background:#fff !important; min-width:80px;"></th>
                                <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th style="<?php if(($package->id == $company->package->id && $company->package_type == 'monthly')): ?> background-color:#a6ebff5e !important; <?php endif; ?>">
                                        <center>
                                            <h3 ><?php echo e(ucfirst($package->name)); ?></h3>
                                        </center>
                                    </th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><br><?php echo app('translator')->getFromJson('app.price'); ?></td>
                                <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <td class="<?php if(($package->id == $company->package->id && $company->package_type == 'monthly')): ?> selected-plan <?php endif; ?>"><h3 class="panel-title price ">$<?php echo e(round($package->monthly_price)); ?></h3></td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>

                            <tr>
                                <td><?php echo app('translator')->getFromJson('app.menu.employees'); ?></td>
                                <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <td class="<?php if(($package->id == $company->package->id && $company->package_type == 'monthly')): ?> selected-plan <?php endif; ?>"><?php echo e($package->max_employees); ?> <?php echo app('translator')->getFromJson('modules.projects.members'); ?></td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>

                            <tr>
                                <?php
                                    $moduleArray = [];
                                    foreach($modulesData as $module) {
                                        $moduleArray[$module->module_name] = [];
                                    }
                                ?>

                                <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__currentLoopData = (array)json_decode($package->module_in_package); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $MIP): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(array_key_exists($MIP, $moduleArray)): ?>
                                            <?php $moduleArray[$MIP][] = strtoupper(trim($package->name)); ?>
                                        <?php else: ?>
                                            <?php $moduleArray[$MIP] = [strtoupper(trim($package->name))]; ?>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                            <tr>
                                <td colspan="5" align="left" style="padding-left:20px;" class="active"><b><?php echo app('translator')->getFromJson('modules.moduleSettings.employeeModuleTitle'); ?></b></td>
                            </tr>
                            <?php $__currentLoopData = $moduleArray; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(ucfirst($key)); ?></td>
                                    <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $available = in_array(strtoupper(trim($package->name)), $module); ?>
                                        <td class="<?php if(($package->id == $company->package->id && $company->package_type == 'monthly')): ?> selected-plan <?php endif; ?>"><i class="fa <?php echo e($available ? 'fa-check text-megna' : 'fa-times text-danger'); ?> fa-lg"></i></td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tr><td></td>

                                <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <td>
                                        <?php if(round($package->monthly_price) > 0): ?>
                                            <?php if(!($package->id == $company->package->id && $company->package_type == 'monthly')  && ($stripeSettings->paypal_status == 'active' || $stripeSettings->stripe_status == 'active')): ?>
                                                <button type="button" data-package-id="<?php echo e($package->id); ?>" data-package-type="monthly" class="btn btn-success waves-effect waves-light selectPackage" title="Choose Plan"><i class="icon-anchor display-small"></i><span class="display-big"><?php echo app('translator')->getFromJson('modules.billing.choosePlan'); ?></span></button>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                            </tbody>
                        </table>
                    

                    <h1 class="m-t-20"><?php echo app('translator')->getFromJson('app.annual'); ?> <?php echo app('translator')->getFromJson('app.menu.packages'); ?></h1>
                    <table class="table table-hover table-bordered" style="text-align:center;padding-left:200px; padding-right:200px;">
                        <thead>
                        <tr class="active">
                            <th style="background:#fff !important"><center></center></th>
                            <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th style="<?php if(($package->id == $company->package->id && $company->package_type == 'annual')): ?> background-color:#a6ebff5e !important; <?php endif; ?>"><center><h3><?php echo e(ucfirst($package->name)); ?></h3></center></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><br><?php echo app('translator')->getFromJson('app.price'); ?></td>
                            <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td class="<?php if(($package->id == $company->package->id && $company->package_type == 'annual')): ?> selected-plan <?php endif; ?>"><h3 class="panel-title price">$<?php echo e(round($package->annual_price)); ?></h3></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>

                        <tr>
                            <td><?php echo app('translator')->getFromJson('app.menu.employees'); ?></td>
                            <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td class="<?php if(($package->id == $company->package->id && $company->package_type == 'annual')): ?> selected-plan <?php endif; ?>"><?php echo e($package->max_employees); ?> <?php echo app('translator')->getFromJson('modules.projects.members'); ?></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                        <tr>
                            <td colspan="5" align="left" style="padding-left:20px;" class="active"><b><?php echo app('translator')->getFromJson('modules.moduleSettings.employeeModuleTitle'); ?></b></td>
                        </tr>
                        <?php $__currentLoopData = $moduleArray; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e(ucfirst($key)); ?></td>
                                <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $available = in_array(strtoupper(trim($package->name)), $module); ?>
                                    <td class="<?php if(($package->id == $company->package->id && $company->package_type == 'annual')): ?> selected-plan <?php endif; ?>"><i class="fa <?php echo e($available ? 'fa-check text-megna' : 'fa-times text-danger'); ?> fa-lg"></i></td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <tr><td></td>

                            <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td>
                                    <?php if(round($package->annual_price) > 0): ?>
                                        <?php if(!($package->id == $company->package->id && $company->package_type == 'annual') && ($stripeSettings->paypal_status == 'active'  || $stripeSettings->stripe_status == 'active')): ?>
                                            <button type="button" data-package-id="<?php echo e($package->id); ?>" data-package-type="annual" class="btn btn-success waves-effect waves-light selectPackage" title="Choose Plan"><i class="icon-anchor display-small"></i><span class="display-big"><?php echo app('translator')->getFromJson('modules.billing.choosePlan'); ?></span></button>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
    
    <div class="modal fade bs-modal-md in" id="package-select-form" role="dialog" aria-labelledby="myModalLabel"
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
    <script src="<?php echo e(asset('pricing/js/index.js')); ?>"></script>
<script>
    // $(document).ready(function() {
        // show when page load
        <?php if(\Session::has('message')): ?>
            toastr.success(<?php echo e(\Session::get('message')); ?>);
        <?php endif; ?>
    // });

    $('body').on('click', '.unsubscription', function(){
        var type = $(this).data('type');
        swal({
            title: "Are you sure?",
            text: "Do you want to unsubscribe this plan!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Unsubscribe it!",
            cancelButtonText: "No, cancel please!",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function(isConfirm){
            if (isConfirm) {

                var url = "<?php echo e(route('admin.billing.unsubscribe')); ?>";
                var token = "<?php echo e(csrf_token()); ?>";
                $.easyAjax({
                    type: 'POST',
                    url: url,
                    data: {'_token': token, '_method': 'POST', 'type': type},
                    success: function (response) {
                        if (response.status == "success") {
                            $.unblockUI();
//                                    swal("Deleted!", response.message, "success");
                            table._fnDraw();
                        }
                    }
                });
            }
        });
    });

    // Show Create Holiday Modal
    $('body').on('click', '.selectPackage', function(){
        var id = $(this).data('package-id');
        var type = $(this).data('package-type');
        var url = "<?php echo e(route('admin.billing.select-package',':id')); ?>?type="+type;
        url = url.replace(':id', id);
        $.ajaxModal('#package-select-form', url);
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/billing/package.blade.php ENDPATH**/ ?>