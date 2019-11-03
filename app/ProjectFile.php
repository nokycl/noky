<?php

namespace App;

use App\Observers\ProjectFileObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProjectFile extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::observe(ProjectFileObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('project_files.company_id', '=', $company->id);
            }
        });
    }
}
