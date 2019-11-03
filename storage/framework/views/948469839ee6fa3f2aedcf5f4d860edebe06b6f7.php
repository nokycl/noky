<!DOCTYPE html>
<!--
   This is a starter template page. Use this page to start your new project from
   scratch. This page gets rid of all links and provides the needed markup only.
   -->
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
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
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo e(asset('favicon/android-icon-192x192.png')); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('favicon/favicon-32x32.png')); ?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo e(asset('favicon/favicon-96x96.png')); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('favicon/favicon-16x16.png')); ?>">
    <link rel="manifest" href="<?php echo e(asset('favicon/manifest.json')); ?>">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo e(asset('favicon/ms-icon-144x144.png')); ?>">
    <meta name="theme-color" content="#ffffff">

    <title> Super Admin Panel | <?php echo e(__($pageTitle)); ?></title>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo e(asset('bootstrap/dist/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/0.8.2/css/flag-icon.min.css'>
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/css/bootstrap-select.min.css'>

    <!-- This is Sidebar menu CSS -->
    <link href="<?php echo e(asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css')); ?>" rel="stylesheet">

    <link href="<?php echo e(asset('plugins/bower_components/toast-master/css/jquery.toast.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('plugins/bower_components/sweetalert/sweetalert.css')); ?>" rel="stylesheet">

    <!-- This is a Animation CSS -->
    <link href="<?php echo e(asset('css/animate.css')); ?>" rel="stylesheet"> <?php echo $__env->yieldPushContent('head-script'); ?>

    <!-- This is a Custom CSS -->
    <link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet">
    <!-- color CSS you can use different color css from css/colors folder -->
    <!-- We have chosen the skin-blue (default.css) for this starter
       page. However, you can choose any other skin from folder css / colors .
       -->
    <link href="<?php echo e(asset('css/colors/default.css')); ?>" id="theme" rel="stylesheet">
    <link href="<?php echo e(asset('plugins/froiden-helper/helper.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/custom.css')); ?>" rel="stylesheet"> 


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        .sidebar .notify {
            margin: 0 !important;
        }

        .sidebar .notify .heartbit {
            top: -23px !important;
            right: -15px !important;
        }

        .sidebar .notify .point {
            top: -13px !important;
        }
    </style>

<?php if($pushSetting->status == 'active'): ?>
<link rel="manifest" href="<?php echo e(asset('manifest.json')); ?>" />
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async='async'></script>
<script>
    var OneSignal = window.OneSignal || [];
    OneSignal.push(function() {
        OneSignal.init({
            appId: "<?php echo e($pushSetting->onesignal_app_id); ?>",
            autoRegister: false,
            notifyButton: {
                enable: false,
            },
            promptOptions: {
                /* actionMessage limited to 90 characters */
                actionMessage: "We'd like to show you notifications for the latest news and updates.",
                /* acceptButtonText limited to 15 characters */
                acceptButtonText: "ALLOW",
                /* cancelButtonText limited to 15 characters */
                cancelButtonText: "NO THANKS"
            }
        });
        OneSignal.on('subscriptionChange', function (isSubscribed) {
            console.log("The user's subscription state is now:", isSubscribed);
        });

        
        if (Notification.permission === "granted") {
            // Automatically subscribe user if deleted cookies and browser shows "Allow"
            OneSignal.getUserId()
                .then(function(userId) {
                    if (!userId) {
                        OneSignal.registerForPushNotifications();
                    }
                    else{
                        let db_onesignal_id = '<?php echo e($user->onesignal_player_id); ?>';

                        if((db_onesignal_id == null || db_onesignal_id !== userId) && userId !== null){ //update onesignal ID if it is new
                            updateOnesignalPlayerId(userId);
                        }
                    }
                })
        } else {
            OneSignal.isPushNotificationsEnabled(function(isEnabled) {
                if (isEnabled){
                    console.log("Push notifications are enabled! - 2    ");
                    // console.log("unsubscribe");
                    // OneSignal.setSubscription(false);
                }
                else{
                    console.log("Push notifications are not enabled yet. - 2");    
                    // OneSignal.showHttpPrompt();
                    // OneSignal.registerForPushNotifications({
                    //         modalPrompt: true
                    // });
                }

                OneSignal.getUserId(function(userId) {
                    console.log("OneSignal User ID:", userId);
                    // (Output) OneSignal User ID: 270a35cd-4dda-4b3f-b04e-41d7463a2316    
                    let db_onesignal_id = '<?php echo e($user->onesignal_player_id); ?>';
                    console.log('database id : '+db_onesignal_id);
                    
                    if((db_onesignal_id == null || db_onesignal_id !== userId) && userId !== null){ //update onesignal ID if it is new
                       updateOnesignalPlayerId(userId);
                    }


                });


                OneSignal.showHttpPrompt();
            });
                
        }
    });
</script>
<?php endif; ?>

</head>

<body class="fix-sidebar">
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <div id="wrapper">
        <!-- Top Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <!-- Toggle icon for mobile view -->
                <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>

                <div class="top-left-part">
                    <!-- Logo -->
                    <a class="logo hidden-xs hidden-sm text-center" href="<?php echo e(route('super-admin.dashboard')); ?>">
                    <?php if(is_null($global->logo)): ?>
                            <!--This is dark logo icon-->
                    <img src="<?php echo e(asset('worksuite-logo.png')); ?>" alt="home" class=" admin-logo"/>
                    <?php else: ?>
                        <img src="<?php echo e(asset('user-uploads/app-logo/'.$global->logo)); ?>" alt="home" />
                    <?php endif; ?>
                </a>

                    <div class="admin-panel-name hidden-xs"><?php echo app('translator')->getFromJson('app.superAdminPanel'); ?></div>
                </div>
                <!-- /Logo -->
                <!-- Search input and Toggle icon -->
                <ul class="nav navbar-top-links navbar-left hidden-xs">
                    <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i
                                class="icon-arrow-left-circle ti-menu"></i></a></li>
                    
                    <?php if(isset($missingItems) && $missingItems > 0): ?>
                        <li style="width: 230px; padding: 10px; border-radius: 3px" class="bg-white m-t-5">
                            <?php if($global->google_recaptcha_key == ''): ?>
                            <div>
                                <a class="text-uppercase" href="<?php echo e(route('super-admin.settings.index')); ?>"><small><?php echo app('translator')->getFromJson('app.add'); ?> <?php echo app('translator')->getFromJson('modules.accountSettings.google_recaptcha_key'); ?> <i class="fa fa-arrow-right"></i></small></a>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="<?php echo e($configCompletePercent); ?>" aria-valuemin="0"
                                        aria-valuemax="100" style="width:<?php echo e($configCompletePercent); ?>%;"> <span class="sr-only"><?php echo e($configCompletePercent); ?>% Complete</span></div>
                                </div>
                            </div>
                            <?php elseif($global->currency_converter_key == ''): ?>
                            <div>
                                <a class="text-uppercase" href="<?php echo e(route('super-admin.currency.index')); ?>"><small><?php echo app('translator')->getFromJson('app.add'); ?> <?php echo app('translator')->getFromJson('modules.accountSettings.currencyConverterKey'); ?> <i class="fa fa-arrow-right"></i></small></a>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="<?php echo e($configCompletePercent); ?>" aria-valuemin="0"
                                        aria-valuemax="100" style="width:<?php echo e($configCompletePercent); ?>%;"> <span class="sr-only"><?php echo e($configCompletePercent); ?>% Complete</span></div>
                                </div>
                            </div>
                            <?php elseif($smtpSetting->mail_from_email == 'from@email.com'): ?>
                            <div>
                                <a class="text-uppercase" href="<?php echo e(route('super-admin.email-settings.index')); ?>"><small><?php echo app('translator')->getFromJson('app.add'); ?> <?php echo app('translator')->getFromJson('app.email'); ?> <?php echo app('translator')->getFromJson('app.menu.settings'); ?> <i class="fa fa-arrow-right"></i></small></a>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="<?php echo e($configCompletePercent); ?>" aria-valuemin="0"
                                        aria-valuemax="100" style="width:<?php echo e($configCompletePercent); ?>%;"> <span class="sr-only"><?php echo e($configCompletePercent); ?>% Complete</span></div>
                                </div>
                            </div>
                            <?php endif; ?>

                        </li>
                    <?php endif; ?>
                </ul>
                <!-- This is the message dropdown -->
                <ul class="nav navbar-top-links navbar-right pull-right">

                    <!-- .Task dropdown -->
                    <li class="dropdown" id="top-notification-dropdown">
                        <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#">
                        <i class="icon-bell"></i>
                        <?php if(count($user->unreadNotifications) > 0): ?>
                            <div class="notify"><span class="heartbit"></span><span class="point"></span></div>
                        <?php endif; ?>
                    </a>
                        <ul class="dropdown-menu mailbox animated slideInDown">
                            <li>
                                <div class="drop-title"><?php echo app('translator')->getFromJson('app.newNotifications'); ?> <span id="top-notification-count"><?php echo e(count($user->unreadNotifications)); ?></span>
                                </div>
                            </li>
                            <?php $__currentLoopData = $user->unreadNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <?php echo $__env->make('notifications.superadmin.'.snake_case(class_basename($notification->type)), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <?php if(count($user->unreadNotifications) > 0): ?>
                            <li>
                                <a class="text-center" id="mark-notification-read" href="javascript:;"> <?php echo app('translator')->getFromJson('app.markRead'); ?> <i class="fa fa-check"></i> </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <!-- /.Task dropdown -->

                    <!-- /.dropdown -->


                    <li class="dropdown">
                        <a href="<?php echo e(route('logout')); ?>" title="Logout" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> <?php echo app('translator')->getFromJson('app.logout'); ?>
                    </a>
                    </li>

                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- End Top Navigation -->
        <!-- Left navbar-header -->
    <?php echo $__env->make('sections.super_admin_left_sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- Left navbar-header end -->
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <?php echo $__env->yieldContent('page-title'); ?>

                <!-- .row -->
                <?php echo $__env->yieldContent('content'); ?> 
            </div>
            <!-- /.container-fluid -->
            <footer class="footer text-center"> <?php echo e(\Carbon\Carbon::now()->year); ?> &copy; <?php echo e($global->company_name); ?> </footer>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

     
    <div class="modal fade bs-modal-md in" id="projectTimerModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
     
    <div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                Loading ...
            </div>
        </div>
    </div>
    


    <!-- jQuery -->
    <script src="<?php echo e(asset('plugins/bower_components/jquery/dist/jquery.min.js')); ?>"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo e(asset('bootstrap/dist/js/bootstrap.min.js')); ?>"></script>
    <script src='//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/js/bootstrap-select.min.js'></script>

    <!-- Sidebar menu plugin JavaScript -->
    <script src="<?php echo e(asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js')); ?>"></script>
    <!--Slimscroll JavaScript For custom scroll-->
    <script src="<?php echo e(asset('js/jquery.slimscroll.js')); ?>"></script>
    <!--Wave Effects -->
    <script src="<?php echo e(asset('js/waves.js')); ?>"></script>
    <!-- Custom Theme JavaScript -->
    <script src="<?php echo e(asset('plugins/bower_components/sweetalert/sweetalert.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/custom.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jasny-bootstrap.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/froiden-helper/helper.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/bower_components/toast-master/js/jquery.toast.js')); ?>"></script>

    
    <script src="<?php echo e(asset('js/cbpFWTabs.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/bower_components/icheck/icheck.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/bower_components/icheck/icheck.init.js')); ?>"></script>

    <script>
        function addOrEditStickyNote(id)
    {
        var url = '';
        var method = 'POST';
        if(id === undefined || id == "" || id == null) {
            url =  '<?php echo e(route('admin.sticky-note.store')); ?>'
        } else{

            url = "<?php echo e(route('admin.sticky-note.update',':id')); ?>";
            url = url.replace(':id', id);
            var stickyID = $('#stickyID').val();
            method = 'PUT'
        }

        var noteText = $('#notetext').val();
        var stickyColor = $('#stickyColor').val();
        $.easyAjax({
            url: url,
            container: '#responsive-modal',
            type: method,
            data:{'notetext':noteText,'stickyColor':stickyColor,'_token':'<?php echo e(csrf_token()); ?>'},
            success: function (response) {
                $("#responsive-modal").modal('hide');
                getNoteData();
            }
        })
    }

    // FOR SHOWING FEEDBACK DETAIL IN MODEL
    function showCreateNoteModal(){
        var url = '<?php echo e(route('admin.sticky-note.create')); ?>';

        $("#responsive-modal").removeData('bs.modal').modal({
            remote: url,
            show: true
        });

        $('#responsive-modal').on('hidden.bs.modal', function () {
            $(this).find('.modal-body').html('Loading...');
            $(this).data('bs.modal', null);
        });

        return false;
    }

    // FOR SHOWING FEEDBACK DETAIL IN MODEL
    function showEditNoteModal(id){
        var url = '<?php echo e(route('admin.sticky-note.edit',':id')); ?>';
        url  = url.replace(':id',id);

        $("#responsive-modal").removeData('bs.modal').modal({
            remote: url,
            show: true
        });

        $('#responsive-modal').on('hidden.bs.modal', function () {
            $(this).find('.modal-body').html('Loading...');
            $(this).data('bs.modal', null);
        });

        return false;
    }

    function selectColor(id){
        $('.icolors li.active ').removeClass('active');
        $('#'+id).addClass('active');
        $('#stickyColor').val(id);

    }


    function deleteSticky(id){

        swal({
            title: "Are you sure?",
            text: "You will not be able to recover the deleted Sticky Note!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel please!",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function(isConfirm){
            if (isConfirm) {

                var url = "<?php echo e(route('admin.sticky-note.destroy',':id')); ?>";
                url = url.replace(':id', id);

                var token = "<?php echo e(csrf_token()); ?>";

                $.easyAjax({
                    type: 'DELETE',
                    url: url,
                    data: {'_token': token},
                    success: function (response) {
                        $('#stickyBox_'+id).hide('slow');
                        $("#responsive-modal").modal('hide');
                        getNoteData();
                    }
                });
            }
        });
    }


    //getting all chat data according to user
    function getNoteData(){

        var url = "<?php echo e(route('admin.sticky-note.index')); ?>";

        $.easyAjax({
            type: 'GET',
            url: url,
            messagePosition: '',
            data:  {},
            container: ".noteBox",
            error: function (response) {

                //set notes in box
                $('#sticky-note-list').html(response.responseText);
            }
        });
    }

    </script>


    <script>
        $('#mark-notification-read').click(function () {
        var token = '<?php echo e(csrf_token()); ?>';
        $.easyAjax({
            type: 'POST',
            url: '<?php echo e(route("mark-superadmin-notification-read")); ?>',
            data: {'_token': token},
            success: function (data) {
                if (data.status == 'success') {
                    $('.top-notifications').remove();
                    $('#top-notification-count').html('0');
                    $('#top-notification-dropdown .notify').remove();
                }
            }
        });

    });

    $('.show-all-notifications').click(function () {
        var url = '<?php echo e(route('show-all-super-admin-notifications')); ?>';
        $('#modelHeading').html('View Unread Notifications');
        $.ajaxModal('#projectTimerModal', url);
    });

    $('.submit-search').click(function () {
        $(this).parent().submit();
    });

    $(function () {
        $('.selectpicker').selectpicker();
    });

    $('.language-switcher').change(function () {
        var lang = $(this).val();
        $.easyAjax({
            url: '<?php echo e(route("admin.settings.change-language")); ?>',
            data: {'lang': lang},
            success: function (data) {
                if (data.status == 'success') {
                    window.location.reload();
                }
            }
        });
    });
    
//    sticky notes script
    var stickyNoteOpen = $('#open-sticky-bar');
    var stickyNoteClose = $('#close-sticky-bar');
    var stickyNotes = $('#footer-sticky-notes');
    var viewportHeight = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
    var stickyNoteHeaderHeight = stickyNotes.height();

    $('#sticky-note-list').css('max-height', viewportHeight-150);

    stickyNoteOpen.click(function () {
        $('#sticky-note-list').toggle(function () {
            $(this).animate({
                height: (viewportHeight-150)
            })
        });
        stickyNoteClose.toggle();
        stickyNoteOpen.toggle();
    })

    stickyNoteClose.click(function () {
        $('#sticky-note-list').toggle(function () {
            $(this).animate({
                height: 0
            })
        });
        stickyNoteOpen.toggle();
        stickyNoteClose.toggle();
    })



    $('body').on('click', '.right-side-toggle', function () {
        $(".right-sidebar").slideDown(50).removeClass("shw-rside");
    })

    function updateOnesignalPlayerId(userId) {
        $.easyAjax({
            url: '<?php echo e(route("super-admin.profile.updateOneSignalId")); ?>',
            type: 'POST',
            data:{'userId':userId, '_token':'<?php echo e(csrf_token()); ?>'},
            success: function (response) {
            }
        })
    }

    </script>
    <?php echo $__env->yieldPushContent('footer-script'); ?>

</body>

</html><?php /**PATH /var/www/html/resources/views/layouts/super-admin.blade.php ENDPATH**/ ?>