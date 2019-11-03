<?php

namespace App;

use App\Observers\TicketGroupObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TicketGroup extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::observe(TicketGroupObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('ticket_groups.company_id', '=', $company->id);
            }
        });
    }

    public function agents(){
        return $this->hasMany(TicketAgentGroups::class, 'group_id');
    }


    public function enabled_agents() {
        return $this->agents()->where('status','=', 'enabled');
    }
}
