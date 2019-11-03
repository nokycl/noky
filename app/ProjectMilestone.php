<?php

namespace App;

use App\Observers\ProjectMilsetoneObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ProjectMilestone extends Model
{

    protected static function boot()
    {
        parent::boot();

        static::observe(ProjectMilsetoneObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use ($company) {
            if ($company) {
                $builder->where('project_milestones.company_id', '=', $company->id);
            }
        });
    }


    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'milestone_id');
    }
}
