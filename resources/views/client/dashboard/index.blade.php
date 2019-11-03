@extends('layouts.client-app')

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
                <li><a href="{{ route('client.dashboard.index') }}">@lang('app.menu.home')</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
    <style>
        .col-in {
            padding: 0 20px !important;

        }

        .fc-event{
            font-size: 10px !important;
        }

        @media (min-width: 769px) {
            .panel-wrapper{
                height: 500px;
                overflow-y: auto;
            }
        }

    </style>
@endpush

@section('content')

    <div class="row dashboard-stats">
        @if(in_array('projects',$modules))
        <div class="col-md-3 col-sm-6">
            <div class="white-box">
                <div class="row">
                    <div class="col-sm-3">
                        <div>
                            <span class="bg-info-gradient"><i class="icon-layers"></i></span>
                        </div>
                    </div>
                    <div class="col-sm-9 text-right">
                        <span class="widget-title"> @lang('modules.dashboard.totalProjects')</span><br>
                        <span class="counter">{{ $counts->totalProjects }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(in_array('tickets',$modules))
        <div class="col-md-3 col-sm-6">
            <div class="white-box">
                <div class="row">
                    <div class="col-sm-3">
                        <div>
                            <span class="bg-warning-gradient"><i class="ti-ticket"></i></span>
                        </div>
                    </div>
                    <div class="col-sm-9 text-right">
                        <span class="widget-title"> @lang('modules.tickets.totalUnresolvedTickets')</span><br>
                        <span class="counter">{{ $counts->totalUnResolvedTickets }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(in_array('invoices',$modules))
        <div class="col-md-3 col-sm-6">
            <div class="white-box">
                <div class="row">
                    <div class="col-sm-3">
                        <div>
                            <span class="bg-success-gradient"><i class="ti-ticket"></i></span>
                        </div>
                    </div>
                    <div class="col-sm-9 text-right">
                        <span class="widget-title"> @lang('modules.dashboard.totalPaidAmount')</span><br>
                        <span class="counter">{{ floor($counts->totalPaidAmount) }}</span>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="white-box">
                <div class="row">
                    <div class="col-sm-3">
                        <div>
                            <span class="bg-danger-gradient"><i class="ti-ticket"></i></span>
                        </div>
                    </div>
                    <div class="col-sm-9 text-right">
                        <span class="widget-title"> @lang('modules.dashboard.totalOutstandingAmount')</span><br>
                        <span class="counter">{{ floor($counts->totalUnpaidAmount) }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
    <!-- .row -->

    <div class="row" >

        @if(in_array('projects',$modules))
        <div class="col-md-6" id="project-timeline">
            <div class="panel panel-default">
                <div class="panel-heading">@lang("modules.dashboard.projectActivityTimeline")</div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="steamline">
                            @foreach($projectActivities as $activity)
                                <div class="sl-item">
                                    <div class="sl-left"><i class="fa fa-circle text-info"></i>
                                    </div>
                                    <div class="sl-right">
                                        <div><h6><a href="{{ route('client.projects.show', $activity->project_id) }}" class="text-danger">{{ ucwords($activity->project_name) }}:</a> {{ $activity->activity }}</h6> <span class="sl-date">{{ $activity->created_at->timezone($global->timezone)->diffForHumans() }}</span></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>

@endsection
