<?php

namespace App;

use App\Observers\TicketChannelObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TicketChannel extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::observe(TicketChannelObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('ticket_channels.company_id', '=', $company->id);
            }
        });
    }
}
