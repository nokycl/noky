@extends('layouts.member-app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }} #{{ $project->id }} - <span class="font-bold">{{ ucwords($project->project_name) }}</span></h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-6 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ route('member.dashboard') }}">@lang('app.menu.home')</a></li>
                <li><a href="{{ route('member.projects.index') }}">{{ __($pageTitle) }}</a></li>
                <li class="active">@lang('modules.projects.projectMembers')</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
<link rel="stylesheet" href="{{ asset('plugins/bower_components/icheck/skins/all.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/multiselect/css/multi-select.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
@endpush

@section('content')

    <div class="row">
        <div class="col-md-12">

            <section>
                <div class="sttabs tabs-style-line">
                    <div class="white-box">

                        <nav>
                            <ul>
                                <li><a href="{{ route('member.projects.show', $project->id) }}"><span>@lang('modules.projects.overview')</span></a></li>

                                <li class="tab-current"><a href="{{ route('member.project-members.show', $project->id) }}"><span>@lang('modules.projects.members')</span></a></li>

                                @if(in_array('tasks',$modules))
                                <li ><a href="{{ route('member.tasks.show', $project->id) }}"><span>@lang('app.menu.tasks')</span></a></li>
                                @endif
                                <li><a href="{{ route('member.files.show', $project->id) }}"><span>@lang('modules.projects.files')</span></a></li>
                                @if(in_array('timelogs',$modules))
                                <li><a href="{{ route('member.time-log.show-log', $project->id) }}"><span>@lang('app.menu.timeLogs')</span></a></li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                    <div class="content-wrap">
                        <section id="section-line-3" class="show">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">@lang('modules.projects.members')</div>
                                        <div class="panel-wrapper collapse in">
                                            <div class="panel-body">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th>@lang('app.name')</th>
                                                        <th>@lang('app.action')</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse($project->members as $member)
                                                        <tr>
                                                            <td>
                                                                {!!  ($member->user->image) ? '<img src="'.asset('user-uploads/avatar/'.$member->user->image).'"
                                                        alt="user" class="img-circle" width="40">' : '<img src="'.asset('default-profile-2.png').'"
                                                        alt="user" class="img-circle" width="40">' !!}
                                                                {{ ucwords($member->user->name) }}
                                                            </td>
                                                            <td>
                                                                @if($project->isProjectAdmin || $user->can('add_projects'))
                                                                  <a href="javascript:;" data-member-id="{{ $member->id }}" class="btn btn-sm btn-danger btn-rounded delete-members"><i class="fa fa-times"></i> @lang('app.remove')</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td>
                                                                @lang('messages.noMemberAddedToProject')
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($project->isProjectAdmin || $user->can('add_projects'))
                                    <div class="col-md-6">
                                    <div class="white-box">
                                        <h3>@lang('modules.projects.addMemberTitle')</h3>

                                        {!! Form::open(['id'=>'createMembers','class'=>'ajax-form','method'=>'POST']) !!}

                                        <div class="form-body">

                                            {!! Form::hidden('project_id', $project->id) !!}

                                            <div class="form-group" id="user_id">
                                                <select class="select2 m-b-10 select2-multiple " multiple="multiple"
                                                        data-placeholder="Choose Members" name="user_id[]">
                                                    @foreach($employees as $emp)
                                                        <option value="{{ $emp->id }}">{{ ucwords($emp->name). ' ['.$emp->email.']' }} @if($emp->id == $user->id)
                                                                (YOU) @endif</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-actions">
                                                <button type="submit" id="save-members" class="btn btn-success"><i
                                                            class="fa fa-check"></i> @lang('app.save')
                                                </button>
                                            </div>
                                        </div>

                                        {!! Form::close() !!}

                                    </div>
                                </div>
                                @endif
                            </div>
                        </section>

                    </div><!-- /content -->
                </div><!-- /tabs -->
            </section>
        </div>


    </div>
    <!-- .row -->

@endsection

@push('footer-script')
<script src="{{ asset('js/cbpFWTabs.js') }}"></script>
<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/multiselect/js/jquery.multi-select.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
    //    (function () {
    //
    //        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
    //            new CBPFWTabs(el);
    //        });
    //
    //    })();

    $(".select2").select2({
        formatNoMatches: function () {
            return "{{ __('messages.noRecordFound') }}";
        }
    });

    //    save project members
    $('#save-members').click(function () {
        $.easyAjax({
            url: '{{route('member.project-members.store')}}',
            container: '#createMembers',
            type: "POST",
            data: $('#createMembers').serialize(),
            success: function (response) {
                if (response.status == "success") {
                    $.unblockUI();
//                                    swal("Deleted!", response.message, "success");
                    window.location.reload();
                }
            }
        })
    });


    $('body').on('click', '.delete-members', function(){
        var id = $(this).data('member-id');
        swal({
            title: "Are you sure?",
            text: "This will remove the member from the project.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            cancelButtonText: "No, cancel please!",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function(isConfirm){
            if (isConfirm) {

                var url = "{{ route('member.project-members.destroy',':id') }}";
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
                            window.location.reload();
                        }
                    }
                });
            }
        });
    });


</script>
@endpush
