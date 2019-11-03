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
<link rel="stylesheet" href="{{ asset('plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/jquery-asColorPicker-master/css/asColorPicker.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">{{ __($pageTitle) }}</div>

                <div class="vtabs customvtab m-t-10">
                    @include('sections.admin_setting_menu')

                    <div class="tab-content">
                        <div id="vhome3" class="tab-pane active">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="white-box">

                                        <div class="alert alert-info ">
                                            <i class="fa fa-info-circle"></i> @lang('messages.taskSettingNote')
                                        </div>
                                        {!! Form::open(['id'=>'editSettings','class'=>'ajax-form','method'=>'POST']) !!}

                                        <div class="form-group">
                                            <div class="checkbox checkbox-info  col-md-10">
                                                <input id="self_task" name="self_task" value="yes"
                                                       @if($global->task_self == "yes") checked
                                                       @endif
                                                       type="checkbox">
                                                <label for="self_task">@lang('messages.employeeSelfTask')</label>
                                            </div>
                                        </div>

                                        {{--<div class="row">--}}
                                            {{--<div class="col-md-12 m-t-30">--}}
                                                {{--<button class="btn btn-success" id="save-form" type="button"><i class="fa fa-check"></i> @lang('app.save')</button>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {!! Form::close() !!}

                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->

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

<script>
    // change task Setting For Setting
    $('input[name=self_task]').click(function () {
        var self_task = $('input[name=self_task]:checked').val();

        $.easyAjax({
            url: '{{route('admin.task-settings.store')}}',
            type: "POST",
            data: {'_token': '{{ csrf_token() }}', 'self_task': self_task}
        })
    });

</script>
@endpush

