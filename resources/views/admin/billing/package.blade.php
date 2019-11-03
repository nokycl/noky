@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('pricing/css/style.css') }}">
    <style>
        .text-danger {
            color: red !important;
        }
        h3 {
            line-height: 30px;
            font-size: 10px;
        }
        .display-small {
            display: block;
            width: fit-content;
        }
        .display-big {
            display: none;
        }
        .price {
            font-size: 1em;
        }
        body {
            background: #4f5467;
            font-family: Poppins,sans-serif;
            margin: 0;
            overflow-x: hidden;
            color: #686868;
            font-weight: 300;
            font-size: 5px;
            line-height: 1.42857143;
        }
        @media (min-width: 767px) {
            .display-small {
                display: none;
            }
            .display-big {
                display: block;
            }
            .price {
                font-size: 3em;
            }
            body {
                font-size: 14px;
            }
        }
        @media (min-width: 1200px) {
            h3 {
                line-height: 30px;
                font-size: 21px;
            }
        }
        .selected-plan, body .table>tbody>tr.active>th.selected-plan {
            background-color:#a6ebff5e !important;
            font-weight: 600;
        }
    </style>
@endpush

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

@endpush


@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                <?php Session::forget('success');?>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                <?php Session::forget('error');?>
            @endif
                <div class="white-box ">
                    <h1>@lang('app.monthly') @lang('app.menu.packages')</h1>
                    {{--<div class="table-responsive">--}}
                        <table class="table table-hover table-bordered" style="text-align:center;padding-left:200px; padding-right:200px;">
                            <thead>
                            <tr class="active">
                                <th style="background:#fff !important; min-width:80px;"></th>
                                @foreach($packages as $package)
                                    <th style="@if(($package->id == $company->package->id && $company->package_type == 'monthly')) background-color:#a6ebff5e !important; @endif">
                                        <center>
                                            <h3 >{{ucfirst($package->name)}}</h3>
                                        </center>
                                    </th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><br>@lang('app.price')</td>
                                @foreach($packages as $package)
                                    <td class="@if(($package->id == $company->package->id && $company->package_type == 'monthly')) selected-plan @endif"><h3 class="panel-title price ">${{ round($package->monthly_price) }}</h3></td>
                                @endforeach
                            </tr>

                            <tr>
                                <td>@lang('app.menu.employees')</td>
                                @foreach($packages as $package)
                                    <td class="@if(($package->id == $company->package->id && $company->package_type == 'monthly')) selected-plan @endif">{{ $package->max_employees }} @lang('modules.projects.members')</td>
                                @endforeach
                            </tr>

                            <tr>
                                @php
                                    $moduleArray = [];
                                    foreach($modulesData as $module) {
                                        $moduleArray[$module->module_name] = [];
                                    }
                                @endphp

                                @foreach($packages as $package)
                                    @foreach((array)json_decode($package->module_in_package) as $MIP)
                                        @if (array_key_exists($MIP, $moduleArray))
                                            @php $moduleArray[$MIP][] = strtoupper(trim($package->name)); @endphp
                                        @else
                                            @php $moduleArray[$MIP] = [strtoupper(trim($package->name))]; @endphp
                                        @endif
                                    @endforeach
                                @endforeach
                            </tr>
                            <tr>
                                <td colspan="5" align="left" style="padding-left:20px;" class="active"><b>@lang('modules.moduleSettings.employeeModuleTitle')</b></td>
                            </tr>
                            @foreach($moduleArray as $key => $module)
                                <tr>
                                    <td>{{ ucfirst($key) }}</td>
                                    @foreach($packages as $package)
                                        @php $available = in_array(strtoupper(trim($package->name)), $module); @endphp
                                        <td class="@if(($package->id == $company->package->id && $company->package_type == 'monthly')) selected-plan @endif"><i class="fa {{ $available ? 'fa-check text-megna' : 'fa-times text-danger'}} fa-lg"></i></td>
                                    @endforeach
                                </tr>
                            @endforeach
                            <tr><td></td>

                                @foreach($packages as $package)
                                    <td>
                                        @if(round($package->monthly_price) > 0)
                                            @if(!($package->id == $company->package->id && $company->package_type == 'monthly')  && ($stripeSettings->paypal_status == 'active' || $stripeSettings->stripe_status == 'active'))
                                                <button type="button" data-package-id="{{ $package->id }}" data-package-type="monthly" class="btn btn-success waves-effect waves-light selectPackage" title="Choose Plan"><i class="icon-anchor display-small"></i><span class="display-big">@lang('modules.billing.choosePlan')</span></button>
                                            @endif
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                            </tbody>
                        </table>
                    {{--</div>--}}

                    <h1 class="m-t-20">@lang('app.annual') @lang('app.menu.packages')</h1>
                    <table class="table table-hover table-bordered" style="text-align:center;padding-left:200px; padding-right:200px;">
                        <thead>
                        <tr class="active">
                            <th style="background:#fff !important"><center></center></th>
                            @foreach($packages as $package)
                                <th style="@if(($package->id == $company->package->id && $company->package_type == 'annual')) background-color:#a6ebff5e !important; @endif"><center><h3>{{ucfirst($package->name)}}</h3></center></th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><br>@lang('app.price')</td>
                            @foreach($packages as $package)
                                <td class="@if(($package->id == $company->package->id && $company->package_type == 'annual')) selected-plan @endif"><h3 class="panel-title price">${{ round($package->annual_price) }}</h3></td>
                            @endforeach
                        </tr>

                        <tr>
                            <td>@lang('app.menu.employees')</td>
                            @foreach($packages as $package)
                                <td class="@if(($package->id == $company->package->id && $company->package_type == 'annual')) selected-plan @endif">{{ $package->max_employees }} @lang('modules.projects.members')</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td colspan="5" align="left" style="padding-left:20px;" class="active"><b>@lang('modules.moduleSettings.employeeModuleTitle')</b></td>
                        </tr>
                        @foreach($moduleArray as $key => $module)
                            <tr>
                                <td>{{ ucfirst($key) }}</td>
                                @foreach($packages as $package)
                                    @php $available = in_array(strtoupper(trim($package->name)), $module); @endphp
                                    <td class="@if(($package->id == $company->package->id && $company->package_type == 'annual')) selected-plan @endif"><i class="fa {{ $available ? 'fa-check text-megna' : 'fa-times text-danger'}} fa-lg"></i></td>
                                @endforeach
                            </tr>
                        @endforeach
                        <tr><td></td>

                            @foreach($packages as $package)
                                <td>
                                    @if(round($package->annual_price) > 0)
                                        @if(!($package->id == $company->package->id && $company->package_type == 'annual') && ($stripeSettings->paypal_status == 'active'  || $stripeSettings->stripe_status == 'active'))
                                            <button type="button" data-package-id="{{ $package->id }}" data-package-type="annual" class="btn btn-success waves-effect waves-light selectPackage" title="Choose Plan"><i class="icon-anchor display-small"></i><span class="display-big">@lang('modules.billing.choosePlan')</span></button>
                                        @endif
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
    {{--Ajax Modal--}}
    <div class="modal fade bs-modal-md in" id="package-select-form" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
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
    {{--Ajax Modal Ends--}}
