<?php

namespace App\Http\Controllers;

use App\Setting;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->checkMigrateStatus();
        $this->global = Setting::first();
        App::setLocale('en');
        Carbon::setLocale('en');
        setlocale(LC_TIME, 'en' . '_' . strtoupper('en'));

        $this->middleware(function ($request, $next) {
            $user = auth()->user();
            if ($user && $user->super_admin == 1) {
                config(['froiden_envato.allow_users_id' => true]);
            }
            return $next($request);
        });

    }

    public function checkMigrateStatus()
    {
        $status = Artisan::call('migrate:check');
        if ($status) {
            Artisan::call('migrate', array('--force' => true)); //migrate database
        }
    }
}
