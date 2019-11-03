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
                <li><a href="{{ route('admin.teams.index') }}">{{ __($pageTitle) }}</a></li>
                <li class="active">@lang('app.addNew')</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-6">
            <div class="white-box">
                <h3 class="box-title m-b-0">@lang('app.add') @lang('app.team')</h3>

                <p class="text-muted m-b-30 font-13"></p>

                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        {!! Form::open(['id'=>'createCurrency','class'=>'ajax-form','method'=>'POST']) !!}
                        <div class="form-group">
                            <label for="company_name">@lang('app.team')</label>
                            <input type="text" class="form-control" id="team_name" name="team_name">
                        </div>


                        <button type="submit" id="save-form" class="btn btn-success waves-effect waves-light m-r-10">
                            @lang('app.save')
                        </button>
                        <button type="reset" class="btn btn-inverse waves-effect waves-light">@lang('app.reset')</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .row -->

@endsection

@push('footer-script')
    <script>
        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route('admin.teams.store')}}',
                container: '#createCurrency',
                type: "POST",
                redirect: true,
                data: $('#createCurrency').serialize()
            })
        });
    </script>
@endpush