@endsection

@push('footer-script')
    <script src="{{ asset('pricing/js/index.js') }}"></script>
<script>
    // $(document).ready(function() {
        // show when page load
        @if(\Session::has('message'))
            toastr.success({{  \Session::get('message') }});
        @endif
    // });

    $('body').on('click', '.unsubscription', function(){
        var type = $(this).data('type');
        swal({
            title: "Are you sure?",
            text: "Do you want to unsubscribe this plan!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Unsubscribe it!",
            cancelButtonText: "No, cancel please!",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function(isConfirm){
            if (isConfirm) {

                var url = "{{ route('admin.billing.unsubscribe') }}";
                var token = "{{ csrf_token() }}";
                $.easyAjax({
                    type: 'POST',
                    url: url,
                    data: {'_token': token, '_method': 'POST', 'type': type},
                    success: function (response) {
                        if (response.status == "success") {
                            $.unblockUI();
//                                    swal("Deleted!", response.message, "success");
                            table._fnDraw();
                        }
                    }
                });
            }
        });
    });

    // Show Create Holiday Modal
    $('body').on('click', '.selectPackage', function(){
        var id = $(this).data('package-id');
        var type = $(this).data('package-type');
        var url = "{{ route('admin.billing.select-package',':id') }}?type="+type;
        url = url.replace(':id', id);
        $.ajaxModal('#package-select-form', url);
    });
</script>
@endpush