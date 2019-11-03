<?php

namespace App;

use App\Observers\SlackSettingObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SlackSetting extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::observe(SlackSettingObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('slack_settings.company_id', '=', $company->id);
            }
        });
    }
}
