<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (\config('app.redirect_https')) {
            \URL::forceScheme('https');
        }
        Schema::defaultStringLength(191);
        Cashier::useCurrency(strtolower(config('services.currency.name')), config('services.currency.symbol'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
