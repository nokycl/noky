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
                <li class="active">@lang('app.edit')</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
    <link rel="stylesheet"
          href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
@endpush

@section('content')

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-inverse">
                <div class="panel-heading"> @lang('modules.employees.updateTitle')</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        {!! Form::open(['id'=>'updateEmployee','class'=>'ajax-form','method'=>'PUT']) !!}
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label>@lang('modules.employees.employeeName')</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               value="{{ $userDetail->name }}" autocomplete="nope">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('modules.employees.employeeEmail')</label>
                                        <input type="email" name="email" id="email" class="form-control"
                                               value="{{ $userDetail->email }}" autocomplete="nope">
                                        <span class="help-block">Employee will login using this email.</span>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('modules.employees.employeePassword')</label>
                                        <input type="password" style="display: none">
                                        <input type="password" name="password" id="password" class="form-control" autocomplete="nope">
                                        <span class="help-block"> @lang('modules.employees.updatePasswordNote')</span>
                                    </div>
                                </div>
                                <!--/span-->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('app.mobile')</label>
                                        <input type="tel" name="mobile" id="mobile" class="form-control"
                                               value="{{ $userDetail->mobile }}" autocomplete="nope">
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('modules.employees.gender')</label>
                                        <select name="gender" id="gender" class="form-control">
                                            <option @if($userDetail->gender == 'male') selected
                                                    @endif value="male">@lang('app.male')</option>
                                            <option @if($userDetail->gender == 'female') selected
                                                    @endif value="female">@lang('app.female')</option>
                                            <option @if($userDetail->gender == 'others') selected
                                                    @endif value="others">@lang('app.others')</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--/row-->

                            <div class="row">
                                <div class="col-md-6">
                                    <label>@lang('modules.profile.profilePicture')</label>
                                    <div class="form-group">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                @if(is_null($userDetail->image))
                                                    <img src="https://placeholdit.imgix.net/~text?txtsize=25&txt=@lang('modules.profile.uploadPicture')&w=200&h=150"
                                                         alt=""/>
                                                @else
                                                    <img src="{{ asset('user-uploads/avatar/'.$userDetail->image) }}"
                                                         alt=""/>
                                                @endif
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail"
                                                 style="max-width: 200px; max-height: 150px;"></div>
                                            <div>
                                <span class="btn btn-info btn-file">
                                    <span class="fileinput-new"> @lang('app.selectImage') </span>
                                    <span class="fileinput-exists"> @lang('app.change') </span>
                                    <input type="file" name="image" id="image"> </span>
                                                <a href="javascript:;" class="btn btn-danger fileinput-exists"
                                                   data-dismiss="fileinput"> @lang('app.remove') </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" id="save-form" class="btn btn-success"><i
                                        class="fa fa-check"></i> @lang('app.update')</button>
                            <a href="{{ route('super-admin.dashboard') }}" class="btn btn-default">@lang('app.back')</a>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>    <!-- .row -->

@endsection

@push('footer-script')
    <script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

    <script>
        $("#joining_date, .date-picker").datepicker({
            todayHighlight: true,
            autoclose: true
        });


        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route('super-admin.profile.update', [$userDetail->id])}}',
                container: '#updateEmployee',
                type: "POST",
                redirect: true,
                file: true,
            })
        });
    </script>
@endpush

