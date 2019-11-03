<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse slimscrollsidebar">

        <!-- .User Profile -->
        <ul class="nav" id="side-menu">
            <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                <!-- input-group -->
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search..."> <span class="input-group-btn">
                            <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
                            </span> </div>
                <!-- /input-group -->
            </li>
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
                    <li>
                        <a href="{{ route('member.dashboard') }}">
                            <i class="fa fa-sign-in"></i> @lang('app.loginAsEmployee')
                        </a>
                    </li>
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
            <li><a href="{{ route('admin.dashboard') }}" class="waves-effect"><i class="icon-speedometer"></i> <span class="hide-menu">@lang('app.menu.dashboard') </span></a> </li>

            @if(in_array("clients", $modules)  && $company->status != 'license_expired')
                <li><a href="{{ route('admin.clients.index') }}" class="waves-effect"><i class="icon-people"></i> <span class="hide-menu">@lang('app.menu.clients') </span></a> </li>
            @endif
            @if(in_array("leads", $modules)   && $company->status != 'license_expired')
                <li><a href="{{ route('admin.leads.index') }}" class="waves-effect"><i class="ti-receipt"></i> <span class="hide-menu"> @lang('app.menu.lead')</span></a>
                </li>
            @endif
            @if(in_array("projects", $modules)  && $company->status != 'license_expired')
                <li><a href="{{ route('admin.projects.index') }}" class="waves-effect"><i class="icon-layers"></i> <span class="hide-menu">@lang('app.menu.projects') </span></a> </li>
            @endif

            @if(in_array("tasks", $modules)   && $company->status != 'license_expired')
                <li><a href="{{ route('admin.task.index') }}" class="waves-effect"><i class="ti-layout-list-thumb"></i> <span class="hide-menu"> @lang('app.menu.tasks') <span class="fa arrow"></span> </span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="{{ route('admin.all-tasks.index') }}">@lang('app.menu.tasks')</a></li>
                        <li><a href="{{ route('admin.taskboard.index') }}">@lang('modules.tasks.taskBoard')</a></li>
                        <li><a href="{{ route('admin.task-calendar.index') }}">@lang('app.menu.taskCalendar')</a></li>
                    </ul>
                </li>
            @endif


            @if(in_array("products", $modules)  && $company->status != 'license_expired')
                <li><a href="{{ route('admin.products.index') }}" class="waves-effect"><i class="icon-basket"></i> <span class="hide-menu">@lang('app.menu.products') </span></a> </li>
            @endif


            @if((in_array("estimates", $modules)  || in_array("invoices", $modules)  || in_array("payments", $modules) || in_array("expenses", $modules)  ) && $company->status != 'license_expired' )
                <li><a href="{{ route('admin.finance.index') }}" class="waves-effect"><i class="fa fa-money"></i> <span class="hide-menu"> @lang('app.menu.finance') @if($unreadExpenseCount > 0) <div class="notify notification-color"><span class="heartbit"></span><span class="point"></span></div>@endif <span class="fa arrow"></span> </span></a>
                    <ul class="nav nav-second-level">
                        @if(in_array("estimates", $modules)  && $company->status != 'license_expired')
                            <li><a href="{{ route('admin.estimates.index') }}">@lang('app.menu.estimates')</a> </li>
                        @endif

                        @if(in_array("invoices", $modules)  && $company->status != 'license_expired')
                            <li><a href="{{ route('admin.all-invoices.index') }}">@lang('app.menu.invoices')</a> </li>
                        @endif

                        @if(in_array("payments", $modules)  && $company->status != 'license_expired')
                            <li><a href="{{ route('admin.payments.index') }}">@lang('app.menu.payments')</a> </li>
                        @endif

                        @if(in_array("expenses", $modules)  && $company->status != 'license_expired')
                            <li><a href="{{ route('admin.expenses.index') }}">@lang('app.menu.expenses') @if($unreadExpenseCount > 0) <div class="notify notification-color"><span class="heartbit"></span><span class="point"></span></div>@endif</a> </li>
                        @endif

                        @if(in_array("invoices", $modules)  && $company->status != 'license_expired')
                            <li><a href="{{ route('admin.all-credit-notes.index') }}">@lang('app.menu.credit-note')</a> </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if(in_array("timelogs", $modules)  && $company->status != 'license_expired')
                <li><a href="{{ route('admin.all-time-logs.index') }}" class="waves-effect"><i class="icon-clock"></i> <span class="hide-menu">@lang('app.menu.timeLogs') </span></a> </li>
            @endif

            @if(in_array("tickets", $modules)  && $company->status != 'license_expired')
                <li><a href="{{ route('admin.tickets.index') }}" class="waves-effect"><i class="ti-ticket"></i> <span class="hide-menu">@lang('app.menu.tickets')</span> @if($unreadTicketCount > 0) <div class="notify notification-color"><span class="heartbit"></span><span class="point"></span></div>@endif</a> </li>
            @endif


            @if(in_array("employees", $modules)  && $company->status != 'license_expired')
                <li><a href="{{ route('admin.employees.index') }}" class="waves-effect"><i class="ti-user"></i> <span class="hide-menu"> @lang('app.menu.employees') <span class="fa arrow"></span> </span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="{{ route('admin.employees.index') }}">@lang('app.menu.employeeList')</a></li>
                        <li><a href="{{ route('admin.teams.index') }}">@lang('app.menu.teams')</a></li>
                    </ul>
                </li>
            @endif


            @if(in_array("attendance", $modules)  && $company->status != 'license_expired')
                <li><a href="{{ route('admin.attendances.index') }}" class="waves-effect"><i class="icon-clock"></i> <span class="hide-menu">@lang('app.menu.attendance') </span></a> </li>
            @endif
            @if(in_array("holidays", $modules)  && $company->status != 'license_expired')
                <li><a href="{{ route('admin.holidays.index') }}" class="waves-effect"><i class="ti-calendar"></i> <span class="hide-menu"> @lang('app.menu.holiday')</span></a>
                </li>
            @endif


            @if(in_array("messages", $modules)   && $company->status != 'license_expired')
                <li><a href="{{ route('admin.user-chat.index') }}" class="waves-effect"><i class="icon-envelope"></i> <span class="hide-menu">@lang('app.menu.messages') @if($unreadMessageCount > 0)<span class="label label-rouded label-custom pull-right">{{ $unreadMessageCount }}</span> @endif</span></a> </li>
            @endif

            @if(in_array("events", $modules)  && $company->status != 'license_expired')
                <li><a href="{{ route('admin.events.index') }}" class="waves-effect"><i class="icon-calender"></i> <span class="hide-menu">@lang('app.menu.Events')</span></a> </li>
            @endif

            @if(in_array("leaves", $modules)  && $company->status != 'license_expired')
                <li><a href="{{ route('admin.leaves.index') }}" class="waves-effect"><i class="icon-logout"></i> <span class="hide-menu">@lang('app.menu.leaves')</span></a> </li>
            @endif

            @if(in_array("notices", $modules)  && $company->status != 'license_expired')
                <li><a href="{{ route('admin.notices.index') }}" class="waves-effect"><i class="ti-layout-media-overlay"></i> <span class="hide-menu">@lang('app.menu.noticeBoard') </span></a> </li>
            @endif
            @if($company->status != 'license_expired')
            <li><a href="{{ route('admin.reports.index') }}" class="waves-effect"><i class="ti-pie-chart"></i> <span class="hide-menu"> @lang('app.menu.reports') <span class="fa arrow"></span> </span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{ route('admin.task-report.index') }}">@lang('app.menu.taskReport')</a></li>
                    <li><a href="{{ route('admin.time-log-report.index') }}">@lang('app.menu.timeLogReport')</a></li>
                    <li><a href="{{ route('admin.finance-report.index') }}">@lang('app.menu.financeReport')</a></li>
                    <li><a href="{{ route('admin.income-expense-report.index') }}">@lang('app.menu.incomeVsExpenseReport')</a></li>
                    <li><a href="{{ route('admin.leave-report.index') }}">@lang('app.menu.leaveReport')</a></li>
                </ul>
            </li>
            @endif
            @role('admin')
            <li><a href="{{ route('admin.billing') }}" class="waves-effect"><i class="icon-book-open"></i> <span class="hide-menu"> @lang('app.menu.billing')</span></a>
            </li>
            @endrole
            @if($company->status != 'license_expired')
                <li><a href="{{ route('admin.settings.index') }}" class="waves-effect"><i class="ti-settings"></i> <span class="hide-menu"> @lang('app.menu.settings')</span></a>
                </li>
            @endif


        </ul>
    </div>
</div>