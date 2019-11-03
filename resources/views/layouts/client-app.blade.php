<!DOCTYPE html>
<!--
   This is a starter template page. Use this page to start your new project from
   scratch. This page gets rid of all links and provides the needed markup only.
   -->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

    <title>Client Panel | {{ __($pageTitle) }}</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel='stylesheet prefetch'
          href='https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/0.8.2/css/flag-icon.min.css'>
    <link rel='stylesheet prefetch'
          href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/css/bootstrap-select.min.css'>

    <!-- This is Sidebar menu CSS -->
    <link href="{{ asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">

    <link href="{{ asset('plugins/bower_components/toast-master/css/jquery.toast.css') }}"   rel="stylesheet">
    <link href="{{ asset('plugins/bower_components/sweetalert/sweetalert.css') }}"   rel="stylesheet">

    <!-- This is a Animation CSS -->
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">

    @stack('head-script')

    <!-- This is a Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- color CSS you can use different color css from css/colors folder -->
    <!-- We have chosen the skin-blue (default.css) for this starter
       page. However, you can choose any other skin from folder css / colors .
       -->
    <link href="{{ asset('css/colors/default.css') }}" id="theme"  rel="stylesheet">
    <link href="{{ asset('plugins/froiden-helper/helper.css') }}"   rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}"   rel="stylesheet">
    {{-- <link href="{{ asset('css/client-custom.css') }}"   rel="stylesheet"> --}}


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    @if($global->active_theme == 'custom')
    {{--Custom theme styles--}}
    <style>
        .navbar-header {
            background: {{ $clientTheme->header_color }};
        }
        .sidebar .notify  {
            margin: 0 !important;
        }
        .sidebar .notify .heartbit {
            border: 5px solid {{ $clientTheme->header_color }} !important;
            top: -23px !important;
            right: -15px !important;
        }
        .sidebar .notify .point {
            background-color: {{ $clientTheme->header_color }} !important;
            top: -13px !important;
        }
        .navbar-top-links > li > a {
            color: {{ $clientTheme->link_color }};
        }
        /*Right panel*/
        .right-sidebar .rpanel-title {
            background: {{ $clientTheme->header_color }};
        }
        /*Bread Crumb*/
        .bg-title .breadcrumb .active {
            color: {{ $clientTheme->header_color }};
        }
        /*Sidebar*/
        .sidebar {
            background: {{ $clientTheme->sidebar_color }};
            box-shadow: 1px 0px 20px rgba(0, 0, 0, 0.08);
        }
        .sidebar .label-custom {
            background: {{ $clientTheme->header_color }};
        }
        #side-menu li a {
            color: {{ $clientTheme->sidebar_text_color }};
        }
        #side-menu li a {
            color: {{ $clientTheme->sidebar_text_color }};
            border-left: 0px solid {{ $clientTheme->sidebar_color }};
        }
        #side-menu > li > a:hover,
        #side-menu > li > a:focus {
            background: rgba(0, 0, 0, 0.07);
        }
        #side-menu > li > a.active {
            border-left: 3px solid {{ $clientTheme->header_color }};
            color: {{ $clientTheme->link_color }};
        }
        #side-menu > li > a.active i {
            color: {{ $clientTheme->link_color }};
        }
        #side-menu ul > li > a:hover {
            color: {{ $clientTheme->link_color }};
        }
        #side-menu ul > li > a.active {
            color: {{ $clientTheme->link_color }};
        }
        .sidebar #side-menu .user-pro .nav-second-level a:hover {
            color: {{ $clientTheme->header_color }};
        }
        .nav-small-cap {
            color: {{ $clientTheme->sidebar_text_color }};
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
            background-color: {{ $clientTheme->header_color }} !important;
        }
        .bg-theme-dark {
            background-color: {{ $clientTheme->sidebar_color }} !important;
        }
        /*Chat widget*/
        .chat-list .odd .chat-text {
            background: {{ $clientTheme->header_color }};
        }
        /*Button*/
        .btn-custom {
            background: {{ $clientTheme->header_color }};
            border: 1px solid {{ $clientTheme->header_color }};
            color: {{ $clientTheme->link_color }};
        }
        .btn-custom:hover {
            background: {{ $clientTheme->header_color }};
            border: 1px solid {{ $clientTheme->header_color }};
        }
        /*Custom tab*/
        .customtab li.active a,
        .customtab li.active a:hover,
        .customtab li.active a:focus {
            border-bottom: 2px solid {{ $clientTheme->header_color }};
            color: {{ $clientTheme->header_color }};
        }
        .tabs-vertical li.active a,
        .tabs-vertical li.active a:hover,
        .tabs-vertical li.active a:focus {
            background: {{ $clientTheme->header_color }};
            border-right: 2px solid {{ $clientTheme->header_color }};
        }
        /*Nav-pills*/
        .nav-pills > li.active > a,
        .nav-pills > li.active > a:focus,
        .nav-pills > li.active > a:hover {
            background: {{ $clientTheme->header_color }};
            color: {{ $clientTheme->link_color }};
        }

        .client-panel-name{
            background: {{ $clientTheme->header_color }};
        }

        /*fullcalendar css*/
        .fc th.fc-widget-header{
            background: {{ $clientTheme->sidebar_color }};
        }

        .fc-button{
            background: {{ $clientTheme->header_color }};
            color: {{ $clientTheme->link_color }};
            margin-left: 2px !important;
        }

        .fc-unthemed .fc-today{
            color: #757575 !important;
        }

        .user-pro{
            background-color: {{ $clientTheme->sidebar_color }};
        }

        .top-left-part{
            background: {{ $clientTheme->sidebar_color }};
        }

        .notify .heartbit{
            border: 5px solid {{ $clientTheme->sidebar_color }};
        }

        .notify .point{
            background-color: {{ $clientTheme->sidebar_color }};
        }

    </style>

    <style>
        {!! $clientTheme->user_css !!}
    </style>
    @endif
    {{--Custom theme styles end--}}

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
            <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
            <div class="top-left-part">
                <!-- Logo -->
                <a class="logo hidden-xs hidden-sm text-center" href="{{ route('client.dashboard.index') }}">
                    <!-- Logo icon image, you can use font-icon also -->
                        @if(is_null($global->logo))
                        <!--This is dark logo icon-->
                            <img src="{{ asset('worksuite-logo.png') }}" alt="home" class=" client-logo" />
                        @else
                            <img src="{{ asset('user-uploads/app-logo/'.$global->logo) }}" alt="home" />
                        @endif
                    <!-- Logo text image you can use text also -->
                </a>

                <div class="client-panel-name hidden-xs">@lang('app.clientPanel')</div>
            </div>
            <!-- /Logo -->
            <!-- Search input and Toggle icon -->
            <ul class="nav navbar-top-links navbar-left hidden-xs">
                <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i class="icon-arrow-left-circle ti-menu"></i></a></li>
                {{--<li>--}}
                    {{--<form role="search" class="app-search hidden-xs">--}}
                        {{--<input type="text" placeholder="Search..." class="form-control">--}}
                        {{--<a href=""><i class="fa fa-search"></i></a>--}}
                    {{--</form>--}}
                {{--</li>--}}

            </ul>
            <!-- This is the message dropdown -->
            <ul class="nav navbar-top-links navbar-right pull-right">
                @if ($company_details->count() > 1)
                    <li class="dropdown">
                        <select class="selectpicker company-switcher" data-width="fit" name="companies" id="companies">
                            @foreach ($company_details as $company_detail)
                                <option {{ $company_detail->company->id === $global->id ? 'selected' : '' }} value="{{ $company_detail->company->id }}">{{ ucfirst($company_detail->company->company_name) }}</option>
                            @endforeach
                        </select>
                    </li>
                @endif

                <li class="dropdown">
                    <select class="selectpicker language-switcher" data-width="fit">
                        <option value="en" @if($user->locale == "en") selected @endif data-content='<span class="flag-icon flag-icon-us"></span> En'>En</option>
                        @foreach($languageSettings as $language)
                            <option value="{{ $language->language_code }}" @if($user->locale == $language->language_code) selected @endif  data-content='<span class="flag-icon flag-icon-{{ $language->language_code }}"></span> {{ $language->language_code }}'>{{ $language->language_code }}</option>
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
                            @include('notifications.client.'.snake_case(class_basename($notification->type)))
                        @endforeach

                        @if(count($user->unreadNotifications) > 0)
                            <li>
                                <a class="text-center" id="mark-notification-read" href="javascript:;"> @lang('app.markRead') <i class="fa fa-check"></i> </a>
                            </li>
                        @endif
                    </ul>
                </li>
                <!-- /.Task dropdown -->
                </li>
                <!-- /.dropdown -->

                <li class="dropdown">
                    <a href="{{ route('logout') }}" title="Logout" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                    ><i class="fa fa-power-off"></i> @lang('app.logout')
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
    @include('sections.client_left_sidebar')
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
        <footer class="footer text-center"> {{ \Carbon\Carbon::now()->year }} &copy; {{ $companyName }} </footer>
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

