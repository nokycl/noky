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

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <a href="{{ route('admin.teams.create') }}" class="btn btn-outline btn-success btn-sm">@lang('app.add') @lang('app.team') <i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                    </div>

                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover toggle-circle default footable-loaded footable" id="users-table">
                        <thead>
                        <tr>
                            <th>@lang('app.id')</th>
                            <th>@lang('app.menu.teams')</th>
                            <th>@lang('app.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($groups as $group)
                            <tr>
                                <td>{{ $group->id }}</td>
                                <td>{{ $group->team_name }} <label class="label label-success">{{ count($group->members) }} @lang('modules.projects.members')</label></td>
                                <td>
                                    <a href="{{ route('admin.teams.edit', [$group->id]) }}" class="btn btn-info"><i class="icon-settings"></i> @lang('app.manage')</a>
                                    <a href="javascript:;" data-group-id="{{ $group->id }}" class="btn btn-danger sa-params"><i class="fa fa-times"></i> @lang('app.delete')</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">@lang('messages.noRecordFound')</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- .row -->

@endsection

@push('footer-script')
    <script>
        $(function() {


            $('body').on('click', '.sa-params', function(){
                var id = $(this).data('group-id');
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover the deleted team!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel please!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function(isConfirm){
                    if (isConfirm) {

                        var url = "{{ route('admin.teams.destroy',':id') }}";
                        url = url.replace(':id', id);

                        var token = "{{ csrf_token() }}";

                        $.easyAjax({
                            type: 'DELETE',
                            url: url,
                            data: {'_token': token},
                            success: function (response) {
                                if (response.status == "success") {
                                    $.unblockUI();
                                    window.location.reload();
                                }
                            }
                        });
                    }
                });
            });



        });

    </script>
@endpush