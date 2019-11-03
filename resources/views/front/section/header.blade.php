<header class="header h-fullscreen" style="background-image: linear-gradient(150deg, #fdfbfb 0%, #eee 100%);">
    <div class="container-wide">

        <div class="row h-full align-items-center text-center text-lg-left">

            <div class="offset-1 col-10 col-lg-4 offset-lg-1">
                <h1>{{ $detail->header_title }}</h1>
                <br>
                <p class="lead mx-auto">{{ $detail->header_description }}</p>
                <br>
                @if($detail->get_started_show == 'yes')
                    <a class="btn btn-lg btn-success" href="{{ route('front.signup.index') }}">@lang('modules.frontCms.getStarted')</a>
                @endif
                @if($detail->sign_in_show == 'yes')
                    <a class="btn btn-lg btn-info" href="{{ route('login') }}">@lang('app.login')</a>
                @endif
            </div>

            <div class="col-12 col-lg-6 offset-lg-1 img-outside-right hidden-md-down">
                <img class="shadow-4 mt-80" src="@if($detail->image) {{ asset('front-uploads/'.$detail->image) }} @else {{ asset('front/img-1.png') }} @endif" alt="...">
            </div>
        </div>

    </div>
</header>