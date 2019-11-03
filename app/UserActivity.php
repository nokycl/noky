<?php

namespace App;

use App\Observers\UserActivityObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::observe(UserActivityObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('user_activities.company_id', '=', $company->id);
            }
        });
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id')->withoutGlobalScopes(['active']);
    }
}
