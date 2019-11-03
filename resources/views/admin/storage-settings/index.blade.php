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
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
@endpush

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">@lang('app.menu.storageSettings')</div>

                <div class="vtabs customvtab m-t-10">
                    @include('sections.admin_setting_menu')

                    <div class="tab-content">
                        <div id="vhome3" class="tab-pane active">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="white-box">

                                        <div class="row">
                                            <div class="col-sm-12 col-xs-12 ">
                                                {!! Form::open(['id'=>'updateSettings','class'=>'ajax-form','method'=>'POST']) !!}
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h3 class="box-title text-success">File Storage</h3>
                                                            <hr class="m-t-0 m-b-20">
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Select Storage</label>
                                                                <select class="select2 form-control" id="storage" name="storage">
                                                                    <option value="local" @if(isset($localCredentials) && $localCredentials->status == 'enabled') selected @endif>Local (Default)</option>
                                                                    <option value="aws" @if(isset($awsCredentials) && $awsCredentials->status == 'enabled') selected @endif>AWS Storage (Amazon Web Services)</option>
                                                                    <option value="google" @if(isset($googleCredentials) && $googleCredentials->status == 'enabled') selected @endif>Google Drive Storage</option>
                                                                    <option value="dropbox" @if(isset($dropboxCredentials) && $dropboxCredentials->status == 'enabled') selected @endif>Dropbox Storage</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 aws-form">
                                                            <div class="form-group">
                                                                <label>AWS Key</label>
                                                                <input type="text" class="form-control" name="aws_key" @if(isset($awsCredentials) && isset($awsCredentials->key)) value="{{ $awsCredentials->key }}" @endif>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>AWS Secret</label>
                                                                <input type="text" class="form-control" name="aws_secret" @if(isset($awsCredentials) && isset($awsCredentials->secret)) value="{{ $awsCredentials->secret }}" @endif>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>AWS Region</label>
                                                                <input type="text" class="form-control" id="company_name" name="aws_region" @if(isset($awsCredentials) && isset($awsCredentials->region)) value="{{ $awsCredentials->region }}" @endif>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>AWS Bucket</label>
                                                                <input type="text" class="form-control" id="company_name" name="aws_bucket" @if(isset($awsCredentials) && isset($awsCredentials->bucket)) value="{{ $awsCredentials->bucket }}" @endif>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 google-form">
                                                            <div class="form-group">
                                                                <label>Google Client ID</label>
                                                                <input type="text" class="form-control" name="google_client_id" @if(isset($googleCredentials) && isset($googleCredentials->clientId)) value="{{ $googleCredentials->clientId }}" @endif>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Google Secret</label>
                                                                <input type="text" class="form-control" name="google_client_secret" @if(isset($googleCredentials) && isset($googleCredentials->clientSecret)) value="{{ $googleCredentials->clientSecret }}" @endif>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Google Refresh Token</label>
                                                                <input type="text" class="form-control" name="google_refresh_token" @if(isset($googleCredentials) && isset($googleCredentials->refreshToken)) value="{{ $googleCredentials->refreshToken }}" @endif>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 dropbox-form">
                                                            <div class="form-group">
                                                                <label>Dropbox Token</label>
                                                                <input type="text" class="form-control" name="dropbox_token" @if(isset($dropboxCredentials) && isset($dropboxCredentials->auth_keys)) value="{{ $dropboxCredentials->auth_keys }}" @endif>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <!--/row-->

                                                </div>
                                                <div class="form-actions m-t-20">
                                                    <button type="submit" id="save-form-2" class="btn btn-success"><i class="fa fa-check"></i>
                                                        @lang('app.save')
                                                    </button>
                                                    <button type="reset" class="btn btn-default">@lang('app.reset')</button>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>
    <!-- .row -->



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

        $(function () {
           var type = $('#storage').val();
            if (type == 'aws') {
                $('.aws-form').css('display', 'block');
                $('.google-form').css('display', 'none');
                $('.dropbox-form').css('display', 'none');
            } else if(type == 'google') {
                $('.google-form').css('display', 'block');
                $('.aws-form').css('display', 'none');
                $('.dropbox-form').css('display', 'none');
            } else if(type == 'local') {
                $('.aws-form').css('display', 'none');
                $('.google-form').css('display', 'none');
                $('.dropbox-form').css('display', 'none');
            } else if(type == 'dropbox') {
                $('.dropbox-form').css('display', 'block');
                $('.aws-form').css('display', 'none');
                $('.google-form').css('display', 'none');
            }
        });

        $('#storage').on('change', function(event) {
            event.preventDefault();
            var type = $(this).val();
            if (type == 'aws') {
                $('.aws-form').css('display', 'block');
                $('.google-form').css('display', 'none');
                $('.dropbox-form').css('display', 'none');
            } else if(type == 'google') {
                $('.google-form').css('display', 'block');
                $('.aws-form').css('display', 'none');
                $('.dropbox-form').css('display', 'none');
            } else if(type == 'local') {
                $('.aws-form').css('display', 'none');
                $('.google-form').css('display', 'none');
                $('.dropbox-form').css('display', 'none');
            } else if(type == 'dropbox') {
                $('.dropbox-form').css('display', 'block');
                $('.aws-form').css('display', 'none');
                $('.google-form').css('display', 'none');
            }
        });

        $('#save-form-2').click(function () {
            $.easyAjax({
                url: '{{ route('admin.storage-settings.store')}}',
                container: '#updateSettings',
                type: "POST",
                redirect: true,
                data: $('#updateSettings').serialize()
            })
        });
    </script>
@endpush