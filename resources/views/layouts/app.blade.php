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

    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

    <title>@lang('app.adminPanel') | {{ __($pageTitle) }}</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel='stylesheet prefetch'
          href='https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/0.8.2/css/flag-icon.min.css'>
    <link rel='stylesheet prefetch'
          href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/css/bootstrap-select.min.css'>

    <!-- This is Sidebar menu CSS -->
    <link href="{{ asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">

    <link href="{{ asset('plugins/bower_components/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bower_components/sweetalert/sweetalert.css') }}" rel="stylesheet">

    <!-- This is a Animation CSS -->
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">

    @stack('head-script')

            <!-- This is a Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- color CSS you can use different color css from css/colors folder -->
    <!-- We have chosen the skin-blue (default.css) for this starter
       page. However, you can choose any other skin from folder css / colors .
       -->
    <link href="{{ asset('css/colors/default.css') }}" id="theme" rel="stylesheet">
    <link href="{{ asset('plugins/froiden-helper/helper.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    @if(file_exists(public_path().'/css/admin-custom.css'))
    <link href="{{ asset('css/admin-custom.css') }}" rel="stylesheet">
    @endif


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    @if($pushSetting->status == 'active')
    <link rel="manifest" href="{{ asset('manifest.json') }}" />
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async='async'></script>
    <script>
        var OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
            OneSignal.init({
                appId: "{{ $pushSetting->onesignal_app_id }}",
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
                            let db_onesignal_id = '{{ $user->onesignal_player_id }}';

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
                        let db_onesignal_id = '{{ $user->onesignal_player_id }}';
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
    @endif

    @if($global->active_theme == 'custom')
    {{--Custom theme styles--}}
    <style>
        .navbar-header {
            background: {{ $adminTheme->header_color }};
        }

        .sidebar .notify  {
            margin: 0 !important;
        }
        .sidebar .notify .heartbit {
            border: 5px solid {{ $adminTheme->header_color }} !important;
            top: -23px !important;
            right: -15px !important;
        }
        .sidebar .notify .point {
            background-color: {{ $adminTheme->header_color }} !important;
            top: -13px !important;
        }

        .navbar-top-links > li > a {
            color: {{ $adminTheme->link_color }};
        }
        /*Right panel*/
        .right-sidebar .rpanel-title {
            background: {{ $adminTheme->header_color }};
        }
        /*Bread Crumb*/
        .bg-title .breadcrumb .active {
            color: {{ $adminTheme->header_color }};
        }
        /*Sidebar*/
        .sidebar {
            background: {{ $adminTheme->sidebar_color }};
            box-shadow: 1px 0px 20px rgba(0, 0, 0, 0.08);
        }
        .sidebar .label-custom {
            background: {{ $adminTheme->header_color }};
        }
        #side-menu li a {
            color: {{ $adminTheme->sidebar_text_color }} !important;
            border-left: 0 solid {{ $adminTheme->sidebar_color }};
        }
        #side-menu > li > a:hover,
        #side-menu > li > a:focus {
            background: rgba(0, 0, 0, 0.07);
        }
        #side-menu > li > a.active {
            border-left: 3px solid {{ $adminTheme->header_color }};
            color: {{ $adminTheme->link_color }};
        }
        #side-menu > li > a.active i {
            color: {{ $adminTheme->link_color }};
        }
        #side-menu ul > li > a:hover {
            color: {{ $adminTheme->link_color }};
        }
        #side-menu ul > li > a.active {
            color: {{ $adminTheme->link_color }};
        }
        .sidebar #side-menu .user-pro .nav-second-level a:hover {
            color: {{ $adminTheme->header_color }};
        }
        .nav-small-cap {
            color: {{ $adminTheme->sidebar_text_color }};
        }
        .content-wrapper .sidebar .nav-second-level li {
            background: #444859;
        }
        @media (min-width: 768px) {
            .content-wrapper #side-menu ul,
            .content-wrapper .sidebar #side-menu > li:hover,
            .content-wrapper .sidebar .nav-second-level > li > a {
                background: #444859;
            }
        }

        /*themecolor*/
        .bg-theme {
            background-color: {{ $adminTheme->header_color }} !important;
        }
        .bg-theme-dark {
            background-color: {{ $adminTheme->sidebar_color }} !important;
        }
        /*Chat widget*/
        .chat-list .odd .chat-text {
            background: {{ $adminTheme->header_color }};
        }
        /*Button*/
        .btn-custom {
            background: {{ $adminTheme->header_color }};
            border: 1px solid {{ $adminTheme->header_color }};
            color: {{ $adminTheme->link_color }};
        }
        .btn-custom:hover {
            background: {{ $adminTheme->header_color }};
            border: 1px solid {{ $adminTheme->header_color }};
        }
        /*Custom tab*/
        .customtab li.active a,
        .customtab li.active a:hover,
        .customtab li.active a:focus {
            border-bottom: 2px solid {{ $adminTheme->header_color }};
            color: {{ $adminTheme->header_color }};
        }
        .tabs-vertical li.active a,
        .tabs-vertical li.active a:hover,
        .tabs-vertical li.active a:focus {
            background: {{ $adminTheme->header_color }};
            border-right: 2px solid {{ $adminTheme->header_color }};
        }
        /*Nav-pills*/
        .nav-pills > li.active > a,
        .nav-pills > li.active > a:focus,
        .nav-pills > li.active > a:hover {
            background: {{ $adminTheme->header_color }};
            color: {{ $adminTheme->link_color }};
        }

        .admin-panel-name{
            background: {{ $adminTheme->header_color }};
        }

        /*fullcalendar css*/
        .fc th.fc-widget-header{
            background: {{ $adminTheme->sidebar_color }};
        }

        .fc-button{
            background: {{ $adminTheme->header_color }};
            color: {{ $adminTheme->link_color }};
            margin-left: 2px !important;
        }

        .fc-unthemed .fc-today{
            color: #757575 !important;
        }

        .user-pro{
            background-color: {{ $adminTheme->sidebar_color }};
        }


        .top-left-part{
            background: {{ $adminTheme->sidebar_color }};
        }

        .notify .heartbit{
            border: 5px solid {{ $adminTheme->sidebar_color }};
        }

        .notify .point{
            background-color: {{ $adminTheme->sidebar_color }};
        }
    </style>

    <style>
        {!! $adminTheme->user_css !!}
    </style>
    {{--Custom theme styles end--}}
    @endif

    <style>
        .sidebar .notify  {
        margin: 0 !important;
        }
        .sidebar .notify .heartbit {
        top: -23px !important;
        right: -15px !important;
        }
        .sidebar .notify .point {
        top: -13px !important;
        }
        .top-notifications .message-center .user-img{
            margin: 0 0 0 0 !important;
        }

        .mr-5 {
            margin-right: 5px;
        }
    </style>


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
            <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse"
               data-target=".navbar-collapse"><i class="ti-menu"></i></a>

            <div class="top-left-part">
                <!-- Logo -->
                <a class="logo hidden-xs hidden-sm text-center" href="{{ route('admin.dashboard') }}">
                    @if(is_null($global->logo))
                            <!--This is dark logo icon-->
                    <img src="{{ asset('worksuite-logo.png') }}" alt="home" class=" admin-logo"/>
                    @else
                        <img src="{{ asset('user-uploads/app-logo/'.$global->logo) }}" alt="home" />
                    @endif
                </a>

                <div class="admin-panel-name hidden-xs">@lang('app.adminPanel')</div>
            </div>
            <!-- /Logo -->
            <!-- Search input and Toggle icon -->
            <ul class="nav navbar-top-links navbar-left hidden-xs">
                <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i
                                class="icon-arrow-left-circle ti-menu"></i></a></li>
                <li>
                    <form role="search" action="{{ route('admin.search.store') }}" novalidate method="POST"
                          class="app-search hidden-xs">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="text" name="search_key" value="{{ $searchKey ?? '' }}" autocomplete="off" required
                               placeholder="@lang('app.search')" class="form-control">
                        <a href="javascript:;" class="submit-search"><i class="fa fa-search"></i></a>
                    </form>
                </li>
                <!-- .Task dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle waves-effect waves-light text-uppercase" data-toggle="dropdown" href="#">
                        @lang('app.add') <i class="ti-plus"></i>
                    </a>
                    <ul class="dropdown-menu mailbox">

                        @if(in_array('projects',$modules))
                        <li class="top-notifications">
                            <div class="message-center">
                                <a href="{{ route('admin.projects.create') }}">
                                    <div class="mail-contnet">
                                        <span class="mail-desc m-0">@lang('app.add') @lang('app.project')</span>
                                    </div>
                                </a>
                            </div>
                        </li>
                        @endif

                        @if(in_array('tasks',$modules))
                        <li class="top-notifications">
                            <div class="message-center">
                                <a href="{{ route('admin.all-tasks.create') }}">
                                    <div class="mail-contnet">
                                        <span class="mail-desc m-0">@lang('app.add') @lang('app.task')</span>
                                    </div>
                                </a>
                            </div>
                        </li>
                        @endif

                        @if(in_array('clients',$modules))
                        <li class="top-notifications">
                            <div class="message-center">
                                <a href="{{ route('admin.clients.create') }}">
                                    <div class="mail-contnet">
                                        <span class="mail-desc m-0">@lang('app.add') @lang('app.client')</span>
                                    </div>
                                </a>
                            </div>
                        </li>
                        @endif

                        @if(in_array('employees',$modules))
                        <li class="top-notifications">
                            <div class="message-center">
                                <a href="{{ route('admin.employees.create') }}">
                                    <div class="mail-contnet">
                                        <span class="mail-desc m-0">@lang('app.add') @lang('app.employee')</span>
                                    </div>
                                </a>
                            </div>
                        </li>
                        @endif

                        @if(in_array('tickets',$modules))
                        <li class="top-notifications">
                            <div class="message-center">
                                <a href="{{ route('admin.tickets.create') }}">
                                    <div class="mail-contnet">
                                        <span class="mail-desc m-0">@lang('app.add') @lang('modules.tickets.ticket')</span>
                                    </div>
                                </a>
                            </div>
                        </li>
                        @endif

                    </ul>
                </li>
                <!-- /.Task dropdown -->
                @if($company->package->default == 'yes' || $company->package->default == 'trial')
                    <li class="dropdown">
                        <a class="waves-effect waves-light text-uppercase" href="{{ route('admin.billing') }}">
                            @lang('app.purchasePackage') <i class="fa fa-arrow-right"></i>
                        </a>
                    </li>
                @endif
            </ul>
            <!-- This is the message dropdown -->
            <ul class="nav navbar-top-links navbar-right pull-right">

                <li class="dropdown">
                    <select class="selectpicker language-switcher" data-width="fit">
                        <option value="en" @if($global->locale == "en") selected @endif data-content='<span class="flag-icon flag-icon-us"></span> En'>En</option>
                        @foreach($languageSettings as $language)
                            <option value="{{ $language->language_code }}" @if($global->locale == $language->language_code) selected @endif  data-content='<span class="flag-icon flag-icon-{{ $language->language_code }}"></span> {{ $language->language_code }}'>{{ $language->language_code }}</option>
                        @endforeach
                    </select>
                </li>

                <!-- .Task dropdown -->
                <li class="dropdown" id="top-notification-dropdown">
                    <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#">
                        <i class="icon-bell"></i>
                        @if(count($user->unreadNotifications) > 0)
                            <div class="notify"><span class="heartbit"></span><span class="point"></span></div>
                        @endif
                    </a>
                    <ul class="dropdown-menu mailbox animated slideInDown">
                        <li>
                            <div class="drop-title">@lang('app.newNotifications') <span
                                        id="top-notification-count">{{ count($user->unreadNotifications) }}</span>
                            </div>
                        </li>
                        @foreach ($user->unreadNotifications as $notification)
                            @include('notifications.member.'.snake_case(class_basename($notification->type)))
                        @endforeach

                        @if(count($user->unreadNotifications) > 0)
                            <li>
                                <a class="text-center" id="mark-notification-read"
                                   href="javascript:;"> @lang('app.markRead') <i class="fa fa-check"></i> </a>
                            </li>
                        @endif
                    </ul>
                </li>
                <!-- /.Task dropdown -->


                <li class="dropdown">
                    <a href="{{ route('logout') }}" title="Logout" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                    ><i class="fa fa-power-off"></i> @lang('app.logout')
                    </a>
                </li>

            </ul>
            @if(in_array('timelogs',$user->modules) && isset($activeTimerCount))
            <span id="timer-section">
                <div class="nav navbar-top-links navbar-right pull-right m-t-10">
                    <a class="btn btn-rounded btn-default timer-modal" href="javascript:;">@lang("modules.projects.activeTimers") 
                        <span class="label label-danger" id="activeCurrentTimerCount">@if($activeTimerCount > 0) {{ $activeTimerCount }} @else 0 @endif</span>
                    </a>
                </div>
            </span>
            @endif
        </div>
        <!-- /.navbar-header -->
        <!-- /.navbar-top-links -->
        <!-- /.navbar-static-side -->
    </nav>
    <!-- End Top Navigation -->
    <!-- Left navbar-header -->
    @include('sections.left_sidebar')
            <!-- Left navbar-header end -->
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            @yield('page-title')

                    <!-- .row -->
            @yield('content')

            @include('sections.right_sidebar')
        </div>
        <!-- /.container-fluid -->
        <footer class="footer text-center"> {{ \Carbon\Carbon::now()->year }} &copy;  {{ $superadmin->company_name }} </footer>
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->

