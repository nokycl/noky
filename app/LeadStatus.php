<?php

namespace App;

use App\Observers\LeadStatusObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class LeadStatus extends Model
{
    protected $table = 'lead_status';

    protected static function boot()
    {
        parent::boot();

        static::observe(LeadStatusObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('lead_status.company_id', '=', $company->id);
            }
        });
    }
}
