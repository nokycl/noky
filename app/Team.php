<?php

namespace App;

use App\Observers\TeamObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::observe(TeamObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('teams.company_id', '=', $company->id);
            }
        });
    }

    public function members()
    {
        return $this->hasMany(EmployeeTeam::class, 'team_id');
    }
}