{{--Footer sticky notes--}}
<div id="footer-sticky-notes" class="row hidden-xs hidden-sm">
    <div class="col-md-12" id="sticky-note-header">
        <div class="col-xs-10" style="line-height: 30px">
        @lang('app.menu.stickyNotes') <a href="javascript:;" onclick="showCreateNoteModal()" class="btn btn-success btn-outline btn-xs m-l-10"><i class="fa fa-plus"></i> @lang("modules.sticky.addNote")</a>
            </div>
        <div class="col-xs-2">
            <a href="javascript:;" class="btn btn-default btn-circle pull-right" id="open-sticky-bar"><i class="fa fa-chevron-up"></i></a>
            <a style="display: none;" class="btn btn-default btn-circle pull-right" href="javascript:;" id="close-sticky-bar"><i class="fa fa-chevron-down"></i></a>
        </div>

    </div>

    <div id="sticky-note-list" style="display: none">

        @foreach($stickyNotes as $note)
            <div class="col-md-12 sticky-note" id="stickyBox_{{$note->id}}">
            <div class="well
             @if($note->colour == 'red')
                bg-danger
             @endif
             @if($note->colour == 'green')
                bg-success
             @endif
             @if($note->colour == 'yellow')
                bg-warning
             @endif
             @if($note->colour == 'blue')
                bg-info
             @endif
             @if($note->colour == 'purple')
                bg-purple
             @endif
             b-none">
                <p>{!! nl2br($note->note_text)  !!}</p>
                <hr>
                <div class="row font-12">
                    <div class="col-xs-9">
                        @lang("modules.sticky.lastUpdated"): {{ $note->updated_at->diffForHumans() }}
                    </div>
                    <div class="col-xs-3">
                        <a href="javascript:;"  onclick="showEditNoteModal({{$note->id}})"><i class="ti-pencil-alt text-white"></i></a>
                        <a href="javascript:;" class="m-l-5" onclick="deleteSticky({{$note->id}})" ><i class="ti-close text-white"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>
{{--sticky note end--}}

