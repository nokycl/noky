<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo e(asset('favicon/apple-icon-57x57.png')); ?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo e(asset('favicon/apple-icon-60x60.png')); ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo e(asset('favicon/apple-icon-72x72.png')); ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo e(asset('favicon/apple-icon-76x76.png')); ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo e(asset('favicon/apple-icon-114x114.png')); ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo e(asset('favicon/apple-icon-120x120.png')); ?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo e(asset('favicon/apple-icon-144x144.png')); ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo e(asset('favicon/apple-icon-152x152.png')); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('favicon/apple-icon-180x180.png')); ?>">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo e(asset('favicon/android-icon-192x192.png')); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('favicon/favicon-32x32.png')); ?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo e(asset('favicon/favicon-96x96.png')); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('favicon/favicon-16x16.png')); ?>">
    <link rel="manifest" href="<?php echo e(asset('favicon/manifest.json')); ?>">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo e(asset('favicon/ms-icon-144x144.png')); ?>">
    <meta name="theme-color" content="#ffffff">

    <title><?php echo e($setting->company_name); ?></title>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo e(asset('bootstrap/dist/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <!-- animation CSS -->
    <link href="<?php echo e(asset('css/animate.css')); ?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet">
    <!-- color CSS -->
    <link href="<?php echo e(asset('css/colors/blue.css')); ?>" id="theme"  rel="stylesheet">
    <link href="<?php echo e(asset('css/custom.css')); ?>"   rel="stylesheet">
    <link href="<?php echo e(asset('css/admin-custom.css')); ?>" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>;
    </script>

    <?php if(!is_null($setting->login_background)): ?>
    <style>
        .login-register{
            background: url("<?php echo e(asset('user-uploads/login-background.jpg')); ?>") center center/cover no-repeat!important;
        }
    </style>
    <?php endif; ?>


</head>
<body>
<!-- Preloader -->
<div class="preloader">
    <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper" class="login-register">
    <div class="login-box">
        <?php if(is_null($setting->logo)): ?>
                <!--This is dark logo icon-->
        <a href="javascript:void(0)"
           style="padding: 25px 0; <?php if($setting->active_theme == 'custom'): ?> background: #292929; <?php endif; ?>"

           class="text-center db"><img src="<?php echo e(asset('worksuite-logo.png')); ?>" style="max-width: 240px" alt="Home" /></a>
        <?php else: ?>
            <a href="javascript:void(0)"
               style="padding: 25px 0; <?php if($setting->active_theme == 'custom'): ?> background: #292929; <?php endif; ?>"
               class="text-center db" ><img src="<?php echo e(asset('user-uploads/app-logo/'.$setting->logo)); ?>" alt="home"  style="max-width: 240px" /></a>
            <div class="clearfix"></div>

        <?php endif; ?>
        <div class="white-box">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
</section>

<!-- Scripts -->
<script src="<?php echo e(asset('js/app.js')); ?>"></script>
<!-- Menu Plugin JavaScript -->
<script src="<?php echo e(asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js')); ?>"></script>

<!--slimscroll JavaScript -->
<script src="<?php echo e(asset('js/jquery.slimscroll.js')); ?>"></script>
<!--Wave Effects -->
<script src="<?php echo e(asset('js/waves.js')); ?>"></script>
<!-- Custom Theme JavaScript -->
<script src="<?php echo e(asset('js/custom.min.js')); ?>"></script>
<!--Style Switcher -->
<script src="<?php echo e(asset('plugins/bower_components/styleswitcher/jQuery.style.switcher.js')); ?>"></script>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/layouts/auth.blade.php ENDPATH**/ ?>