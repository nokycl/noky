<?php

namespace App;

use App\Observers\CurrencyObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::observe(CurrencyObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('currencies.company_id', '=', $company->id);
            }
        });
    }
}
