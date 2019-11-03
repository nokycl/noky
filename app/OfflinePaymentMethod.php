<?php

namespace App;

use App\Observers\OfflinePaymentMethodObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OfflinePaymentMethod extends Model
{
    protected $table = 'offline_payment_methods';
    protected $dates = ['created_at'];

    protected static function boot()
    {
        parent::boot();

        static::observe(OfflinePaymentMethodObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('offline_payment_methods.company_id', '=', $company->id);
            }
        });
    }

    public static function activeMethod(){
       return OfflinePaymentMethod::where('status', 'yes')->get();
    }
}
