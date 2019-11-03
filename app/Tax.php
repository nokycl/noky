<?php

namespace App;

use App\Observers\TaxObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::observe(TaxObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('taxes.company_id', '=', $company->id);
            }
        });
    }
}
