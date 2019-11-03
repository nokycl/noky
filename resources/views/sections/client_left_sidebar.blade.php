<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse slimscrollsidebar">
        <!-- .User Profile -->
        <ul class="nav" id="side-menu">
            {{--<li class="sidebar-search hidden-sm hidden-md hidden-lg">--}}
                {{--<!-- / Search input-group this is only view in mobile-->--}}
                {{--<div class="input-group custom-search-form">--}}
                    {{--<input type="text" class="form-control" placeholder="Search...">--}}
                        {{--<span class="input-group-btn">--}}
                        {{--<button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>--}}
                        {{--</span>--}}
                {{--</div>--}}
                {{--<!-- /input-group -->--}}
            {{--</li>--}}

            <li class="user-pro">
                @if(is_null($user->image))
                    <a href="#" class="waves-effect"><img src="{{ asset('default-profile-3.png') }}" alt="user-img" class="img-circle"> <span class="hide-menu">{{ (strlen($user->name) > 24) ? substr(ucwords($user->name), 0, 20).'..' : ucwords($user->name) }}
                            <span class="fa arrow"></span></span>
                    </a>
                @else
                    <a href="#" class="waves-effect"><img src="{{ asset('user-uploads/avatar/'.$user->image) }}" alt="user-img" class="img-circle"> <span class="hide-menu">{{ ucwords($user->name) }}
                            <span class="fa arrow"></span></span>
                    </a>
                @endif
                <ul class="nav nav-second-level">
                    <li><a href="{{ route('client.profile.index') }}"><i class="ti-user"></i> @lang("app.menu.profileSettings")</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                        ><i class="fa fa-power-off"></i> @lang('app.logout')</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>


            <li><a href="{{ route('client.dashboard.index') }}" class="waves-effect"><i class="icon-speedometer"></i> <span class="hide-menu">@lang('app.menu.dashboard') </span></a> </li>

            @if(in_array('projects',$modules))
                <li><a href="{{ route('client.projects.index') }}" class="waves-effect"><i class="icon-layers"></i> <span class="hide-menu">@lang('app.menu.projects') </span> @if($unreadProjectCount > 0) <div class="notify notification-color"><span class="heartbit"></span><span class="point"></span></div>@endif</a> </li>
            @endif

            @if(in_array('tickets',$modules))
                <li><a href="{{ route('client.tickets.index') }}" class="waves-effect"><i class="ti-ticket"></i> <span class="hide-menu">@lang("app.menu.tickets") </span></a> </li>
            @endif

            @if(in_array('invoices',$modules))
                <li><a href="{{ route('client.invoices.index') }}" class="waves-effect"><i class="ti-receipt"></i> <span class="hide-menu">@lang('app.menu.invoices') </span> @if($unreadInvoiceCount > 0) <div class="notify notification-color"><span class="heartbit"></span><span class="point"></span></div>@endif</a> </li>
            @endif

            @if(in_array('estimates',$modules))
                <li><a href="{{ route('client.estimates.index') }}" class="waves-effect"><i class="icon-doc"></i> <span class="hide-menu">@lang('app.menu.estimates') </span> @if($unreadEstimateCount > 0) <div class="notify notification-color"><span class="heartbit"></span><span class="point"></span></div>@endif</a> </li>
            @endif

            @if(in_array('events',$modules))
                <li><a href="{{ route('client.events.index') }}" class="waves-effect"><i class="icon-calender"></i> <span class="hide-menu">@lang('app.menu.Events')</span></a> </li>
            @endif

            @if(in_array('messages',$modules))
            @if($messageSetting->allow_client_admin == 'yes' || $messageSetting->allow_client_employee == 'yes')
            <li><a href="{{ route('client.user-chat.index') }}" class="waves-effect"><i class="icon-envelope"></i> <span class="hide-menu">@lang('app.menu.messages') @if($unreadMessageCount > 0)<span class="label label-rouded label-custom pull-right">{{ $unreadMessageCount }}</span> @endif</span></a> </li>
            @endif
            @endif

        </ul>
    </div>
</div>
