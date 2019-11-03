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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
@endpush

@section('content')

    <div class="row">
        <div class="col-md-3">
            <div class="white-box bg-inverse">
                <h3 class="box-title text-white">@lang('app.total') @lang('app.menu.packages')</h3>
                <ul class="list-inline two-part">
                    <li><i class="icon-user text-white"></i></li>
                    <li class="text-right"><span id="totalPackages" class="counter text-white">{{ $totalPackages }}</span></li>
                </ul>
            </div>
        </div>

        <div class="col-md-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <a href="{{ route('super-admin.packages.create') }}" class="btn btn-outline btn-success btn-sm">@lang('app.add') @lang('app.package') <i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                <table class="table table-bordered table-hover toggle-circle default footable-loaded footable" id="users-table">
                    <thead>
                    <tr>
                        <th>@lang('app.id')</th>
                        <th>@lang('app.name')</th>
                        <th>@lang('app.annual') @lang('app.price') ({{$global->currency->currency_symbol}})</th>
                        <th>@lang('app.monthly') @lang('app.price') ({{$global->currency->currency_symbol}})</th>
                        <th>@lang('app.menu.employees')</th>
                        <th>@lang('app.module')</th>
                        <th>@lang('app.action')</th>
                    </tr>
                    </thead>
                </table>
                    </div>
            </div>
        </div>
    </div>
    <!-- .row -->

@endsection

@push('footer-script')
    <script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
    <script>
        $(function() {
            var table = $('#users-table').dataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                stateSave: true,
                ajax: '{!! route('super-admin.packages.data') !!}',
                language: {
                    "url": "<?php echo __("app.datatable") ?>"
                },
                "fnDrawCallback": function( oSettings ) {
                    $("body").tooltip({
                        selector: '[data-toggle="tooltip"]'
                    });
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'annual_price', name: 'annual_price' },
                    { data: 'monthly_price', name: 'monthly_price' },
                    { data: 'max_employees', name: 'max_employees'},
                    { data: 'module_in_package', name: 'module_in_package' },
                    { data: 'action', name: 'action' }
                ]
            });


            $('body').on('click', '.sa-params', function(){
                var id = $(this).data('user-id');
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover the deleted package!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel please!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function(isConfirm){
                    if (isConfirm) {

                        var url = "{{ route('super-admin.packages.destroy',':id') }}";
                        url = url.replace(':id', id);

                        var token = "{{ csrf_token() }}";

                        $.easyAjax({
                            type: 'POST',
                            url: url,
                            data: {'_token': token, '_method': 'DELETE'},
                            success: function (response) {
                                if (response.status == "success") {
                                    $.unblockUI();
                                    var total = $('#totalPackages').text();
                                    $('#totalPackages').text(parseInt(total) - parseInt(1));
                                    table._fnDraw();
                                }
                            }
                        });
                    }
                });
            });



        });

    </script>
@endpush