{{--Timer Modal--}}
<div class="modal fade bs-modal-md in" id="projectTimerModal" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" id="modal-data-application">
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
{{--Timer Modal Ends--}}

{{--sticky note modal--}}
<div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            Loading ...
        </div>
    </div>
</div>
{{--sticky note modal ends--}}
{{--Timer Modal--}}
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
{{--Timer Modal Ends--}}

<!-- jQuery -->
<script src="{{ asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src='//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/js/bootstrap-select.min.js'></script>

<!-- Sidebar menu plugin JavaScript -->
<script src="{{ asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
<!--Slimscroll JavaScript For custom scroll-->
<script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
<!--Wave Effects -->
<script src="{{ asset('js/waves.js') }}"></script>
<!-- Custom Theme JavaScript -->
<script src="{{ asset('plugins/bower_components/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/custom.min.js') }}"></script>
<script src="{{ asset('js/jasny-bootstrap.js') }}"></script>
<script src="{{ asset('plugins/froiden-helper/helper.js') }}"></script>
<script src="{{ asset('plugins/bower_components/toast-master/js/jquery.toast.js') }}"></script>

{{--sticky note script--}}
<script src="{{ asset('js/cbpFWTabs.js') }}"></script>
<script src="{{ asset('plugins/bower_components/icheck/icheck.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/icheck/icheck.init.js') }}"></script>
<script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('js/jquery.magnific-popup-init.js') }}"></script>

