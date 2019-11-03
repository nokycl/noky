<?php

namespace App;

use App\Observers\TicketTypeObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::observe(TicketTypeObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('ticket_types.company_id', '=', $company->id);
            }
        });
    }
}