{{--sticky note modal--}}
<div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            Loading ...
        </div>
    </div>
</div>
{{--sticky note modal ends--}}

<!-- jQuery -->
<script src="{{ asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/js/bootstrap-select.min.js'></script>

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
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>

    function addOrEditStickyNote(id)
    {
        var url = '';
        var method = 'POST';
        if(id === undefined || id == "" || id == null) {
            url =  '{{ route('client.sticky-note.store') }}'
        } else{

            url = "{{ route('client.sticky-note.update',':id') }}";
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
        var url = '{{ route('client.sticky-note.create') }}';

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
        var url = '{{ route('client.sticky-note.edit',':id') }}';
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

                var url = "{{ route('client.sticky-note.destroy',':id') }}";
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

        var url = "{{ route('client.sticky-note.index') }}";

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

</script>

<script>
    $('body').on('click', '.timer-modal', function(){
        var url = '{{ route('member.time-log.create')}}';
        $('#modelHeading').html('Start Timer For a Project');
        $.ajaxModal('#projectTimerModal',url);
    });

    $('body').on('click', '.stop-timer-modal', function(){
        var url = '{{ route('member.time-log.show', ':id')}}';
        url = url.replace(':id', $(this).data('timer-id'));

        $('#modelHeading').html('Stop Timer');
        $.ajaxModal('#projectTimerModal',url);
    });

    $('#mark-notification-read').click(function () {
        var token = '{{ csrf_token() }}';
        $.easyAjax({
            type: 'POST',
            url: '{{ route("mark-notification-read") }}',
            data: {'_token': token},
            success: function (data) {
                if(data.status == 'success'){
                    $('.top-notifications').remove();
                    $('#top-notification-count').html('0');
                    $('#top-notification-dropdown .notify').remove();
                }
            }
        });

    });

    $('.show-all-notifications').click(function () {
        var url = '{{ route('show-all-client-notifications')}}';
        $('#modelHeading').html('View Unread Notifications');
        $.ajaxModal('#projectTimerModal',url);
    });

    $(function () {
        $('.selectpicker').selectpicker();
    });

    $('.language-switcher').change(function () {
        var lang = $(this).val();
        $.easyAjax({
            url: '{{ route("client.language.change-language") }}',
            data: {'lang': lang},
            success: function (data) {
                if (data.status == 'success') {
                    window.location.reload();
                }
            }
        });
    });

    $('.company-switcher').change(function () {
        var company_id = $(this).val();
        $.easyAjax({
            url: '{{ route("client.company.change-company") }}',
            data: {'company_id': company_id},
            success: function (data) {
                if (data.status == 'success') {
                    const url_split = window.location.pathname.split('/')
                    const new_url = url_split.slice(0, 3).join('/')
                    window.location.href = new_url
                }
            }
        });
    });

    $('body').on('click', '.right-side-toggle', function () {
        $(".right-sidebar").slideDown(50).removeClass("shw-rside");
    })
</script>

@stack('footer-script')

</body>
</html>