@extends('layouts.auth')

@section('content')

    <form class="form-horizontal form-material" id="loginform" action="{{ route('login') }}" method="POST">
        {{ csrf_field() }}


        @if (session('message'))
            <div class="alert alert-danger m-t-10">
                {{ session('message') }}
            </div>
        @endif

        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            <div class="col-xs-12">
                <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" autofocus required="" placeholder="@lang('app.email')">
                @if ($errors->has('email'))
                    <div class="help-block with-errors">{{ $errors->first('email') }}</div>
                @endif

            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <input class="form-control" id="password" type="password" name="password" required="" placeholder="@lang('modules.client.password')">
                @if ($errors->has('password'))
                    <div class="help-block with-errors">{{ $errors->first('password') }}</div>
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <div class="checkbox checkbox-primary pull-left p-t-0">
                    <input id="checkbox-signup" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="checkbox-signup"> @lang('app.rememberMe') </label>
                </div>
                <a href="{{ route('password.request') }}"  class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> @lang('app.forgotPassword')?</a> </div>
        </div>
        <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
                <button class="btn btn-info btn-lg btn-block btn-rounded text-uppercase waves-effect waves-light" type="submit">@lang('app.login')</button>
            </div>
        </div>

        {{--<div class="form-group m-b-0">--}}
            {{--<div class="col-sm-12 text-center">--}}
                {{--<p>Don't have an account? <a href="{{ route('register') }}" class="text-primary m-l-5"><b>Sign Up</b></a></p>--}}
            {{--</div>--}}
        {{--</div>--}}
    </form>
@endsection
