<?php

namespace App;

use App\Observers\TaskBoardColumnObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TaskboardColumn extends Model
{
    protected $fillable = ['column_name', 'slug', 'label_color', 'priority'];

    protected static function boot()
    {
        parent::boot();

        static::observe(TaskBoardColumnObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('taskboard_columns.company_id', '=', $company->id);
            }
        });
    }
    public function tasks(){
        return $this->hasMany(Task::class, 'board_column_id')->orderBy('column_priority');
    }

    public function membertasks(){
        return $this->hasMany(Task::class, 'board_column_id')->where('user_id', auth()->user()->id)->orderBy('column_priority');
    }
}
