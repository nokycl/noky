<?php

namespace App;

use App\Observers\TicketAgentGroupObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TicketAgentGroups extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::observe(TicketAgentGroupObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('ticket_agent_groups.company_id', '=', $company->id);
            }
        });
    }

    public function user(){
        return $this->belongsTo(User::class, 'agent_id')->withoutGlobalScopes(['active']);
    }

    public function group(){
        return $this->belongsTo(TicketGroup::class, 'group_id');
    }
}
