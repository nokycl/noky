<?php

namespace App;

use App\Observers\MessageSettingObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class MessageSetting extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::observe(MessageSettingObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('message_settings.company_id', '=', $company->id);
            }
        });
    }
}
