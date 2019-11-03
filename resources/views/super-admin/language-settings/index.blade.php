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
                <div class="panel-heading">@lang('app.language') @lang('app.menu.settings')</div>

                <div class="vtabs customvtab m-t-10">
                    @include('sections.super_admin_setting_menu')

                    <div class="tab-content">
                        <div id="vhome3" class="tab-pane active">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <a href="{{ url('/translations') }}" target="_blank" class="btn btn-sm m-b-30 btn-warning"><i class="ti-settings"></i> Translate</a>

                                    {!! Form::open(['id'=>'updateProfile','class'=>'ajax-form','method'=>'PUT']) !!}
                                    <div class="form-body">
                                        <div class="row">

                                            @foreach($languages as $language)
                                                <div class="col-sm-6 col-md-4 m-t-10">
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-8">{{ $language->language_name }}</label>

                                                        <div class="col-sm-4">
                                                            <div class="switchery-demo">
                                                                <input type="checkbox"
                                                                       @if($language->status == 'enabled') checked
                                                                       @endif class="js-switch change-language-setting"
                                                                       data-color="#99d683"
                                                                       data-setting-id="{{ $language->id }}"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            @endforeach

                                        </div>
                                        <!--/row-->
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>

                </div>
            </div>    <!-- .row -->
        </div>
    </div>

@endsection

@push('footer-script')
    <script src="{{ asset('plugins/bower_components/switchery/dist/switchery.min.js') }}"></script>
    <script>
        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function () {
            new Switchery($(this)[0], $(this).data());

        });

        $('.change-language-setting').change(function () {
            var id = $(this).data('setting-id');

            if ($(this).is(':checked'))
                var status = 'enabled';
            else
                var status = 'disabled';

            var url = '{{route('super-admin.language-settings.update', ':id')}}';
            url = url.replace(':id', id);
            $.easyAjax({
                url: url,
                type: "POST",
                data: {'id': id, 'status': status, '_method': 'PUT', '_token': '{{ csrf_token() }}'}
            })
        });
    </script>
@endpush