<?php

namespace App;

use App\Observers\TaskCategoryObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TaskCategory extends Model
{
    protected $table = 'task_category';

    protected static function boot()
    {
        parent::boot();

        static::observe(TaskCategoryObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('task_category.company_id', '=', $company->id);
            }
        });
    }
}
