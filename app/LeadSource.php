<?php

namespace App;

use App\Observers\LeadSourceObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class LeadSource extends Model
{
    protected $table = 'lead_sources';

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::observe(LeadSourceObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('lead_sources.company_id', '=', $company->id);
            }
        });
    }
}
