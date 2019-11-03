<?php

namespace App;

use App\Observers\ThemeSettingObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ThemeSetting extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::observe(ThemeSettingObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('theme_settings.company_id', '=', $company->id);
            }
        });
    }
}
