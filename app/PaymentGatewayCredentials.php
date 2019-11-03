<?php

namespace App;

use App\Observers\PaymentGatewayCredentialObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PaymentGatewayCredentials extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::observe(PaymentGatewayCredentialObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('payment_gateway_credentials.company_id', '=', $company->id);
            }
        });
    }
}
