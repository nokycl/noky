<ul class="nav tabs-vertical">
    <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.settings.index') active @endif">
        <a href="{{ route('admin.settings.index') }}">@lang('app.menu.accountSettings')</a></li>
    <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.profile-settings.index') active @endif">
        <a href="{{ route('admin.profile-settings.index') }}">@lang('app.menu.profileSettings')</a></li>
    <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.email-settings.index') active @endif">
        <a href="{{ route('admin.email-settings.index') }}">@lang('app.menu.notificationSettings')</a></li>
    <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.currency.index') active @endif">
        <a href="{{ route('admin.currency.index') }}">@lang('app.menu.currencySettings')</a></li>
    <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.theme-settings.index') active @endif">
        <a href="{{ route('admin.theme-settings.index') }}">@lang('app.menu.themeSettings')</a></li>
    <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.payment-gateway-credential.index') active @endif">
        <a href="{{ route('admin.payment-gateway-credential.index') }}">@lang('app.menu.paymentGatewayCredential')</a>
    </li>
    <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.invoice-settings.index') active @endif">
        <a href="{{ route('admin.invoice-settings.index') }}">@lang('app.menu.financeSettings')</a></li>
    <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.ticket-agents.index') active @endif">
        <a href="{{ route('admin.ticket-agents.index') }}">@lang('app.menu.ticketSettings')</a></li>
    @if(in_array('attendance',$user->modules))
        <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.attendance-settings.index') active @endif">
            <a href="{{ route('admin.attendance-settings.index') }}">@lang('app.menu.attendanceSettings')</a></li>
    @endif
    @if(in_array('leaves',$user->modules))
        <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.leaves-settings.index') active @endif">
            <a href="{{ route('admin.leaves-settings.index') }}">@lang('app.menu.leaveSettings')</a></li>
    @endif
    <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.custom-fields.index') active @endif">
        <a href="{{ route('admin.custom-fields.index') }}">@lang('app.menu.customFields')</a></li>

        <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.module-settings.index') active @endif">
            <a href="{{ route('admin.module-settings.index') }}">@lang('app.menu.moduleSettings')</a></li>

    <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.role-permission.index') active @endif">
        <a href="{{ route('admin.role-permission.index') }}">@lang('app.menu.rolesPermission')</a></li>

    @if(in_array('messages',$user->modules))
        <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.message-settings.index') active @endif">
            <a href="{{ route('admin.message-settings.index') }}">@lang('app.menu.messageSettings')</a></li>
    @endif
        <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.storage-settings.index') active @endif">
            <a href="{{ route('admin.storage-settings.index') }}">@lang('app.menu.storageSettings')</a></li>
    @if(in_array('leads',$user->modules))
        <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.lead-source-settings.index') active @endif">
            <a href="{{ route('admin.lead-source-settings.index') }}">@lang('app.lead') @lang('app.menu.settings')</a></li>
    @endif
    @if(in_array('timelogs',$user->modules))
        <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.log-time-settings.index') active @endif">
            <a href="{{ route('admin.log-time-settings.index') }}">@lang('app.timeLog') @lang('app.menu.settings')</a></li>
    @endif

    <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.task-settings.index') active @endif">
        <a href="{{ route('admin.task-settings.index') }}">@lang('app.task') @lang('app.menu.settings')</a></li>
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