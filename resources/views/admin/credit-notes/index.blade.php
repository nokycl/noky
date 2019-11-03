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
<link rel="stylesheet" href="{{ asset('plugins/bower_components/dropzone-master/dist/dropzone.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">

@endpush

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
{{--                            <a href="{{ route('admin.all-credit-notes.create') }}" class="btn btn-outline btn-success btn-sm">@lang('modules.credit-notes.addCreditNote') <i class="fa fa-plus" aria-hidden="true"></i></a>--}}
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
                        <div class="col-md-3">
                            <h5 >@lang('app.project')</h5>
                            <div class="form-group">
                                {{--<label class="control-label">@lang('app.status')</label>--}}
                                <select class="form-control select2" name="projectID" id="projectID" data-style="form-control">
                                    <option value="all">@lang('app.all')</option>
                                    @forelse($projects as $project)
                                        <option value="{{$project->id}}">{{ ucfirst($project->project_name) }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group m-t-10">
                                <label class="control-label col-xs-12">&nbsp;</label>
                                <button type="button" id="apply-filters" class="btn btn-success col-md-6"><i class="fa fa-check"></i> @lang('app.apply')</button>
                                <button type="button" id="reset-filters" class="btn btn-inverse col-md-5 col-md-offset-1"><i class="fa fa-refresh"></i> @lang('app.reset')</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover toggle-circle default footable-loaded footable" id="credit-notes-table">
                        <thead>
                        <tr>
                            <th>@lang('app.id')</th>
                            <th>@lang('app.credit-note') #</th>
                            <th>@lang('app.invoice') #</th>
                            <th>@lang('app.project')</th>
                            <th>@lang('modules.credit-notes.total')</th>
                            <th>@lang('modules.credit-notes.creditNoteDate')</th>
                            <th>@lang('app.action')</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- .row -->

    {{--Ajax Modal--}}
    <div class="modal fade bs-modal-md in" id="creditNoteUploadModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading">@lang('modules.credit-notes.uploadInvoice')</span>
                </div>
                <div class="modal-body">
                    <div class="row" id="file-dropzone">
                        <div class="row m-b-20" id="file-dropzone">
                            <div class="col-md-12">
                                <form action="{{route('admin.creditNoteFile.store')}}"
                                      class="dropzone"
                                      id="file-upload-dropzone">
                                    {{ csrf_field() }}
                                    <div class="fallback">
                                        <input name="file" type="file" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal">@lang('app.close')</button>
                    <button type="button" class="btn blue" data-dismiss="modal">@lang('app.save')</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--Ajax Modal Ends--}}

@endsection

@push('footer-script')
<script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
<script src="{{ asset('plugins/bower_components/dropzone-master/dist/dropzone.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>

<script>
    $(".select2").select2({
        formatNoMatches: function () {
            return "{{ __('messages.noRecordFound') }}";
        }
    });
    var table;
    $(function() {
        loadTable();
        jQuery('#date-range').datepicker({
            toggleActive: true,
            format: 'yyyy-mm-dd',
            language: '{{ $global->locale }}',
            autoclose: true
        });
        $('body').on('click', '.sa-params', function(){
            var id = $(this).data('credit-notes-id');
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover the deleted credit notes!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel please!",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm){
                if (isConfirm) {

                    var url = "{{ route('admin.all-credit-notes.destroy',':id') }}";
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

        $('.table-responsive').on('click', '.credit-notes-upload', function(){
            var creditNoteId = $(this).data('credit-notes-id');
            console.log(creditNoteId);
            $('#file-upload-dropzone').prepend('<input name="credit_note_id", value="' + creditNoteId + '" type="hidden">');
        });
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

        // var status = $('#status').val();
        var projectID = $('#projectID').val();

        table = $('#credit-notes-table').dataTable({
            responsive: true,
            destroy: true,
            processing: true,
            serverSide: true,
            ajax: '{!! route('admin.all-credit-notes.data') !!}?startDate=' + startDate + '&endDate=' + endDate + '&projectID=' + projectID,
            "order": [[ 0, "desc" ]],
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
                { data: 'cn_number', name: 'cn_number' },
                { data: 'invoice_number', name: 'invoice_number' },
                { data: 'project_name', name: 'project_name' },
                { data: 'total', name: 'total' },
                { data: 'issue_date', name: 'issue_date' },
                { data: 'action', name: 'action', width: '12%' }
            ]
        });
    }
    //    $('#file-upload-dropzone').dropzone({
    Dropzone.options.fileUploadDropzone = {
        paramName: "file", // The name that will be used to transfer the file
        dictDefaultMessage: "@lang('modules.projects.dropFile')",
        uploadMultiple: false,
        dictCancelUpload: "Cancel",
        accept: function (file, done) {
            done();
        },
        init: function () {
            this.on('addedfile', function(){
                if(this.files.length > 1) {
                    this.removeFile(this.files[0]);
                }
            });
            this.on("success", function (file, response) {
            });
            var newDropzone = this;

            $('#creditNotesUploadModal').on('hide.bs.modal', function(){
                newDropzone.removeAllFiles(true);
            });

        }
    };
    //    });

    $('.toggle-filter').click(function () {
        $('#ticket-filters').toggle('slide');
    });

    $('#apply-filters').click(function () {
        loadTable();
    });

    $('#reset-filters').click(function () {
        $('#filter-form')[0].reset();
        $('#projectID').val('all');
        // $('#status').selectpicker('render');
        $('#projectID').select2();

        loadTable();
    })

    function exportData(){

        var startDate = $('#start-date').val();

        if (startDate == '') {
            startDate = null;
        }

        var endDate = $('#end-date').val();

        if (endDate == '') {
            endDate = null;
        }

        // var status = $('#status').val();
        var projectID = $('#projectID').val();

        var url = '{{ route('admin.all-credit-notes.export', [':startDate', ':endDate', ':projectID']) }}';
        url = url.replace(':startDate', startDate);
        url = url.replace(':endDate', endDate);
        url = url.replace(':projectID', projectID);

        window.location.href = url;
    }

</script>
@endpush