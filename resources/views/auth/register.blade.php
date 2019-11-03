@extends('layouts.auth')

@section('content')
    <form class="form-horizontal form-material" id="loginform" action="{{ route('register') }}" method="POST">
        {{ csrf_field() }}

        <a href="javascript:void(0)" class="text-center db"><img src="../plugins/images/eliteadmin-logo-dark.png" alt="Home" /><br/><img src="../plugins/images/eliteadmin-text-dark.png" alt="Home" /></a>
        <h3 class="box-title m-t-40 m-b-0">Register Now</h3><small>Create your account and enjoy</small>
        <div class="form-group m-t-20 {{ $errors->has('name') ? ' has-error' : '' }}">
            <div class="col-xs-12">
                <input class="form-control" type="text" id="name" name="name" required="" value="{{ old('name') }}" autofocus placeholder="Name">

                @if ($errors->has('name'))
                    <span class="help-block">
                        {{ $errors->first('name') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
            <div class="col-xs-12">
                <input class="form-control" type="email" value="{{ old('email') }}" name="email" id="email" required="" placeholder="Email">

                @if ($errors->has('email'))
                    <span class="help-block">
                        {{ $errors->first('email') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
            <div class="col-xs-12">
                <input class="form-control" type="password" id="password" name="password" required="" placeholder="Password">

                @if ($errors->has('password'))
                    <span class="help-block">
                        {{ $errors->first('password') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <input class="form-control" id="password-confirm" name="password_confirmation" type="password" required="" placeholder="Confirm Password">
            </div>
        </div>
        <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Sign Up</button>
            </div>
        </div>
        <div class="form-group m-b-0">
            <div class="col-sm-12 text-center">
                <p>Already have an account? <a href="{{ route('login') }}" class="text-primary m-l-5"><b>Sign In</b></a></p>
            </div>
        </div>
    </form>
@endsection
