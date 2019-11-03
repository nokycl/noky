<nav class="topbar topbar-expand-sm topbar-sticky">
    <div class="container-wide">
        <div class="row h-full">
            <div class="offset-1 col-10 col-md-4 offset-md-1 align-self-center">
                <button class="topbar-toggler">&#9776;</button>
                <a class="topbar-brand" href="{{ route('front.home') }}">
                    @if(is_null($setting->logo))
                        <img src="{{ asset('front/img/worksuite-logo.png') }}" alt="home" class="logo-default" />
                    @else
                        <img src="{{ asset('user-uploads/app-logo/'.$setting->logo) }}" class="logo-default" alt="home" />
                    @endif
                </a>
            </div>

            <div class="col-1 col-md-5 text-md-right">
                @php $routeName = request()->route()->getName(); @endphp
                <ul class="topbar-nav nav">
                    <li class="nav-item"><a class="nav-link" @if($routeName != 'front.home') href="{{route('front.home').'#home'}}" @else href="javascript:;" data-scrollto="home" @endif >@lang('app.menu.home') </a></li>
                    <li class="nav-item"><a class="nav-link" @if($routeName != 'front.home') href="{{route('front.home').'#section-features'}}" @else href="javascript:;" data-scrollto="section-features" @endif>@lang('app.menu.features')</a></li>
                    <li class="nav-item"><a class="nav-link" @if($routeName != 'front.home') href="{{route('front.home').'#section-pricing'}}" @else href="javascript:;" data-scrollto="section-pricing" @endif>@lang('app.menu.pricing')</a></li>
                    <li class="nav-item"><a class="nav-link" @if($routeName != 'front.home') href="{{route('front.home').'#section-contact'}}" @else href="javascript:;" data-scrollto="section-contact" @endif>@lang('app.menu.contact')</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>