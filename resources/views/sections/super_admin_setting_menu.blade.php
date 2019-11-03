<ul class="nav tabs-vertical">
    <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'super-admin.settings.index') active @endif">
        <a href="{{ route('super-admin.settings.index') }}">@lang('app.global') @lang('app.menu.settings')</a></li>
    <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'super-admin.email-settings.index') active @endif">
        <a href="{{ route('super-admin.email-settings.index') }}">@lang('app.email') @lang('app.menu.settings')</a></li>
    <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'super-admin.push-notification-settings.index') active @endif">
        <a href="{{ route('super-admin.push-notification-settings.index') }}">@lang('app.menu.pushNotifications') @lang('app.menu.settings')</a>
    </li>
    <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'super-admin.language-settings.index') active @endif">
        <a href="{{ route('super-admin.language-settings.index') }}">@lang('app.language') @lang('app.menu.settings')</a>
    </li>
    <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'super-admin.currency.index') active @endif">
        <a href="{{ route('super-admin.currency.index') }}">@lang('app.menu.currencySettings')</a></li>
    </li> <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'super-admin.stripe-settings.index') active @endif">
        <a href="{{ route('super-admin.stripe-settings.index') }}">@lang('app.menu.paymentGatewayCredential')</a></li>
    <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'super-admin.front-settings.index') active @endif">
        <a href="{{ route('super-admin.front-settings.index') }}">@lang('app.front') @lang('app.menu.settings')</a></li>

    <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'super-admin.package-settings.index') active @endif">
        <a href="{{ route('super-admin.package-settings.index') }}">@lang('app.freeTrial') @lang('app.menu.settings')</a></li>
    <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'super-admin.update-settings.index') active @endif">
        <a href="{{ route('super-admin.update-settings.index') }}">@lang('app.menu.updates')</a>
    </li>
</ul>

<script src="{{ asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script>
    var screenWidth = $(window).width();
    if(screenWidth <= 768){

        $('.tabs-vertical').each(function() {
            var list = $(this), select = $(document.createElement('select')).insertBefore($(this).hide()).addClass('settings_dropdown form-control');

            $('>li a', this).each(function() {
                var target = $(this).attr('target'),
                    option = $(document.createElement('option'))
                        .appendTo(select)
                        .val(this.href)
                        .html($(this).html())
                        .click(function(){
                            if(target==='_blank') {
                                window.open($(this).val());
                            }
                            else {
                                window.location.href = $(this).val();
                            }
                        });

                if(window.location.href == option.val()){
                    option.attr('selected', 'selected');
                }
            });
            list.remove();
        });

        $('.settings_dropdown').change(function () {
            window.location.href = $(this).val();
        })

    }

</script>