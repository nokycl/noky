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
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <script src="{{ asset('plugins/bower_components/moment/moment.js') }}"></script>
@endpush

@section('content')

    <div class="row">
        <div class="col-md-3">
            <div class="white-box bg-inverse">
                <h3 class="box-title text-white">@lang('modules.dashboard.totalCompanies')</h3>
                <ul class="list-inline two-part">
                    <li><i class="icon-user text-white"></i></li>
                    <li class="text-right"><span id="totalCompanies" class="counter text-white">{{ $totalCompanies }}</span></li>
                </ul>
            </div>
        </div>

        <div class="col-md-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <a href="{{ route('super-admin.companies.create') }}" class="btn btn-outline btn-success btn-sm">@lang('app.add') @lang('app.company') <i class="fa fa-plus" aria-hidden="true"></i></a>
                            <a href="javascript:;" id="toggle-filter" class="btn btn-outline btn-danger btn-sm toggle-filter"><i
                                        class="fa fa-sliders"></i> @lang('app.filterResults')</a>
                        </div>
                    </div>
                </div>
                <div class="row b-b b-t" style="display: none; background: #fbfbfb;" id="ticket-filters">
                    <div class="col-md-12">
                        <h4>@lang('app.filterBy') <a href="javascript:;" class="pull-right toggle-filter"><i class="fa fa-times-circle-o"></i></a></h4>
                    </div>
                    <form action="" id="filter-form">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">@lang('app.package')</label>
                                <select class="form-control selectpicker" name="package" id="package" data-style="form-control">
                                    <option value="all">@lang('app.all')</option>
                                    @foreach( $packages as $package)
                                        <option value="{{ $package->id }}">{{ ucwords($package->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">@lang('app.package') @lang('modules.invoices.type')</label>
                                <select class="form-control selectpicker" name="type" id="type" data-style="form-control">
                                    <option value="all">@lang('app.all')</option>
                                    <option value="monthly">@lang('app.monthly')</option>
                                    <option value="annual">@lang('app.annual')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label col-xs-12">&nbsp;</label>
                                <button type="button" id="apply-filters" class="btn btn-success col-md-6"><i class="fa fa-check"></i> @lang('app.apply')</button>
                                <button type="button" id="reset-filters" class="btn btn-inverse col-md-5 col-md-offset-1"><i class="fa fa-refresh"></i> @lang('app.reset')</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover toggle-circle default footable-loaded footable" id="users-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('app.name')</th>
                            <th>@lang('app.email')</th>
                            <th>@lang('app.package')</th>
                            <th>@lang('modules.accountSettings.companyLogo')</th>
                            <th>@lang('app.status')</th>
                            <th>@lang('modules.credit-notes.currency')</th>
                            <th>@lang('app.details')</th>
                            <th>@lang('app.action')</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{--Ajax Modal--}}
    <div class="modal fade bs-modal-md in" id="packageUpdateModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" id="modal-data-application">
            <form class="ajax-form" id="update-company-form">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading">Change Package</span>
                    </div>
                    <div class="modal-body">
                        Loading...
                    </div>
                    <div class="modal-footer">
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"><i
                                        class="fa fa-check"></i> @lang('app.update')</button>

                            <button type="button" class="btn btn-default" data-dismiss="modal">@lang('app.back')</button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- .row -->

@endsection

@push('footer-script')
    <script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(function() {
            var modal = $('#packageUpdateModal');
            tableLoad();
            $('#reset-filters').click(function () {
                $('#filter-form')[0].reset();
                $('#filter-form').find('select').selectpicker('render');
                tableLoad();
            });
            var table;
            $('#apply-filters').click(function () {
                tableLoad();
            });


            $('.toggle-filter').click(function () {
                $('#ticket-filters').toggle('slide');
            })

            $('body').on('click', '.package-update-button', function () {
                const url = '{{ route('super-admin.companies.edit-package.get', ':companyId') }}' . replace(':companyId', $(this).data(
                    'company-id'
                ));
                $.easyAjax({
                    type: 'GET',
                    url: url,
                    blockUI: false,
                    messagePosition: "inline",
                    success: function (response) {
                        if (response.status === "success" && response.data) {
                            modal.find('.modal-body').html(response.data).closest('#packageUpdateModal').modal('show');
                            tableLoad();
                        } else {
                            modal.find('.modal-body').html('Loading...').closest('#packageUpdateModal').modal('show');
                        }
                    }
                });
            });

            modal.on('bs-modal-hide', function () {
                modal.find('.modal-body').html('Loading...');
            });
        });

        tableLoad = () => {
            var packageName = $('#package').val();
            var packageType = $('#type').val();

            table = $('#users-table').dataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                stateSave: true,
                destroy: true,
                ajax: '{!! route('super-admin.companies.data') !!}?package='+packageName+'&type='+packageType,
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
                    { data: 'company_name', name: 'company_name' },
                    { data: 'company_email', name: 'company_email' },
                    { data: 'package', name: 'package.name', 'sortable':false },
                    { data: 'logo', name: 'logo', 'sortable':false},
                    { data: 'status', name: 'status' },
                    { data: 'currency', name: 'currency.currency_name', 'sortable':false },
                    { data: 'details', name: 'details', 'sortable':false },
                    { data: 'action', name: 'action' }
                ]
            });
        }
        $('body').on('click', '.sa-params', function(){
            var id = $(this).data('user-id');
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover the deleted company!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel please!",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm){
                if (isConfirm) {

                    var url = "{{ route('super-admin.companies.destroy',':id') }}";
                    url = url.replace(':id', id);

                    var token = "{{ csrf_token() }}";

                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: {'_token': token, '_method': 'DELETE'},
                        success: function (response) {
                            if (response.status == "success") {
                                $.unblockUI();
                                var total = $('#totalCompanies').text();
                                $('#totalCompanies').text(parseInt(total) - parseInt(1));
                                table._fnDraw();
                            }
                        }
                    });
                }
            });
        });

    </script>
@endpush
