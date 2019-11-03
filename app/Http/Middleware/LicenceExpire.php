<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LicenceExpire
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $company = auth()->user()->company;
        if ($company->status == 'license_expired'){
            return Redirect::route('admin.dashboard');
        }
        return $next($request);
    }
}
