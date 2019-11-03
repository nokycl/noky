<ul class="nav tabs-vertical">
    <li class="tab">
        <a href="<?php echo e(route('super-admin.settings.index')); ?>" class="text-danger"><i class="ti-arrow-left"></i> <?php echo app('translator')->getFromJson('app.menu.settings'); ?></a></li>
    <li class="tab <?php if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.package-settings.index'): ?> active <?php endif; ?>">
        <a href="<?php echo e(route('super-admin.package-settings.index')); ?>"><?php echo app('translator')->getFromJson('app.freeTrial'); ?> <?php echo app('translator')->getFromJson('app.menu.settings'); ?></a></li>

</ul>

<script src="<?php echo e(asset('plugins/bower_components/jquery/dist/jquery.min.js')); ?>"></script>
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
</script><?php /**PATH /var/www/html/resources/views/sections/package_setting_menu.blade.php ENDPATH**/ ?>