<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse slimscrollsidebar">
        <!-- .User Profile -->
        <ul class="nav" id="side-menu">

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
                    {{--<li><a href="{{ route('client.profile.index') }}"><i class="ti-user"></i> @lang("app.menu.profileSettings")</a></li>
                    <li role="separator" class="divider"></li>--}}
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                        ><i class="fa fa-power-off"></i> @lang('app.logout')</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>

           <li><a href="{{ route('super-admin.dashboard') }}" class="waves-effect"><i class="icon-speedometer"></i> <span class="hide-menu">@lang('app.menu.dashboard') </span></a> </li>

            <li><a href="{{ route('super-admin.profile.index') }}" class="waves-effect"><i class="icon-user"></i> <span class="hide-menu">@lang('modules.employees.profile') </span></a> </li>
            <li><a href="{{ route('super-admin.packages.index') }}" class="waves-effect"><i class="icon-calculator"></i> <span class="hide-menu">@lang('app.menu.packages') </span></a> </li>

            <li><a href="{{ route('super-admin.companies.index') }}" class="waves-effect"><i class="icon-layers"></i> <span class="hide-menu">@lang('app.menu.companies') </span></a> </li>
            <li><a href="{{ route('super-admin.invoices.index') }}" class="waves-effect"><i class="icon-printer"></i> <span class="hide-menu">@lang('app.menu.invoices') </span></a> </li>
            <li><a href="{{ route('super-admin.super-admin.index') }}" class="waves-effect"><i class="fa fa-user-secret"></i> <span class="hide-menu">@lang('app.superAdmin') </span></a> </li>
            <li><a href="{{ route('super-admin.settings.index') }}" class="waves-effect"><i class="icon-settings"></i> <span class="hide-menu">@lang('app.menu.settings') </span></a> </li>
        </ul>
    </div>
</div>
