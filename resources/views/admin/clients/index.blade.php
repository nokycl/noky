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
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">


@endpush

@section('content')

    <div class="row">
        <div class="col-md-3">
            <div class="white-box bg-inverse">
                <h3 class="box-title text-white">@lang('modules.dashboard.totalClients')</h3>
                <ul class="list-inline two-part">
                    <li><i class="icon-user text-white"></i></li>
                    <li class="text-right"><span id="totalWorkingDays" class="counter text-white">{{ $totalClients }}</span></li>
                </ul>
            </div>
        </div>

        <div class="col-md-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <a href="{{ route('admin.clients.create') }}" class="btn btn-outline btn-success btn-sm">@lang('modules.client.addNewClient') <i class="fa fa-plus" aria-hidden="true"></i></a>
                            <a href="javascript:;" id="toggle-filter" class="btn btn-outline btn-danger btn-sm toggle-filter"><i
                                        class="fa fa-sliders"></i> @lang('app.filterResults')</a>
                        </div>

                    </div>
                    <div class="col-sm-6 text-right hidden-xs">
                        <div class="form-group">
                            <a href="javascript:;" onclick="exportData()" class="btn btn-info btn-sm"><i class="ti-export" aria-hidden="true"></i> @lang('app.exportExcel')</a>
                        </div>
                    </div>
                </div>
                <div class="row b-b b-t" style="display: none; background: #fbfbfb;" id="ticket-filters">
                    <div class="col-md-12">
                        <h4>@lang('app.filterBy') <a href="javascript:;" class="pull-right toggle-filter"><i class="fa fa-times-circle-o"></i></a></h4>
                    </div>
                    <form action="" id="filter-form">
                        <div class="col-md-4">
                            <h5 >@lang('app.selectDateRange')</h5>
                            <div class="input-daterange input-group" id="date-range">
                                <input type="text" class="form-control" id="start-date" placeholder="@lang('app.startDate')"
                                       value=""/>
                                <span class="input-group-addon bg-info b-0 text-white">@lang('app.to')</span>
                                <input type="text" class="form-control" id="end-date" placeholder="@lang('app.endDate')"
                                       value=""/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <h5 >@lang('app.status')</h5>
                                <select class="form-control" name="status" id="status" data-style="form-control">
                                    <option value="all">@lang('modules.client.all')</option>
                                    <option value="active">@lang('app.active')</option>
                                    <option value="deactive">@lang('app.deactive')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <h5 >@lang('app.client')</h5>
                                <select class="form-control select2" name="client" id="client" data-style="form-control">
                                    <option value="all">@lang('modules.client.all')</option>
                                    @forelse($clients as $client)
                                        <option value="{{$client->id}}">{{ $client->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group p-t-10">
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
                        <th>@lang('app.id')</th>
                        <th>@lang('app.name')</th>
                        <th>@lang('modules.client.companyName')</th>
                        <th>@lang('app.email')</th>
                        <th>@lang('app.status')</th>
                        <th>@lang('app.createdAt')</th>
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
    <script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script>
        $(".select2").select2({
            formatNoMatches: function () {
                return "{{ __('messages.noRecordFound') }}";
            }
        });
        jQuery('#date-range').datepicker({
            toggleActive: true,
            format: 'yyyy-mm-dd',
            language: '{{ $global->locale }}',
            autoclose: true
        });
        var table;
        $(function() {
            loadTable();
            $('body').on('click', '.sa-params', function(){
                var id = $(this).data('user-id');
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover the deleted user!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel please!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function(isConfirm){
                    if (isConfirm) {

                        var url = "{{ route('admin.clients.destroy',':id') }}";
                        url = url.replace(':id', id);

                        var token = "{{ csrf_token() }}";

                        $.easyAjax({
                            type: 'POST',
                            url: url,
                            data: {'_token': token, '_method': 'DELETE'},
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

            });

            function loadTable() {
                var startDate = $('#start-date').val();

                if (startDate == '') {
                    startDate = null;
                }

                var endDate = $('#end-date').val();

                if (endDate == '') {
                    endDate = null;
                }
                var status = $('#status').val();
                var client = $('#client').val();

                table = $('#users-table').dataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    stateSave: true,
                    ajax: '{!! route('admin.clients.data') !!}?startDate=' + startDate + '&endDate=' + endDate + '&client=' + client + '&status=' + status,
                    language: {
                        "url": "<?php echo __("app.datatable") ?>"
                    },
                    "fnDrawCallback": function (oSettings) {
                        $("body").tooltip({
                            selector: '[data-toggle="tooltip"]'
                        });
                    },
                    columns: [
                        { data: 'DT_RowIndex', orderable: false, searchable: false },
                        {data: 'name', name: 'name'},
                        {data: 'company_name', name: 'company_name'},
                        {data: 'email', name: 'email'},
                        {data: 'status', name: 'status'},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'action', name: 'action'}
                    ]
                })
            }

        $('.toggle-filter').click(function () {
            $('#ticket-filters').toggle('slide');
        })

        $('#apply-filters').click(function () {
            loadTable();
        });

        $('#reset-filters').click(function () {
            $('#filter-form')[0].reset();
            $('#status').val('all');
            $('.select2').val('all');
            $('#filter-form').find('select').select2();
            loadTable();
        })

        function exportData(){

            var client = $('#client').val();
            var status = $('#status').val();

            var url = '{{ route('admin.clients.export', [':status', ':client']) }}';
            url = url.replace(':client', client);
            url = url.replace(':status', status);

            window.location.href = url;
        }

    </script>
@endpush