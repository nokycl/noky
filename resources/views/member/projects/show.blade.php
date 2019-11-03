@extends('layouts.member-app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }} #{{ $project->id }} - <span class="font-bold">{{ ucwords($project->project_name) }}</span></h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-6 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ route('member.dashboard') }}">@lang('app.menu.home')</a></li>
                <li><a href="{{ route('member.projects.index') }}">{{ __($pageTitle) }}</a></li>
                <li class="active">@lang('modules.projects.overview')</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
<link rel="stylesheet" href="{{ asset('plugins/bower_components/icheck/skins/all.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/multiselect/css/multi-select.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
@endpush

@section('content')

    <div class="row">
        <div class="col-md-12">

            <section>
                <div class="sttabs tabs-style-line">
                    <div class="white-box">
                        <nav>
                            <ul>
                                <li class="tab-current"><a href="{{ route('member.projects.show', $project->id) }}"><span>@lang('modules.projects.overview')</span></a>
                                </li>

                                @if(in_array('employees',$modules))
                                <li><a href="{{ route('member.project-members.show', $project->id) }}"><span>@lang('modules.projects.members')</span></a></li>
                                @endif

                                @if(in_array('tasks',$modules))
                                <li><a href="{{ route('member.tasks.show', $project->id) }}"><span>@lang('app.menu.tasks')</span></a></li>
                                @endif

                                <li><a href="{{ route('member.files.show', $project->id) }}"><span>@lang('modules.projects.files')</span></a></li>
                                @if(in_array('timelogs',$modules))
                                <li><a href="{{ route('member.time-log.show-log', $project->id) }}"><span>@lang('app.menu.timeLogs')</span></a></li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                    <div class="content-wrap">
                        <section id="section-line-1" class="show">
                            <div class="row">

                                <div  @if($project->isProjectAdmin || $user->can('edit_projects')) class="col-md-6" @else class="col-md-12" @endif>
                                    <div class="white-box">
                                        <h3 class="b-b">Project #{{ $project->id }} - <span
                                                    class="font-bold">{{ ucwords($project->project_name) }}</span>
                                            @if($project->isProjectAdmin || $user->can('edit_projects'))
                                              <a href="{{ route('member.projects.edit', $project->id) }}" class="pull-right btn btn-info btn-outline btn-rounded btn-xs" style="font-size: small"><i class="icon-note"></i> @lang('app.edit')</a>
                                            @endif
                                        </h3>

                                        <div>{!!  $project->project_summary !!}</div>
                                    </div>
                                </div>

                                @if($project->isProjectAdmin || $user->can('edit_projects'))
                                    <div class="col-md-6">
                                    <div class="white-box">
                                        <h3 class="box-title b-b"><i class="fa fa-clock-o"></i> @lang('modules.projects.activeTimers')</h3>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>@lang('modules.projects.whoWorking')</th>
                                                    <th>@lang('modules.projects.activeSince')</th>
                                                    <th>&nbsp;</th>
                                                </tr>
                                                </thead>
                                                <tbody id="timer-list">
                                                @forelse($activeTimers as $key=>$time)
                                                    <tr>
                                                        <td>{{ $key+1 }}</td>
                                                        <td>{{ ucwords($time->user->name) }}</td>
                                                        <td class="font-bold timer">{{ $time->duration }}</td>
                                                        <td><a href="javascript:;" data-time-id="{{ $time->id }}" class="label label-danger stop-timer">@lang('app.stop')</a></td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="3">@lang('messages.noActiveTimer')</td>
                                                    </tr>
                                                @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @endif


                            </div>

                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-sm-12">
                                    <div class="white-box">
                                        <div class="row row-in">
                                            @if(in_array('tasks',$modules))
                                            <div class="col-lg-3 col-sm-6 row-in-br">
                                                <div class="col-in row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><i class="ti-layout-list-thumb"></i>
                                                        <h5 class="text-muted vb">@lang('modules.projects.openTasks')</h5>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                                        <h3 class="counter text-right m-t-15 text-danger">{{ count($openTasks) }}</h3>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-danger"
                                                                 role="progressbar" aria-valuenow="40" aria-valuemin="0"
                                                                 aria-valuemax="100" style="width: {{ $openTasksPercent }}%"><span
                                                                        class="sr-only">{{ $openTasksPercent }}% Complete (success)</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="col-lg-3 col-sm-6 row-in-br  b-r-none">
                                                <div class="col-in row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><i
                                                                class="ti-calendar"></i>
                                                        <h5 class="text-muted vb">@lang('modules.projects.daysLeft')</h5>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                                        <h3 class="counter text-right m-t-15 text-info">{{ $daysLeft }}</h3>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-info"
                                                                 role="progressbar" aria-valuenow="40" aria-valuemin="0"
                                                                 aria-valuemax="100" style="width: {{ $daysLeftPercent }}%"><span
                                                                        class="sr-only">{{ $daysLeftPercent }}% Complete (success)</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(in_array('timelogs',$modules))
                                            <div class="col-lg-3 col-sm-6 row-in-br">
                                                <div class="col-in row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><i class="ti-alarm-clock"></i>
                                                        <h5 class="text-muted vb">@lang('modules.projects.hoursLogged')</h5>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                                        <h3 class="counter text-right m-t-15 text-success">{{ floor($hoursLogged) }}</h3>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-success"
                                                                 role="progressbar" aria-valuenow="40" aria-valuemin="0"
                                                                 aria-valuemax="100" style="width: 100%"><span
                                                                        class="sr-only">100% Complete (success)</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="col-lg-3 col-sm-6  b-0">
                                                <div class="col-in row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><i class="ti-alert"></i>
                                                        <h5 class="text-muted vb">@lang('app.completion')</h5>
                                                    </div>
                                                    @if ($project->completion_percent < 50)
                                                        <?php $statusColor = 'danger'; ?>
                                                    @elseif ($project->completion_percent >= 50 && $project->completion_percent < 75)
                                                        <?php $statusColor = 'warning'; ?>
                                                    @else
                                                        <?php $statusColor = 'success'; ?>
                                                    @endif
                                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                                        <h3 class="counter text-right m-t-15 text-{{ $statusColor }}">{{ $project->completion_percent }}%</h3>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-xs-12">

                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-{{ $statusColor }}"
                                                                 role="progressbar" aria-valuenow="40" aria-valuemin="0"
                                                                 aria-valuemax="100" style="width: {{ $project->completion_percent }}%"><span
                                                                        class="sr-only">{{ $project->completion_percent }}% Complete (success)</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="row">

                                        @if($user->can('view_clients'))
                                        {{-- client details --}}
                                        <div class="col-md-6">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">@lang('modules.client.clientDetails')</div>
                                                <div class="panel-wrapper collapse in">
                                                    <div class="panel-body">
                                                        @if(!is_null($project->client))
                                                            @if(count($project->client) > 0)
                                                        <dl>
                                                            <dt>@lang('modules.client.companyName')</dt>
                                                            <dd class="m-b-10">{{ $project->client->company_name }}</dd>

                                                        </dl>
                                                            @endif
                                                        <dl>
                                                            <dt>@lang('modules.client.clientName')</dt>
                                                            <dd class="m-b-10">{{ ucwords($project->client->name) }}</dd>
                                                        </dl>
                                                            
                                                        @else
                                                            @lang('messages.noClientAddedToProject')
                                                        @endif

                                                            {{--Custom fields data--}}
                                                            @if(isset($fields))
                                                                <dl>
                                                                    @foreach($fields as $field)
                                                                        <dt>{{ ucfirst($field->label) }}</dt>
                                                                        <dd class="m-b-10">
                                                                            @if( $field->type == 'text')
                                                                                {{$project->custom_fields_data['field_'.$field->id] ?? '-'}}
                                                                            @elseif($field->type == 'password')
                                                                                {{$project->custom_fields_data['field_'.$field->id] ?? '-'}}
                                                                            @elseif($field->type == 'number')
                                                                                {{$project->custom_fields_data['field_'.$field->id] ?? '-'}}

                                                                            @elseif($field->type == 'textarea')
                                                                                {{$project->custom_fields_data['field_'.$field->id] ?? '-'}}
                                                                            @elseif($field->type == 'radio')
                                                                                {{ !is_null($project->custom_fields_data['field_'.$field->id]) ? $project->custom_fields_data['field_'.$field->id] : '-' }}
                                                                            @elseif($field->type == 'select')
                                                                                {{ (!is_null($project->custom_fields_data['field_'.$field->id]) && $project->custom_fields_data['field_'.$field->id] != '') ? $field->values[$project->custom_fields_data['field_'.$field->id]] : '-' }}
                                                                            @elseif($field->type == 'checkbox')
                                                                                {{ !is_null($project->custom_fields_data['field_'.$field->id]) ? $field->values[$project->custom_fields_data['field_'.$field->id]] : '-' }}
                                                                            @elseif($field->type == 'date')
                                                                                {{ isset($project->dob)?Carbon\Carbon::parse($project->dob)->format('Y-m-d'):Carbon\Carbon::now()->format('m/d/Y')}}
                                                                            @endif
                                                                        </dd>
                                                                    @endforeach
                                                                </dl>
                                                            @endif

                                                            {{--custom fields data end--}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        {{-- project members --}}
                                        <div class="col-md-6">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">@lang('modules.projects.members')</div>
                                                <div class="panel-wrapper collapse in">
                                                    <div class="panel-body">
                                                        <div class="message-center">
                                                            @forelse($project->members as $member)
                                                            <a href="#">
                                                                <div class="user-img">
                                                                    {!!  ($member->user->image) ? '<img src="'.asset('user-uploads/avatar/'.$member->user->image).'"
                                                            alt="user" class="img-circle" width="40" height="40">' : '<img src="'.asset('default-profile-2.png').'"
                                                            alt="user" class="img-circle" width="40" height="40">' !!}
                                                                </div>
                                                                <div class="mail-contnet">
                                                                    <h5>{{ ucwords($member->user->name) }}</h5>
                                                                    <span class="mail-desc">{{ $member->user->email }}</span>
                                                                </div>
                                                            </a>
                                                            @empty
                                                                @lang('messages.noMemberAddedToProject')
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- project members --}}
                                        <div class="col-md-6">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">@lang('modules.projects.openTasks')</div>
                                                <div class="panel-wrapper collapse in">
                                                    <div class="panel-body">
                                                        <ul class="list-task list-group" data-role="tasklist">
                                                            @forelse($openTasks as $key=>$task)
                                                            <li class="list-group-item" data-role="task">
                                                                {{ ($key+1).'. '.ucfirst($task->heading) }} <label
                                                                        class="label label-success pull-right">{{ $task->due_date->format('d M') }}</label>
                                                            </li>
                                                            @empty
                                                                <li class="list-group-item" data-role="task">
                                                                    @lang('modules.projects.noOpenTasks')
                                                                </li>
                                                            @endforelse
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- project members --}}
                                        <div class="col-md-6">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">@lang('modules.projects.files')</div>
                                                <div class="panel-wrapper collapse in">
                                                    <div class="panel-body">
                                                        <ul class="list-task list-group" data-role="tasklist">
                                                            @forelse($recentFiles as $key=>$file)
                                                                <li class="list-group-item" data-role="task">
                                                                   {{ ($key+1) }}. {{ $file->filename }} <a target="_blank" href="{{ asset('user-uploads/project-files/'.$project->id.'/'.$file->hashname) }}" class="btn btn-info btn-circle"><i class="fa fa-search"></i></a>
                                                                </li>
                                                            @empty
                                                                <li class="list-group-item" data-role="task">
                                                                    @lang('messages.noFileUploaded')
                                                                </li>
                                                            @endforelse
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{--Project Activity --}}
                                <div class="col-md-3" id="project-timeline">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">@lang('modules.projects.activityTimeline')</div>
                                        <div class="panel-wrapper collapse in">
                                            <div class="panel-body">
                                                <div class="steamline">
                                                    @foreach($activities as $activ)
                                                    <div class="sl-item">
                                                        <div class="sl-left"><i class="fa fa-circle text-info"></i>
                                                        </div>
                                                        <div class="sl-right">
                                                            <div>{{ $activ->activity }} <span class="sl-date">{{ $activ->created_at->diffForHumans() }}</span></div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div><!-- /content -->
                </div><!-- /tabs -->
            </section>
        </div>


    </div>
    <!-- .row -->

@endsection

@push('footer-script')
<script src="{{ asset('js/cbpFWTabs.js') }}"></script>
<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/multiselect/js/jquery.multi-select.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
//    (function () {
//
//        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
//            new CBPFWTabs(el);
//        });
//
//    })();

    $('#timer-list').on('click', '.stop-timer', function () {
       var id = $(this).data('time-id');
        var url = '{{route('admin.time-logs.stopTimer', ':id')}}';
        url = url.replace(':id', id);
        var token = '{{ csrf_token() }}'
        $.easyAjax({
            url: url,
            type: "POST",
            data: {timeId: id, _token: token},
            success: function (data) {
                $('#timer-list').html(data.html);
            }
        })

    });

</script>
@endpush
