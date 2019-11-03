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
                <li><a href="{{ route('admin.dashboard') }}">@lang("app.menu.home")</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/morrisjs/morris.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
@endpush

@section('content')



    <div class="white-box">
        <div class="row m-b-10">
            <h2>@lang('app.filterResults')</h2>
            {!! Form::open(['id'=>'storePayments','class'=>'ajax-form','method'=>'POST']) !!}

            <div class="col-md-5">
                <div class="example">
                    <h5 class="box-title m-t-30">@lang('app.selectDateRange')</h5>

                    <div class="input-daterange input-group" id="date-range">
                        <input type="text" class="form-control" id="start-date" placeholder="@lang('app.startDate')"
                        value="{{ $fromDate->format('Y-m-d') }}"/>
                        <span class="input-group-addon bg-info b-0 text-white">@lang('app.to')</span>
                        <input type="text" class="form-control" id="end-date" placeholder="@lang('app.endDate')"
                        value="{{ $toDate->format('Y-m-d') }}"/>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <h5 class="box-title m-t-30">@lang('app.employee') @lang('app.name')</h5>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <select class="select2 form-control" data-placeholder="@lang('app.select') @lang('app.employee')" id="employee_id">
                                <option value=""></option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ ucwords($employee->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <button type="button" class="btn btn-success" id="filter-results"><i class="fa fa-check"></i> @lang('app.apply')
                </button>
            </div>
            {!! Form::close() !!}

        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="white-box">
                <h3 class="box-title">@lang("modules.leaveReport.leaveReport")</h3>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover toggle-circle default footable-loaded footable"
                           id="leave-table">
                        <thead>
                        <tr>
                            <th>@lang('app.id')</th>
                            <th>@lang('app.employee')</th>
                            <th>@lang('app.approved') @lang('app.menu.leaves')</th>
                            <th>@lang('app.pending') @lang('app.menu.leaves')</th>
                            <th>@lang('app.upcoming') @lang('app.menu.leaves')</th>
                            <th>@lang('app.action')</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>

    </div>



    <div class="modal fade bs-example-modal-lg" id="leave-details" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
                </div>
                <div class="modal-body">
                    Loading...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection

@push('footer-script')

    <script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/raphael/raphael-min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/morrisjs/morris.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>

    <script>

        $(".select2").select2({
            formatNoMatches: function () {
                return "{{ __('messages.noRecordFound') }}";
            }
        });

        jQuery('#date-range').datepicker({
            toggleActive: true,
            format: 'yyyy-mm-dd'
        });
        loadTable();
        $('#filter-results').click(function () {
            loadTable();
        });


        function loadTable(){
            var startDate = $('#start-date').val();

            if (startDate == '') {
                startDate = null;
            }

            var endDate = $('#end-date').val();

            if (endDate == '') {
                endDate = null;
            }

            var employeeId = $('#employee_id').val();
            if (!employeeId) {
                employeeId = 0;
            }

            var url = '{!!  route('admin.leave-report.data', [':startDate', ':endDate', ':employeeId']) !!}';

            url = url.replace(':startDate', startDate);
            url = url.replace(':endDate', endDate);
            url = url.replace(':employeeId', employeeId);

            var table = $('#leave-table').dataTable({
                responsive: true,
                //processing: true,
                serverSide: true,
                destroy: true,
                ajax: url,
                language: {
                    "url": "<?php echo __("app.datatable") ?>"
                },
                "fnDrawCallback": function( oSettings ) {
                    $("body").tooltip({
                        selector: '[data-toggle="tooltip"]'
                    });
                },
                columns: [
                    { data: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'employee', name: 'employee' },
                    { data: 'approve', name: 'approve' },
                    { data: 'pending', name: 'pending' },
                    { data: 'upcoming', name: 'upcoming' },
                    { data: 'action', name: 'action' }
                ]
            });

        }

        $('#leave-table').on( 'click', '.view-approve', function (event) {
            var startDate = $('#start-date').val();

            if (startDate == '') {
                startDate = null;
            }

            var endDate = $('#end-date').val();

            if (endDate == '') {
                endDate = null;
            }

            event.preventDefault();
            var id = $(this).data('pk');
            var url = '{{ route('admin.leave-report.show', ':id') }}?startDate=' + startDate + '&endDate=' + endDate;
            url = url.replace(':id', id);
            $.ajaxModal('#leave-details', url);
        });

        $('#leave-table').on( 'click', '.view-pending', function (event) {
            var startDate = $('#start-date').val();

            if (startDate == '') {
                startDate = null;
            }

            var endDate = $('#end-date').val();

            if (endDate == '') {
                endDate = null;
            }
            event.preventDefault();
            var id = $(this).data('pk');
            var url = '{{ route('admin.leave-report.pending-leaves', ':id') }}?startDate=' + startDate + '&endDate=' + endDate;
            url = url.replace(':id', id);
            $.ajaxModal('#leave-details', url);
        });

        $('#leave-table').on( 'click', '.view-upcoming', function (event) {
            var startDate = $('#start-date').val();

            if (startDate == '') {
                startDate = null;
            }

            var endDate = $('#end-date').val();

            if (endDate == '') {
                endDate = null;
            }
            event.preventDefault();
            var id = $(this).data('pk');
            var url = '{{ route('admin.leave-report.upcoming-leaves', ':id') }}?startDate=' + startDate + '&endDate=' + endDate;
            url = url.replace(':id', id);
            $.ajaxModal('#leave-details', url);
        });


        $('#leave-table').on( 'click', '.exportUserData', function (event) {

            var id = $(this).data('pk');
            var startDate = $('#start-date').val();

            if(startDate == ''){
                startDate = null;
            }

            var endDate = $('#end-date').val();

            if(endDate == ''){
                endDate = null;
            }

            var projectID = $('#project_id').val();

            if(projectID == ''){
                projectID = 0;
            }

            var url = '{{ route('admin.leave-report.export', [ ':id', ':startDate', ':endDate']) }}';
            url = url.replace(':startDate', startDate);
            url = url.replace(':endDate', endDate);
            url = url.replace(':id', id);

            window.location.href = url;
        });
    </script>
@endpush