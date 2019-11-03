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
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/calendar/dist/fullcalendar.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/morrisjs/morris.css')); ?>"><!--Owl carousel CSS -->
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/owl.carousel/owl.carousel.min.css')); ?>"><!--Owl carousel CSS -->
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/owl.carousel/owl.theme.default.css')); ?>"><!--Owl carousel CSS -->

<style>
    .col-in {
        padding: 0 20px !important;

    }

    .fc-event{
        font-size: 10px !important;
    }

</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row dashboard-stats">
        <?php ($updateVersionInfo = \Froiden\Envato\Functions\EnvatoUpdate::updateVersionInfo()); ?>
        <?php if(isset($updateVersionInfo['lastVersion'])): ?>
            <div class="alert alert-info col-md-12">
                <div class="col-md-10"><i class="ti-gift"></i> <?php echo app('translator')->getFromJson('modules.update.newUpdate'); ?> <label class="label label-success"><?php echo e($updateVersionInfo['lastVersion']); ?></label></div>
                <div class="col-md-2"><a href="<?php echo e(route('super-admin.update-settings.index')); ?>" class="btn btn-success btn-small"><?php echo app('translator')->getFromJson('modules.update.updateNow'); ?> <i class="fa fa-arrow-right"></i></a></div>
            </div>
        <?php endif; ?>

        <?php if(!$progress['progress_completed']): ?>
            <?php echo $__env->make('super-admin.dashboard.get_started', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

            
        <div class="col-md-3 col-sm-6">
            <div class="white-box">
            <div class="col-in row">
                <h3 class="box-title"><?php echo app('translator')->getFromJson('modules.dashboard.totalCompanies'); ?></h3>
                <ul class="list-inline two-part">
                    <li><i class="icon-layers text-success"></i></li>
                    <li class="text-right"><span class="counter"><?php echo e($totalCompanies); ?></span></li>
                </ul>
            </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="white-box">
            <div class="col-in row">
                <h3 class="box-title"><?php echo app('translator')->getFromJson('modules.dashboard.activeCompanies'); ?></h3>
                <ul class="list-inline two-part">
                    <li><i class="icon-layers text-success"></i></li>
                    <li class="text-right"><span class="counter"><?php echo e($activeCompanies); ?></span></li>
                </ul>
            </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="white-box">
            <div class="col-in row">
                <h3 class="box-title"><?php echo app('translator')->getFromJson('modules.dashboard.licenseExpired'); ?></h3>
                <ul class="list-inline two-part">
                    <li><i class="icon-layers text-success"></i></li>
                    <li class="text-right"><span class="counter"><?php echo e($expiredCompanies); ?></span></li>
                </ul>
            </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="white-box">
            <div class="col-in row">
                <h3 class="box-title"><?php echo app('translator')->getFromJson('modules.dashboard.inactiveCompanies'); ?></h3>
                <ul class="list-inline two-part">
                    <li><i class="icon-layers text-success"></i></li>
                    <li class="text-right"><span class="counter"><?php echo e($inactiveCompanies); ?></span></li>
                </ul>
            </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-md-3 col-sm-6">
            <div class="white-box">
                <div class="col-in row">
                    <h3 class="box-title"><?php echo app('translator')->getFromJson('app.total'); ?> <?php echo app('translator')->getFromJson('app.menu.packages'); ?></h3>
                    <ul class="list-inline two-part">
                        <li><i class="icon-layers text-success"></i></li>
                        <li class="text-right"><span class="counter"><?php echo e($totalPackages); ?></span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <ul class="list-inline text-center m-t-40">
                    <li>
                        <h5><i class="fa fa-circle m-r-5" style="color:rgb(13, 219, 228);"></i><?php echo app('translator')->getFromJson('app.earnings'); ?></h5>
                    </li>
                </ul>
                <div id="morris-area-chart" style="height: 340px;"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="white-box">
                <h3 class="box-title"><?php echo app('translator')->getFromJson('modules.superadmin.recentRegisteredCompanies'); ?></h3>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center"><?php echo app('translator')->getFromJson('app.name'); ?></th>
                            <th class="text-center"><?php echo app('translator')->getFromJson('app.email'); ?></th>
                            <th class="text-center"><?php echo app('translator')->getFromJson('app.menu.packages'); ?></th>
                            <th class="text-center"><?php echo app('translator')->getFromJson('app.date'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $recentRegisteredCompanies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $recent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-center"><?php echo e($key + 1); ?> </td>
                                <td class="text-center"><?php echo e($recent->company_name); ?> </td>
                                <td class="text-center"><?php echo e($recent->company_email); ?> </td>
                                <td class="text-center"><?php echo e(ucwords($recent->package->name)); ?> (<?php echo e(ucwords($recent->package_type)); ?>) </td>
                                <td class="text-center"><?php echo e($recent->created_at->format('M j, Y')); ?> </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr class="text-center">
                                <td colspan="4"><?php echo app('translator')->getFromJson('messages.noRecordFound'); ?></td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="white-box">
                <h3 class="box-title"><?php echo app('translator')->getFromJson('modules.superadmin.recentSubscriptions'); ?></h3>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center"><?php echo app('translator')->getFromJson('modules.client.companyName'); ?></th>
                            <th class="text-center"><?php echo app('translator')->getFromJson('app.menu.packages'); ?></th>
                            <th class="text-center"><?php echo app('translator')->getFromJson('app.date'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $recentSubscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $recent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-center"><?php echo e($key + 1); ?> </td>
                                <td class="text-center"><?php echo e($recent->company_name); ?> </td>
                                <td class="text-center"><?php echo e(ucwords($recent->name)); ?> (<?php echo e(ucwords($recent->package_type)); ?>) </td>
                                <td class="text-center"><?php echo e(\Carbon\Carbon::parse($recent->paid_on)->format('M j, Y')); ?> </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr class="text-center">
                                <td colspan="4"><?php echo app('translator')->getFromJson('messages.noRecordFound'); ?></td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="white-box">
                <h3 class="box-title"><?php echo app('translator')->getFromJson('modules.superadmin.recentLicenseExpiredCompanies'); ?></h3>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center"><?php echo app('translator')->getFromJson('modules.client.companyName'); ?></th>
                            <th class="text-center"><?php echo app('translator')->getFromJson('app.menu.packages'); ?></th>
                            <th class="text-center"><?php echo app('translator')->getFromJson('app.date'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $recentExpired; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $recent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-center"><?php echo e($key + 1); ?> </td>
                                <td class="text-center"><?php echo e($recent->company_name); ?> </td>
                                <td class="text-center"><?php echo e(ucwords($recent->package->name)); ?> (<?php echo e(ucwords($recent->package_type)); ?>) </td>
                                <td class="text-center"><?php echo e($recent->updated_at->format('M j, Y')); ?> </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr class="text-center">
                                <td colspan="4"><?php echo app('translator')->getFromJson('messages.noRecordFound'); ?></td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('footer-script'); ?>

<script src="<?php echo e(asset('plugins/bower_components/raphael/raphael-min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/morrisjs/morris.js')); ?>"></script>

<script src="<?php echo e(asset('plugins/bower_components/waypoints/lib/jquery.waypoints.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/counterup/jquery.counterup.min.js')); ?>"></script>

<!-- jQuery for carousel -->
<script src="<?php echo e(asset('plugins/bower_components/owl.carousel/owl.carousel.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/owl.carousel/owl.custom.js')); ?>"></script>

<!--weather icon -->
<script src="<?php echo e(asset('plugins/bower_components/skycons/skycons.js')); ?>"></script>

<script src="<?php echo e(asset('plugins/bower_components/calendar/jquery-ui.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/moment/moment.js')); ?>"></script>

<script>
    $(document).ready(function () {
        var chartData = <?php echo $chartData; ?>;

        Morris.Area({
            element: 'morris-area-chart',
            data: chartData,
            lineColors: ['#01c0c8'],
            xkey: ['month'],
            ykeys: ['amount'],
            labels: ['Earning'],
            pointSize: 0,
            lineWidth: 0,
            resize:true,
            fillOpacity: 0.8,
            behaveLikeLine: true,
            gridLineColor: '#e0e0e0',
            hideHover: 'auto',
            parseTime: false
        });

        $('.vcarousel').carousel({
            interval: 3000
        })
    });

    $(".counter").counterUp({
        delay: 100,
        time: 1200
    });

</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.super-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/super-admin/dashboard/index.blade.php ENDPATH**/ ?>