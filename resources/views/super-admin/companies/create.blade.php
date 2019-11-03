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
                <li><a href="{{ route('super-admin.companies.index') }}">{{ __($pageTitle) }}</a></li>
                <li class="active">@lang('app.addNew')</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
@endpush

@section('content')

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-inverse">
                <div class="panel-heading"> @lang('app.add') @lang('app.company')</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">

                    <div class="panel-body">
                        {!! Form::open(['id'=>'createCompany','class'=>'ajax-form','method'=>'POST', 'enctype' => 'multipart/form-data']) !!}
                            <div class="form-body">
                                <h3 class="box-title">Company Details</h3>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="company_name">@lang('modules.accountSettings.companyName')</label>
                                            <input type="text" class="form-control" id="company_name" name="company_name"
                                                   value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="company_email">@lang('modules.accountSettings.companyEmail')</label>
                                            <input type="email" class="form-control" id="company_email" name="company_email"
                                                   value="">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="company_phone">@lang('modules.accountSettings.companyPhone')</label>
                                            <input type="tel" class="form-control" id="company_phone" name="company_phone"
                                                   value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">@lang('modules.accountSettings.companyWebsite')</label>
                                            <input type="text" class="form-control" id="website" name="website"
                                                   value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">@lang('modules.accountSettings.companyLogo')</label>

                                            <div class="col-md-12">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail"
                                                         style="width: 200px; height: 150px;">

                                                            <img src="https://placeholdit.imgix.net/~text?txtsize=25&txt=@lang('modules.accountSettings.uploadLogo')&w=200&h=150"
                                                                 alt=""/>
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail"
                                                         style="max-width: 200px; max-height: 150px;"></div>
                                                    <div>
                                <span class="btn btn-info btn-file">
                                    <span class="fileinput-new"> @lang('app.selectImage') </span>
                                    <span class="fileinput-exists"> @lang('app.change') </span>
                                    <input type="file" name="logo" id="logo"> </span>
                                                        <a href="javascript:;" class="btn btn-danger fileinput-exists"
                                                           data-dismiss="fileinput"> @lang('app.remove') </a>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('app.status')</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="">-</option>
                                                <option value="active">@lang('app.active')</option>
                                                <option value="inactive">@lang('app.inactive')</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">@lang('modules.accountSettings.companyAddress')</label>
                                            <textarea class="form-control" id="address" rows="5"
                                                      name="address"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">@lang('modules.accountSettings.defaultCurrency')</label>
                                            <select name="currency_id" id="currency_id" class="form-control">
                                                @foreach($currencies as $currency)
                                                    <option value="{{ $currency->id }}">{{ $currency->currency_symbol.' ('.$currency->currency_code.')' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">@lang('modules.accountSettings.defaultTimezone')</label>
                                            <select name="timezone" id="timezone" class="form-control select2">
                                                @foreach($timezones as $tz)
                                                    <option>{{ $tz }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">@lang('modules.accountSettings.changeLanguage')</label>
                                            <select name="locale" id="locale" class="form-control select2">
                                                <option value="en">English
                                                </option>
                                                @foreach($languageSettings as $language)
                                                    <option value="{{ $language->language_code }}">{{ $language->language_name ?? '' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <h3 class="box-title">@lang('modules.company.accountSetup')</h3>
                                <hr>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">@lang('modules.employees.employeeEmail')</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                   value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">@lang('modules.employees.employeePassword')</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                   value="">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-actions">
                                <button type="submit" id="save-form" class="btn btn-success"> <i class="fa fa-check"></i> @lang('app.save')</button>
                                <button type="reset" class="btn btn-default">@lang('app.reset')</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>    <!-- .row -->

@endsection

@push('footer-script')

    <script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script>
        $(".select2").select2({
            formatNoMatches: function () {
                return "{{ __('messages.noRecordFound') }}";
            }
        });

        $('#save-form').click(function () {

            $.easyAjax({
                url: '{{route('super-admin.companies.store')}}',
                container: '#createCompany',
                type: "POST",
                redirect: true,
                file: true,
            });
        });
    </script>

@endpush

