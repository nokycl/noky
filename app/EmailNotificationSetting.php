<?php

namespace App;

use App\Observers\EmailNotificationSettingObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EmailNotificationSetting extends Model
{
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::observe(EmailNotificationSettingObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('email_notification_settings.company_id', '=', $company->id);
            }
        });
    }
}
