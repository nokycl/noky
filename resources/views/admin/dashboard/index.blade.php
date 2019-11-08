@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
<link rel="stylesheet" href="{{ asset('plugins/bower_components/calendar/dist/fullcalendar.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/morrisjs/morris.css') }}"><!--Owl carousel CSS -->
<link rel="stylesheet" href="{{ asset('plugins/bower_components/owl.carousel/owl.carousel.min.css') }}"><!--Owl carousel CSS -->
<link rel="stylesheet" href="{{ asset('plugins/bower_components/owl.carousel/owl.theme.default.css') }}"><!--Owl carousel CSS -->

<style>
    .col-in {
        padding: 0 20px !important;

    }

    .fc-event{
        font-size: 10px !important;
    }

    @media (min-width: 769px) {
        #wrapper .panel-wrapper{
            height: 500px;
            overflow-y: auto;
        }
    }

</style>
@endpush

@section('content')
    @if(!is_null($global->licence_expire_on) && $global->status == 'license_expired')
        <a href="soporte@noky.cl">
            <div class="alert alert-danger col-md-12">
                <h5 class="text-white">@lang('messages.licenseExpiredNote')</h5>
            </div>
        </a>
    @endif
    @if($company->package->default == 'yes' || $company->package->default == 'trial')
        <a href="soporte@noky.cl">
            <div class="alert alert-danger col-md-12">
                <h5 class="text-white">@lang('messages.purchasePackageMessage')</h5>
            </div>
        </a>
    @endif
    <div class="row dashboard-stats">


        @if(in_array('clients',$modules))
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('admin.clients.index') }}">
                <div class="white-box">
                <div class="row">
                    <div class="col-sm-3">
                        <div>
                            <span class="bg-success-gradient"><i class="icon-user"></i></span>
                        </div>
                    </div>
                    <div class="col-sm-9 text-right">
                        <span class="widget-title"> @lang('modules.dashboard.totalClients')</span><br>
                        <span class="counter">{{ $counts->totalClients }}</span>
                    </div>
                </div>
                </div>
            </a>
        </div>
        @endif

        @if(in_array('employees',$modules))
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('admin.employees.index') }}">
                <div class="white-box">
                    <div class="row">
                        <div class="col-sm-3">
                            <div>
                                <span class="bg-warning-gradient"><i class="icon-people"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-9 text-right">
                            <span class="widget-title"> @lang('modules.dashboard.totalEmployees')</span><br>
                            <span class="counter">{{ $counts->totalEmployees }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endif

        @if(in_array('projects',$modules))
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('admin.projects.index') }}">
                <div class="white-box">
                    <div class="row">
                        <div class="col-sm-3">
                            <div>
                                <span class="bg-danger-gradient"><i class="icon-layers"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-9 text-right">
                            <span class="widget-title"> @lang('modules.dashboard.totalProjects')</span><br>
                            <span class="counter">{{ $counts->totalProjects }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endif

        @if(in_array('invoices',$modules))
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('admin.all-invoices.index') }}">
                <div class="white-box">
                    <div class="row">
                        <div class="col-sm-3">
                            <div>
                                <span class="bg-inverse-gradient"><i class="ti-receipt"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-9 text-right">
                            <span class="widget-title"> @lang('modules.dashboard.totalUnpaidInvoices')</span><br>
                            <span class="counter">{{ $counts->totalUnpaidInvoices }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endif

        @if(in_array('timelogs',$modules))
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('admin.all-time-logs.index') }}">
                <div class="white-box">
                    <div class="row">
                        <div class="col-sm-3">
                            <div>
                                <span class="bg-info-gradient"><i class="icon-clock"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-9 text-right">
                            <span class="widget-title"> @lang('modules.dashboard.totalHoursLogged')</span><br>
                            <span style="font-size: 20px;">{{ $counts->totalHoursLogged }}</span>
                        </div>
                    </div>
                </div>
                </a>
            </div>
        @endif

        @if(in_array('tasks',$modules))
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('admin.all-tasks.index') }}">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-sm-3">
                                <div>
                                    <span class="bg-warning-gradient"><i class="ti-alert"></i></span>
                                </div>
                            </div>
                            <div class="col-sm-9 text-right">
                                <span class="widget-title"> @lang('modules.dashboard.totalPendingTasks')</span><br>
                                <span class="counter">{{ $counts->totalPendingTasks }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endif

        @if(in_array('tasks',$modules))
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('admin.all-tasks.index') }}">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-sm-3">
                                <div>
                                    <span class="bg-success-gradient"><i class="ti-check-box"></i></span>
                                </div>
                            </div>
                            <div class="col-sm-9 text-right">
                                <span class="widget-title"> @lang('modules.dashboard.totalCompletedTasks')</span><br>
                                <span class="counter">{{ $counts->totalCompletedTasks }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endif

        @if(in_array('attendance',$modules))
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('admin.attendances.index') }}">
                <div class="white-box">
                    <div class="row">
                        <div class="col-sm-3">
                            <div>
                                <span class="bg-danger-gradient"><i class="fa fa-percent" style="display: inherit;"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-9 text-right">
                            <span class="widget-title"> @lang('modules.dashboard.totalTodayAttendance')</span><br>
                            <span class="counter">@if($counts->totalEmployees > 0){{ round((($counts->totalTodayAttendance/$counts->totalEmployees)*100), 2) }}@else 0 @endif</span>%
                            <span class="text-muted">({{ $counts->totalTodayAttendance.'/'.$counts->totalEmployees }})</span>
                        </div>
                    </div>
                </div>
                </a>
            </div>
        @endif
    </div>
    <!-- .row -->

    <div class="row">
        <div class="col-md-6">
            <div class="row">
                @if(in_array('tickets',$modules))
                    <div class="col-md-6 col-sm-12 dashboard-stats">
                        <a href="{{ route('admin.tickets.index') }}">
                        <div class="white-box">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div>
                                        <span class="bg-success-gradient"><i class="ti-ticket"></i></span>
                                    </div>
                                </div>
                                <div class="col-sm-9 text-right">
                                    <span class="widget-title"> @lang('modules.tickets.totalResolvedTickets')</span><br>
                                    <span class="counter">{{ floor($counts->totalResolvedTickets) }}</span>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                @endif

                @if(in_array('tickets',$modules))
                    <div class="col-md-6 col-sm-12 dashboard-stats">
                        <a href="{{ route('admin.tickets.index') }}">
                            <div class="white-box">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div>
                                            <span class="bg-danger-gradient"><i class="ti-ticket"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-9 text-right">
                                        <span class="widget-title"> @lang('modules.tickets.totalUnresolvedTickets')</span><br>
                                        <span class="counter">{{ floor($counts->totalUnResolvedTickets) }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif

                {{-- <div class="col-md-6 col-xs-12">
                    <div class="bg-theme m-b-15">
                        <div class="row weather p-20">
                            @if(is_null($global->latitude))
                                <div class="col-md-12">
                                    <a href="{{ route('admin.settings.index') }}" class="text-white"><i class="ti-location-pin"></i>
                                        <br>
                                        @lang('modules.dashboard.weatherSetLocation')</a>
                                </div>
                            @else
                                <div class="col-md-6 col-xs-6 col-lg-6 col-sm-6 m-t-40">
                                    <h3>&nbsp;</h3>
                                    <h1>{{ ceil($weather['currently']['temperature']) }}<sup>°C</sup></h1>
                                </div>
                                <div class="col-md-6 col-xs-6 col-lg-6 col-sm-6 text-right"> <canvas class="{{ $weather['currently']['icon'] }}" width="45" height="45"></canvas><br/>
                                    <br/>
                                    <b class="text-white">{{ $weather['currently']['summary'] }}</b>
                                    <p class="w-title-sub">@lang('app.'.strtolower( \Carbon\Carbon::createFromTimestamp($weather['currently']['time'])->timezone($global->timezone)->format("F") )) {{ \Carbon\Carbon::createFromTimestamp($weather['currently']['time'])->timezone($global->timezone)->format('d') }}</p>
                                </div>
                                <div class="col-md-12">
                                    <p class="text-white">
                                        {{ $weather['hourly']['summary'] }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div> --}}

                <div class="col-md-12 col-xs-12">
                    <div class="bg-theme-dark m-b-15">
                        <div id="myCarouse2" class="carousel vcarousel slide p-20">
                            <h4 class="text-white p-t-0 p-b-0">@lang('modules.projects.clientFeedback')</h4>
                            <!-- Carousel items -->
                            <div class="carousel-inner ">
                                @forelse($feedbacks as $key=>$feedback)
                                    <div class="@if($key == 0) active @endif item">
                                        <h5 class="text-white">{!! substr($feedback->feedback,0,70).'...' !!}</h5>
                                        @if(!is_null($feedback->client))
                                        <div class="twi-user">
                                            {!!  ($feedback->client->image) ? '<img src="'.asset('user-uploads/avatar/'.$feedback->client->image).'"
                                                                        alt="user" class="img-circle img-responsive pull-left">' : '<img src="'.asset('default-profile-2.png').'"
                                                                        alt="user" class="img-circle img-responsive pull-left">' !!}
                                            <h5 class="text-white m-b-0">{{ ucwords($feedback->client->name) }}</h5>
                                            <p class="text-white">{{ ucwords($feedback->project_name) }}</p>
                                        </div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="active item">
                                        <h3 class="text-white">@lang('messages.noFeedbackReceived')</h3>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        @if(in_array('payments',$modules))
        <div class="col-md-6">
            <div class="row">
                <div class="col-xs-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">@lang('modules.dashboard.recentEarnings')</h3>

                        <div id="morris-area-chart" style="height: 190px;"></div>
                        <h6 style="line-height: 2em;"><span class=" label label-danger">@lang('app.note'):</span> @lang('messages.earningChartNote') <a href="{{ route('admin.settings.index') }}"><i class="fa fa-arrow-right"></i></a></h6>
                    </div>
                </div>

            </div>

        </div>
        @endif
    </div>
    <!-- .row -->

    <div class="row">
        @if(in_array('leaves',$modules))
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('app.menu.leaves')</div>
                <div class="panel-wrapper collapse in" style="overflow: hidden">
                    <div class="panel-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(in_array('tickets',$modules))
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('modules.dashboard.newTickets')</div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <ul class="list-task list-group" data-role="tasklist">
                            @forelse($newTickets as $key=>$newTicket)
                                <li class="list-group-item" data-role="task">
                                    {{ ($key+1) }}. <a href="{{ route('admin.tickets.edit', $newTicket->id) }}" class="text-danger"> {{  ucfirst($newTicket->subject) }}</a> <i>{{ ucwords($newTicket->created_at->diffForHumans()) }}</i>
                                </li>
                            @empty
                                <li class="list-group-item" data-role="task">
                                    @lang("messages.noTicketFound")
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>

    <div class="row" >
        @if(in_array('tasks',$modules))
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">@lang('modules.dashboard.overdueTasks')</div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <ul class="list-task list-group" data-role="tasklist">
                                <li class="list-group-item" data-role="task">
                                    <strong>@lang('app.title')</strong> <span
                                            class="pull-right"><strong>@lang('modules.dashboard.dueDate')</strong></span>
                                </li>
                                @forelse($pendingTasks as $key=>$task)
                                    <li class="list-group-item row" data-role="task">
                                        <div class="col-xs-9">
                                            {{ ($key+1).'. '.ucfirst($task->heading) }}
                                            @if(!is_null($task->project_id) && !is_null($task->project))
                                                <a href="{{ route('admin.projects.show', $task->project_id) }}" class="text-danger">{{ ucwords($task->project->project_name) }}</a>
                                            @endif
                                        </div>
                                        <label class="label label-danger pull-right col-xs-3">{{ $task->due_date->format($global->date_format) }}</label>
                                    </li>
                                @empty
                                    <li class="list-group-item" data-role="task">
                                        @lang("messages.noOpenTasks")
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(in_array('leads',$modules))
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">@lang('modules.dashboard.pendingFollowUp')</div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <ul class="list-task list-group" data-role="tasklist">
                                <li class="list-group-item" data-role="task">
                                    <strong>@lang('app.title')</strong> <span
                                            class="pull-right"><strong>@lang('modules.dashboard.followUpDate')</strong></span>
                                </li>
                                @forelse($pendingLeadFollowUps as $key=>$follows)
                                    <li class="list-group-item row" data-role="task">
                                        <div class="col-xs-9">
                                            {{ ($key+1) }}

                                            <a href="{{ route('admin.leads.show', $follows->lead_id) }}" class="text-danger">{{ ucwords($follows->lead->company_name) }}</a>

                                        </div>
                                        <label class="label label-danger pull-right col-xs-3">{{ $follows->next_follow_up_date->format($global->date_format) }}</label>
                                    </li>
                                @empty
                                    <li class="list-group-item" data-role="task">
                                        @lang("messages.noPendingLeadFollowUps")
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        @if(in_array('projects',$modules))
        <div class="col-md-6" id="project-timeline">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('modules.dashboard.projectActivityTimeline')</div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="steamline">
                            @foreach($projectActivities as $activ)
                                <div class="sl-item">
                                    <div class="sl-left"><i class="fa fa-circle text-info"></i>
                                    </div>
                                    <div class="sl-right">
                                        <div><h6><a href="{{ route('admin.projects.show', $activ->project_id) }}" class="text-danger">{{ ucwords($activ->project->project_name) }}:</a> {{ $activ->activity }}</h6> <span class="sl-date">{{ $activ->created_at->diffForHumans() }}</span></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(in_array('employees',$modules))
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('modules.dashboard.userActivityTimeline')</div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="steamline">
                            @forelse($userActivities as $key=>$activity)
                                <div class="sl-item">
                                    <div class="sl-left">
                                        {!!  ($activity->user->image) ? '<img src="'.asset('user-uploads/avatar/'.$activity->user->image).'"
                                                                    alt="user" class="img-circle">' : '<img src="'.asset('default-profile-2.png').'"
                                                                    alt="user" class="img-circle">' !!}
                                    </div>
                                    <div class="sl-right">
                                        <div class="m-l-40"><a href="{{ route('admin.employees.show', $activity->user_id) }}" class="text-success">{{ ucwords($activity->user->name) }}</a> <span  class="sl-date">{{ $activity->created_at->diffForHumans() }}</span>
                                            <p>{!! ucfirst($activity->activity) !!}</p>
                                        </div>
                                    </div>
                                </div>
                                @if(count($userActivities) > ($key+1))
                                    <hr>
                                @endif
                            @empty
                                <div>@lang("messages.noActivityByThisUser")</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>

    {{--Ajax Modal--}}
    <div class="modal fade bs-modal-md in" id="eventDetailModal" role="dialog" aria-labelledby="myModalLabel"
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
    {{--Ajax Modal Ends--}}

@endsection


@push('footer-script')
<script>
    var taskEvents = [
            @foreach($leaves as $leave)
            {
            id: '{{ ucfirst($leave->id) }}',
            title: '{{ ucfirst($leave->user->name) }}',
            start: '{{ $leave->leave_date }}',
            end:  '{{ $leave->leave_date }}',
            className: 'bg-{{ $leave->type->color }}'
        },
        @endforeach
];

    var getEventDetail = function (id) {
        var url = '{{ route('admin.leaves.show', ':id')}}';
        url = url.replace(':id', id);

        $('#modelHeading').html('Event');
        $.ajaxModal('#eventDetailModal', url);
    }

    var calendarLocale = '{{ $global->locale }}';

    $('.leave-action').click(function () {
        var action = $(this).data('leave-action');
        var leaveId = $(this).data('leave-id');
        var url = '{{ route("admin.leaves.leaveAction") }}';

        $.easyAjax({
            type: 'POST',
            url: url,
            data: { 'action': action, 'leaveId': leaveId, '_token': '{{ csrf_token() }}' },
            success: function (response) {
                if(response.status == 'success'){
                    window.location.reload();
                }
            }
        });
    })
</script>


<script src="{{ asset('plugins/bower_components/raphael/raphael-min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/morrisjs/morris.js') }}"></script>

<script src="{{ asset('plugins/bower_components/waypoints/lib/jquery.waypoints.js') }}"></script>
<script src="{{ asset('plugins/bower_components/counterup/jquery.counterup.min.js') }}"></script>

<!-- jQuery for carousel -->
<script src="{{ asset('plugins/bower_components/owl.carousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/owl.carousel/owl.custom.js') }}"></script>

<!--weather icon -->
<script src="{{ asset('plugins/bower_components/skycons/skycons.js') }}"></script>

<script src="{{ asset('plugins/bower_components/calendar/jquery-ui.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/moment/moment.js') }}"></script>
<script src="{{ asset('plugins/bower_components/calendar/dist/fullcalendar.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/calendar/dist/jquery.fullcalendar.js') }}"></script>
<script src="{{ asset('plugins/bower_components/calendar/dist/locale-all.js') }}"></script>
<script src="{{ asset('js/event-calendar.js') }}"></script>

<script>
    $(document).ready(function () {
        var chartData = {!!  $chartData !!};
        function barChart() {

            Morris.Line({
                element: 'morris-area-chart',
                data: chartData,
                xkey: 'date',
                ykeys: ['total'],
                labels: ['Earning'],
                pointSize: 3,
                fillOpacity: 0,
                pointStrokeColors:['#e20b0b'],
                behaveLikeLine: true,
                gridLineColor: '#e0e0e0',
                lineWidth: 2,
                hideHover: 'auto',
                lineColors: ['#e20b0b'],
                resize: true

            });

        }

        @if(in_array('payments',$modules))
        barChart();
        @endif

        $(".counter").counterUp({
            delay: 100,
            time: 1200
        });

        $('.vcarousel').carousel({
            interval: 3000
        })


        var icons = new Skycons({"color": "#ffffff"}),
                list  = [
                    "clear-day", "clear-night", "partly-cloudy-day",
                    "partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind",
                    "fog"
                ],
                i;
        for(i = list.length; i--; ) {
            var weatherType = list[i],
                    elements = document.getElementsByClassName( weatherType );
            for (e = elements.length; e--;){
                icons.set( elements[e], weatherType );
            }
        }
        icons.play();
    })

</script>
@endpush
