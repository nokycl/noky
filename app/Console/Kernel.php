<?php

namespace App\Console;

use App\Console\Commands\VendorCleanUpCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\UpdateExchangeRates::class,
        Commands\AutoStopTimer::class,
        Commands\LicenceExpire::class,
        Commands\checkPaypalPlan::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('update-exchange-rate')->daily();
        $schedule->command('auto-stop-timer')->daily();
        $schedule->command('licence-expire')->daily();
        $schedule->command('check-paypal-plan')->everyThirtyMinutes();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
    
}
