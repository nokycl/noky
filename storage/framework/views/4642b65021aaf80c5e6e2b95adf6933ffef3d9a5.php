<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <title> <?php echo e(__($pageTitle)); ?> | <?php echo e(ucwords($setting->company_name)); ?></title>
    <!-- Styles -->
    <link href="<?php echo e(asset('front/css/core.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('front/css/theme.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('front/plugin/froiden-helper/helper.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('front/css/style.css')); ?>" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo e(asset('favicon/apple-icon-57x57.png')); ?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo e(asset('favicon/apple-icon-60x60.png')); ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo e(asset('favicon/apple-icon-72x72.png')); ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo e(asset('favicon/apple-icon-76x76.png')); ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo e(asset('favicon/apple-icon-114x114.png')); ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo e(asset('favicon/apple-icon-120x120.png')); ?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo e(asset('favicon/apple-icon-144x144.png')); ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo e(asset('favicon/apple-icon-152x152.png')); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('favicon/apple-icon-180x180.png')); ?>">
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo e(asset('favicon/android-icon-192x192.png')); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('favicon/favicon-32x32.png')); ?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo e(asset('favicon/favicon-96x96.png')); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('favicon/favicon-16x16.png')); ?>">
    <link rel="manifest" href="<?php echo e(asset('favicon/manifest.json')); ?>">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo e(asset('favicon/ms-icon-144x144.png')); ?>">
    <meta name="theme-color" content="#ffffff">

    <script src="https://www.google.com/recaptcha/api.js"></script>

    <?php echo $__env->yieldPushContent('head-script'); ?>
    <style>
        .has-danger .help-block {
            display: block;
            margin-top: 5px;
            margin-bottom: 10px;
            color: #ff4954;
        }

        .feature-icon, .module-available {
            color: #ff0476;
        }

        .pick-plan .pricing__head {
            padding: 3.88em 1.85714286em;
            background: #ff0476;
        }
        .pick-plan .pricing__head h3{
            color: white;
            font-weight: 500;
        }
        .pick-plan .pricing li{
            text-align: left;
            padding-left: 1em;
            font-weight: 500;
            text-transform: capitalize;
        }

        .boxed {
            position: relative;
            overflow: hidden;
            padding: 1.85714286em;
            margin-bottom: 30px;
        }
        .pricing-3 ul li:not(:last-child) {
            border-bottom: none;
        }

        .pricing-section-2 .pricing {
            border-radius: 0;
        }

        .pricing-section-2 div[class*='col-']:last-child .pricing {
            border-radius: 0 6px 6px 0px;
        }

        .pricing-section-2 div[class*='col-']:first-child .pricing {
            border-radius: 6px 0 0 6px;
        }

        .pricing-section-2 .pricing {
            border: 1px solid #ececec;
            border-radius: 6px 0 0 6px;
            border-right: none;
        }

        .pricing-section-2 div[class*='col-']:first-child .pricing .pricing__head {
            border-radius: 6px 0 0 0;
        }

        .pick-plan .pricing__head {
            padding: 2.78em 1.85714286em;
            background: #ff0476;
        }

        .pricing-3 .pricing__head {
            margin: 0;
            border-bottom: 1px solid #ececec;
        }

        .pricing-3 {
            padding: 0;
        }
        .pricing-section-2 div[class*='col-'] {
            padding: 0;
        }

        .pricing-section-2 div[class*='col-']:not(:first-child):not(:last-child) .pricing__head {
            border-radius: 0;
        }

        .pricing-3 .pricing__head {
            margin: 0;
            border-bottom: 1px solid #ececec;
        }
        .bg--secondary {
            background: #fafafa;
        }

        .pricing-section-2 .pricing {
            border-radius: 0;
        }

        .pricing-section-2 div[class*='col-']:last-child .pricing .pricing__head {
            border-radius: 0 6px 0 0;
        }

        .pricing-section-2 div[class*='col-']:last-child .pricing {
            border-radius: 0 6px 6px 6px;
            border-right: 1px solid #ececec;
        }

        .pricing-section-2 div[class*='col-']:last-child .pricing {
            border-radius: 0 6px 6px 0px;
        }

        .pricing-3 ul li {
            padding: 0.92857143em 0;
        }

        
    </style>
</head>

<body id="home">


<!-- Topbar -->
<?php echo $__env->make('sections.front_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- END Topbar -->




<!-- Header -->
<?php echo $__env->yieldContent('header-section'); ?>
<!-- END Header -->




<!-- Main container -->
<main class="main-content">
    <?php echo $__env->yieldContent('content'); ?>
</main>
<!-- END Main container -->


<!-- Footer -->
<?php echo $__env->make('sections.front_footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- END Footer -->



<!-- Scripts -->
<script src="<?php echo e(asset('front/js/core.min.js')); ?>"></script>
<script src="<?php echo e(asset('front/js/theme.min.js')); ?>"></script>
<script src="<?php echo e(asset('front/plugin/froiden-helper/helper.js')); ?>"></script>
<script src="<?php echo e(asset('front/js/script.js')); ?>"></script>

<?php echo $__env->yieldPushContent('footer-script'); ?>
</body>
</html><?php /**PATH /var/www/html/resources/views/layouts/front-app.blade.php ENDPATH**/ ?>