<?php

namespace App;

use App\Observers\TicketReplyTemplateObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TicketReplyTemplate extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::observe(TicketReplyTemplateObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('ticket_reply_templates.company_id', '=', $company->id);
            }
        });
    }
}
