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
                <div class="panel-heading">@lang('modules.slackSettings.updateTitle')</div>

                <div class="vtabs customvtab m-t-10">

                    @include('sections.notification_settings_menu')

                    <div class="tab-content">
                        <div id="vhome3" class="tab-pane active">
                            <div class="row">
                                <div class="col-md-6">

                                    <h3 class="box-title m-b-0">@lang("modules.slackSettings.notificationTitle")</h3>

                                    <p class="text-muted m-b-10 font-13">
                                        @lang("modules.slackSettings.notificationSubtitle")
                                    </p>

                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12 b-t p-t-20">
                                            {!! Form::open(['id'=>'editSettings','class'=>'ajax-form form-horizontal','method'=>'PUT']) !!}

                                            <div class="form-group">
                                                <label class="control-label col-sm-8">@lang("modules.emailSettings.userRegistration")</label>

                                                <div class="col-sm-4">
                                                    <div class="switchery-demo">
                                                        <input type="checkbox"
                                                               @if($emailSettings[4]->send_slack == 'yes') checked
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
                                                               @if($emailSettings[5]->send_slack == 'yes') checked
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
                                                               @if($emailSettings[6]->send_slack == 'yes') checked
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
                                                               @if($emailSettings[7]->send_slack == 'yes') checked
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
                                                               @if($emailSettings[0]->send_slack == 'yes') checked
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
                                                               @if($emailSettings[1]->send_slack == 'yes') checked
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
                                                               @if($emailSettings[2]->send_slack == 'yes') checked
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
                                                               @if($emailSettings[3]->send_slack == 'yes') checked
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
                                                               @if($emailSettings[8]->send_slack == 'yes') checked
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
                                                               @if($emailSettings[9]->send_slack == 'yes') checked
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
                                                               @if($emailSettings[10]->send_slack == 'yes') checked
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

                                <div class="col-md-6">
                                    {!! Form::open(['id'=>'editSlackSettings','class'=>'ajax-form','method'=>'PUT']) !!}

                                    <div class="form-body">
                                        <div class="form-group">
                                            <label for="company_name">@lang('modules.slackSettings.slackWebhook')</label>
                                            <input type="text" class="form-control" id="slack_webhook"
                                                   name="slack_webhook" value="{{ $slackSettings->slack_webhook }}">
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleInputPassword1" class="d-block">@lang('modules.slackSettings.slackNotificationLogo')</label>

                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail"
                                                     style="width: 200px; height: 150px;">
                                                    @if(is_null($slackSettings->slack_logo))
                                                        <img src="https://placeholdit.imgix.net/~text?txtsize=25&txt=@lang('modules.slackSettings.uploadSlackLogo')&w=200&h=150"
                                                             alt=""/>
                                                    @else
                                                        <img src="{{ asset('user-uploads/slack-logo/'.$slackSettings->slack_logo) }}"
                                                             alt=""/>
                                                    @endif
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail"
                                                     style="max-width: 200px; max-height: 150px;"></div>
                                                <div>
                                                        <span class="btn btn-info btn-file">
                                                            <span class="fileinput-new"> @lang('app.selectImage') </span>
                                                            <span class="fileinput-exists"> @lang('app.change') </span>
                                                            <input type="file" name="slack_logo" id="slack_logo">
                                                        </span>
                                                    <a href="javascript:;" class="btn btn-danger fileinput-exists"
                                                       data-dismiss="fileinput"> @lang('app.remove') </a>
                                                </div>
                                            </div>

                                            @if(!is_null($slackSettings->slack_logo))
                                            <div class="form-group">
                                                <label for="removeImage">@lang("modules.emailSettings.removeImage")</label>
                                                <div class="switchery-demo">
                                                    <input type="checkbox" name="removeImage" id="removeImageButton" class="js-switch removeImage"
                                                           data-color="#99d683" />
                                                </div>
                                            </div>
                                            @endif
                                            <div class="clearfix"></div>
                                        </div>

                                    </div>


                                    <div class="form-actions m-t-20">
                                        <button type="submit" id="save-form"
                                                class="btn btn-success waves-effect waves-light m-r-10">
                                            @lang('app.update')
                                        </button>
                                        <button type="button" id="send-test-notification"
                                                class="btn btn-primary waves-effect waves-light">@lang('modules.slackSettings.sendTestNotification')</button>
                                        <button type="reset"
                                                class="btn btn-inverse waves-effect waves-light">@lang('app.reset')</button>
                                    </div>

                                    {!! Form::close() !!}
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

    $('#save-form').click(function () {
        $.easyAjax({
            url: '{{route('admin.slack-settings.update', ['1'])}}',
            container: '#editSlackSettings',
            type: "POST",
            redirect: true,
            file: true
        })
    });
    $('#removeImageButton').change(function () {
        var removeButton;
        if ($(this).is(':checked'))
             removeButton = 'yes';
        else
             removeButton = 'no';

        var img;
        if(removeButton == 'yes'){
            img = '<img src="https://placeholdit.imgix.net/~text?txtsize=25&txt=@lang('modules.slackSettings.uploadSlackLogo')&w=200&h=150" alt=""/>';
        }
        else{
            img = '<img src="{{ asset('user-uploads/slack-logo/'.$slackSettings->slack_logo) }}" alt=""/>'
        }
        $('.thumbnail').html(img);

    });
</script>
<script>

    // Switchery
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
    $('.js-switch').each(function () {
        new Switchery($(this)[0], $(this).data());

    });

    $('.change-email-setting').change(function () {
        var id = $(this).data('setting-id');

        if ($(this).is(':checked'))
            var sendSlack = 'yes';
        else
            var sendSlack = 'no';

        var url = '{{route('admin.slack-settings.updateSlackNotification', ':id')}}';
        url = url.replace(':id', id);
        $.easyAjax({
            url: url,
            type: "POST",
            data: {'id': id, 'send_slack': sendSlack, '_method': 'POST', '_token': '{{ csrf_token() }}'}
        })
    });

    $('#send-test-notification').click(function () {

        var url = '{{route('admin.slack-settings.sendTestNotification')}}';

        $.easyAjax({
            url: url,
            type: "GET",
            success: function (response) {

            }
        })
    });



</script>
@endpush

