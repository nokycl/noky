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
<link rel="stylesheet" href="{{ asset('plugins/bower_components/switchery/dist/switchery.min.css') }}">
@endpush

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">{{ __($pageTitle) }}</div>

                <div class="vtabs customvtab m-t-10">
                    @include('sections.notification_settings_menu')

                    <div class="tab-content">
                        <div id="vhome3" class="tab-pane active">
                            <div class="row">
                                <div class="col-md-12">

                                    <h3 class="box-title m-b-0">@lang("modules.emailSettings.notificationTitle")</h3>

                                    <p class="text-muted m-b-10 font-13">
                                        @lang("modules.emailSettings.notificationSubtitle")
                                    </p>

                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12 b-t p-t-20">
                                            {!! Form::open(['id'=>'editSettings','class'=>'ajax-form form-horizontal','method'=>'PUT']) !!}

                                                <div class="form-group">
                                                    <label class="control-label col-sm-8">@lang("modules.emailSettings.userRegistration")</label>

                                                    <div class="col-sm-4">
                                                        <div class="switchery-demo">
                                                            <input type="checkbox"
                                                                   @if($emailSettings[4]->send_email == 'yes') checked
                                                                   @endif class="js-switch change-email-setting"
                                                                   data-color="#99d683"
                                                                   data-setting-id="{{ $emailSettings[4]->id }}"/>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-sm-8">@lang("modules.emailSettings.employeeAssign")</label>

                                                    <div class="col-sm-4">
                                                        <div class="switchery-demo">
                                                            <input type="checkbox"
                                                                   @if($emailSettings[5]->send_email == 'yes') checked
                                                                   @endif class="js-switch change-email-setting"
                                                                   data-color="#99d683"
                                                                   data-setting-id="{{ $emailSettings[5]->id }}"/>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-sm-8">@lang("modules.emailSettings.newNotice")</label>

                                                    <div class="col-sm-4">
                                                        <div class="switchery-demo">
                                                            <input type="checkbox"
                                                                   @if($emailSettings[6]->send_email == 'yes') checked
                                                                   @endif class="js-switch change-email-setting"
                                                                   data-color="#99d683"
                                                                   data-setting-id="{{ $emailSettings[6]->id }}"/>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-sm-8">@lang("modules.emailSettings.taskAssign")</label>

                                                    <div class="col-sm-4">
                                                        <div class="switchery-demo">
                                                            <input type="checkbox"
                                                                   @if($emailSettings[7]->send_email == 'yes') checked
                                                                   @endif class="js-switch change-email-setting"
                                                                   data-color="#99d683"
                                                                   data-setting-id="{{ $emailSettings[7]->id }}"/>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-sm-8">@lang("modules.emailSettings.expenseAdded")</label>

                                                    <div class="col-sm-4">
                                                        <div class="switchery-demo">
                                                            <input type="checkbox"
                                                                   @if($emailSettings[0]->send_email == 'yes') checked
                                                                   @endif class="js-switch change-email-setting"
                                                                   data-color="#99d683"
                                                                   data-setting-id="{{ $emailSettings[0]->id }}"/>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-sm-8">@lang("modules.emailSettings.expenseMember")</label>

                                                    <div class="col-sm-4">
                                                        <div class="switchery-demo">
                                                            <input type="checkbox"
                                                                   @if($emailSettings[1]->send_email == 'yes') checked
                                                                   @endif class="js-switch change-email-setting"
                                                                   data-color="#99d683"
                                                                   data-setting-id="{{ $emailSettings[1]->id }}"/>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-sm-8">@lang("modules.emailSettings.expenseStatus")</label>

                                                    <div class="col-sm-4">
                                                        <div class="switchery-demo">
                                                            <input type="checkbox"
                                                                   @if($emailSettings[2]->send_email == 'yes') checked
                                                                   @endif class="js-switch change-email-setting"
                                                                   data-color="#99d683"
                                                                   data-setting-id="{{ $emailSettings[2]->id }}"/>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-sm-8">@lang("modules.emailSettings.ticketRequest")</label>

                                                    <div class="col-sm-4">
                                                        <div class="switchery-demo">
                                                            <input type="checkbox"
                                                                   @if($emailSettings[3]->send_email == 'yes') checked
                                                                   @endif class="js-switch change-email-setting"
                                                                   data-color="#99d683"
                                                                   data-setting-id="{{ $emailSettings[3]->id }}"/>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label class="control-label col-sm-8">@lang("modules.emailSettings.leaveRequest")</label>

                                                    <div class="col-sm-4">
                                                        <div class="switchery-demo">
                                                            <input type="checkbox"
                                                                   @if($emailSettings[8]->send_email == 'yes') checked
                                                                   @endif class="js-switch change-email-setting"
                                                                   data-color="#99d683"
                                                                   data-setting-id="{{ $emailSettings[8]->id }}"/>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-sm-8">@lang("modules.emailSettings.taskComplete")</label>

                                                    <div class="col-sm-4">
                                                        <div class="switchery-demo">
                                                            <input type="checkbox"
                                                                   @if($emailSettings[9]->send_email == 'yes') checked
                                                                   @endif class="js-switch change-email-setting"
                                                                   data-color="#99d683"
                                                                   data-setting-id="{{ $emailSettings[9]->id }}"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                        <label class="control-label col-sm-8">@lang("modules.emailSettings.invoiceNotification")</label>

                                                        <div class="col-sm-4">
                                                            <div class="switchery-demo">
                                                                <input type="checkbox"
                                                                       @if($emailSettings[10]->send_email == 'yes') checked
                                                                       @endif class="js-switch change-email-setting"
                                                                       data-color="#99d683"
                                                                       data-setting-id="{{ $emailSettings[10]->id }}"/>
                                                            </div>
                                                        </div>
                                                    </div>

                                            {!! Form::close() !!}
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
        <script src="{{ asset('plugins/bower_components/switchery/dist/switchery.min.js') }}"></script>
        <script>

            // Switchery
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function () {
                new Switchery($(this)[0], $(this).data());

            });

            $('.change-email-setting').change(function () {
                var id = $(this).data('setting-id');

                if ($(this).is(':checked'))
                    var sendEmail = 'yes';
                else
                    var sendEmail = 'no';

                var url = '{{route('admin.email-settings.update', ':id')}}';
                url = url.replace(':id', id);
                $.easyAjax({
                    url: url,
                    type: "POST",
                    data: {'id': id, 'send_email': sendEmail, '_method': 'PUT', '_token': '{{ csrf_token() }}'}
                })
            });

            $('#save-form').click(function () {

                var url = '{{route('admin.email-settings.updateMailConfig')}}';

                $.easyAjax({
                    url: url,
                    type: "POST",
                    container: '#updateSettings',
                    data: $('#updateSettings').serialize()
                })
            });

            $('#send-test-email').click(function () {

                var url = '{{route('admin.email-settings.sendTestEmail')}}';

                $.easyAjax({
                    url: url,
                    type: "GET",
                    success: function (response) {

                    }
                })
            });
        </script>
    @endpush