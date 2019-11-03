@extends('layouts.super-admin')

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
                <li><a href="{{ route('super-admin.dashboard') }}">@lang('app.menu.home')</a></li>
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

</style>
@endpush

@section('content')
    <div class="row dashboard-stats">
        @php($updateVersionInfo = \Froiden\Envato\Functions\EnvatoUpdate::updateVersionInfo())
        @if(isset($updateVersionInfo['lastVersion']))
            <div class="alert alert-info col-md-12">
                <div class="col-md-10"><i class="ti-gift"></i> @lang('modules.update.newUpdate') <label class="label label-success">{{ $updateVersionInfo['lastVersion'] }}</label></div>
                <div class="col-md-2"><a href="{{ route('super-admin.update-settings.index') }}" class="btn btn-success btn-small">@lang('modules.update.updateNow') <i class="fa fa-arrow-right"></i></a></div>
            </div>
        @endif

        @if(!$progress['progress_completed'])
            @include('super-admin.dashboard.get_started')
        @endif

            
        <div class="col-md-3 col-sm-6">
            <div class="white-box">
            <div class="col-in row">
                <h3 class="box-title">@lang('modules.dashboard.totalCompanies')</h3>
                <ul class="list-inline two-part">
                    <li><i class="icon-layers text-success"></i></li>
                    <li class="text-right"><span class="counter">{{ $totalCompanies }}</span></li>
                </ul>
            </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="white-box">
            <div class="col-in row">
                <h3 class="box-title">@lang('modules.dashboard.activeCompanies')</h3>
                <ul class="list-inline two-part">
                    <li><i class="icon-layers text-success"></i></li>
                    <li class="text-right"><span class="counter">{{ $activeCompanies }}</span></li>
                </ul>
            </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="white-box">
            <div class="col-in row">
                <h3 class="box-title">@lang('modules.dashboard.licenseExpired')</h3>
                <ul class="list-inline two-part">
                    <li><i class="icon-layers text-success"></i></li>
                    <li class="text-right"><span class="counter">{{ $expiredCompanies }}</span></li>
                </ul>
            </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="white-box">
            <div class="col-in row">
                <h3 class="box-title">@lang('modules.dashboard.inactiveCompanies')</h3>
                <ul class="list-inline two-part">
                    <li><i class="icon-layers text-success"></i></li>
                    <li class="text-right"><span class="counter">{{ $inactiveCompanies }}</span></li>
                </ul>
            </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-md-3 col-sm-6">
            <div class="white-box">
                <div class="col-in row">
                    <h3 class="box-title">@lang('app.total') @lang('app.menu.packages')</h3>
                    <ul class="list-inline two-part">
                        <li><i class="icon-layers text-success"></i></li>
                        <li class="text-right"><span class="counter">{{ $totalPackages }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <ul class="list-inline text-center m-t-40">
                    <li>
                        <h5><i class="fa fa-circle m-r-5" style="color:rgb(13, 219, 228);"></i>@lang('app.earnings')</h5>
                    </li>
                </ul>
                <div id="morris-area-chart" style="height: 340px;"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">@lang('modules.superadmin.recentRegisteredCompanies')</h3>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">@lang('app.name')</th>
                            <th class="text-center">@lang('app.email')</th>
                            <th class="text-center">@lang('app.menu.packages')</th>
                            <th class="text-center">@lang('app.date')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($recentRegisteredCompanies as $key => $recent)
                            <tr>
                                <td class="text-center">{{ $key + 1 }} </td>
                                <td class="text-center">{{ $recent->company_name }} </td>
                                <td class="text-center">{{ $recent->company_email }} </td>
                                <td class="text-center">{{ ucwords($recent->package->name) }} ({{ ucwords($recent->package_type) }}) </td>
                                <td class="text-center">{{ $recent->created_at->format('M j, Y') }} </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="4">@lang('messages.noRecordFound')</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">@lang('modules.superadmin.recentSubscriptions')</h3>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">@lang('modules.client.companyName')</th>
                            <th class="text-center">@lang('app.menu.packages')</th>
                            <th class="text-center">@lang('app.date')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($recentSubscriptions as $key => $recent)
                            <tr>
                                <td class="text-center">{{ $key + 1 }} </td>
                                <td class="text-center">{{ $recent->company_name }} </td>
                                <td class="text-center">{{ ucwords($recent->name) }} ({{ ucwords($recent->package_type) }}) </td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($recent->paid_on)->format('M j, Y') }} </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="4">@lang('messages.noRecordFound')</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">@lang('modules.superadmin.recentLicenseExpiredCompanies')</h3>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">@lang('modules.client.companyName')</th>
                            <th class="text-center">@lang('app.menu.packages')</th>
                            <th class="text-center">@lang('app.date')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($recentExpired as $key => $recent)
                            <tr>
                                <td class="text-center">{{ $key + 1 }} </td>
                                <td class="text-center">{{ $recent->company_name }} </td>
                                <td class="text-center">{{ ucwords($recent->package->name) }} ({{ ucwords($recent->package_type) }}) </td>
                                <td class="text-center">{{ $recent->updated_at->format('M j, Y') }} </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="4">@lang('messages.noRecordFound')</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('footer-script')

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

<script>
    $(document).ready(function () {
        var chartData = {!!  $chartData !!};

        Morris.Area({
            element: 'morris-area-chart',
            data: chartData,
            lineColors: ['#01c0c8'],
            xkey: ['month'],
            ykeys: ['amount'],
            labels: ['Earning'],
            pointSize: 0,
            lineWidth: 0,
            resize:true,
            fillOpacity: 0.8,
            behaveLikeLine: true,
            gridLineColor: '#e0e0e0',
            hideHover: 'auto',
            parseTime: false
        });

        $('.vcarousel').carousel({
            interval: 3000
        })
    });

    $(".counter").counterUp({
        delay: 100,
        time: 1200
    });

</script>
@endpush