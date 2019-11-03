<?php

namespace App;

use App\Observers\ProjectCategoryObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{
    protected $table = 'project_category';

    protected static function boot()
    {
        parent::boot();

        static::observe(ProjectCategoryObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('project_category.company_id', '=', $company->id);
            }
        });
    }
}
