@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }} #{{ $project->id }} - <span
                        class="font-bold">{{ ucwords($project->project_name) }}</span></h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-6 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
                <li><a href="{{ route('admin.projects.index') }}">{{ __($pageTitle) }}</a></li>
                <li class="active">@lang('app.menu.invoices')</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">

            <section>
                <div class="sttabs tabs-style-line">
                    <div class="white-box">
                        <nav>
                            <ul>
                                <li ><a href="{{ route('admin.projects.show', $project->id) }}"><span>@lang('modules.projects.overview')</span></a></li>

                                @if(in_array('employees',$modules))
                                <li><a href="{{ route('admin.project-members.show', $project->id) }}"><span>@lang('modules.projects.members')</span></a></li>
                                @endif

                                <li><a href="{{ route('admin.milestones.show', $project->id) }}"><span>@lang('modules.projects.milestones')</span></a></li>

                                @if(in_array('tasks',$modules))
                                <li><a href="{{ route('admin.tasks.show', $project->id) }}"><span>@lang('app.menu.tasks')</span></a></li>
                                @endif

                                <li><a href="{{ route('admin.files.show', $project->id) }}"><span>@lang('modules.projects.files')</span></a></li>

                                @if(in_array('invoices',$modules))
                                <li class="tab-current"><a href="{{ route('admin.invoices.show', $project->id) }}"><span>@lang('app.menu.invoices')</span></a></li>
                                @endif

                                @if(in_array('timelogs',$modules))
                                <li><a href="{{ route('admin.time-logs.show', $project->id) }}"><span>@lang('app.menu.timeLogs')</span></a></li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                    <div class="content-wrap">
                        <section id="section-line-3" class="show">
                            <div class="row">
                                <div class="col-md-12" id="invoices-list-panel">
                                    <div class="white-box">
                                        <h2>@lang('app.menu.invoices')</h2>

                                        <div class="row m-b-10">
                                            <div class="col-md-12">
                                                <a href="javascript:;" id="show-invoice-modal"
                                                   class="btn btn-success btn-outline"><i class="ti-plus"></i> @lang('modules.invoices.addInvoice')</a>
                                            </div>
                                        </div>

                                        <ul class="list-group" id="invoices-list">
                                            @forelse($project->invoices as $invoice)
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-sm-5 col-xs-12">
                                                            {{ $invoice->invoice_number }}
                                                        </div>
                                                        <div class="col-sm-2">
                                                            {{ $invoice->currency->currency_symbol }} {{ $invoice->total }}
                                                        </div>
                                                        <div class="col-sm-2 col-xs-12">
                                                            @if($invoice->status == 'unpaid')
                                                                <label class="label label-danger">@lang('modules.invoices.unpaid')</label>
                                                            @else
                                                                <label class="label label-success">@lang('modules.invoices.paid')</label>
                                                            @endif
                                                        </div>
                                                        <div class="col-sm-3 col-xs-12">
                                                            <a href="{{ route('admin.invoices.download', $invoice->id) }}" data-toggle="tooltip" data-original-title="Download" class="btn btn-inverse btn-circle"><i class="fa fa-download"></i></a>
                                                            &nbsp;&nbsp;
                                                            <a href="javascript:;" data-toggle="tooltip" data-original-title="Delete" data-invoice-id="{{ $invoice->id }}" class="btn btn-danger btn-circle sa-params"><i class="fa fa-times"></i></a>

                                                            <span class="m-l-10">{{ $invoice->issue_date->format($global->date_format) }}</span>
                                                        </div>
                                                    </div>
                                                </li>
                                            @empty
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-7">
                                                            @lang('messages.noInvoice')
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforelse
                                        </ul>
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

    {{--Ajax Modal--}}
    <div class="modal fade bs-modal-lg in" id="add-invoice-modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                    <button type="button" class="btn btn-success">Save changes</button>
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
    $('#show-invoice-modal').click(function(){
        var url = '{{ route('admin.invoices.createInvoice', $project->id)}}';
        $('#modelHeading').html('Add Invoice');
        $.ajaxModal('#add-invoice-modal',url);
    })

    $('body').on('click', '.sa-params', function () {
        var id = $(this).data('invoice-id');
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover the deleted invoice!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel please!",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {

                var url = "{{ route('admin.invoices.destroy',':id') }}";
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
                            $('#invoices-list-panel ul.list-group').html(response.html);

                        }
                    }
                });
            }
        });
    });
</script>
@endpush