<script>

    $('body').on('click', '.timer-modal', function(){
        var url = '{{ route('admin.all-time-logs.show-active-timer')}}';
        $('#modelHeading').html('Active Timer');
        $.ajaxModal('#projectTimerModal',url);
    });

    function addOrEditStickyNote(id)
    {
        var url = '';
        var method = 'POST';
        if(id === undefined || id == "" || id == null) {
            url =  '{{ route('admin.sticky-note.store') }}'
        } else{

            url = "{{ route('admin.sticky-note.update',':id') }}";
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
            data:{'notetext':noteText,'stickyColor':stickyColor,'_token':'{{ csrf_token() }}'},
            success: function (response) {
                $("#responsive-modal").modal('hide');
                getNoteData();
            }
        })
    }

    // FOR SHOWING FEEDBACK DETAIL IN MODEL
    function showCreateNoteModal(){
        var url = '{{ route('admin.sticky-note.create') }}';

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
        var url = '{{ route('admin.sticky-note.edit',':id') }}';
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

                var url = "{{ route('admin.sticky-note.destroy',':id') }}";
                url = url.replace(':id', id);

                var token = "{{ csrf_token() }}";

                $.easyAjax({
                    type: 'POST',
                    url: url,
                    data: {'_token': token, '_method': 'DELETE'},
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

        var url = "{{ route('admin.sticky-note.index') }}";

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
        var token = '{{ csrf_token() }}';
        $.easyAjax({
            type: 'POST',
            url: '{{ route("mark-notification-read") }}',
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
        var url = '{{ route('show-all-member-notifications')}}';
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
            url: '{{ route("admin.settings.change-language") }}',
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
            url: '{{ route("member.profile.updateOneSignalId") }}',
            type: 'POST',
            data:{'userId':userId, '_token':'{{ csrf_token() }}'},
            success: function (response) {
            }
        })
    }
    

</script>
@stack('footer-script')

</body>
</html>
