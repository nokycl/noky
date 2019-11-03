<?php

namespace App;

use App\Observers\AttendanceSettingObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AttendanceSetting extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::observe(AttendanceSettingObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('attendance_settings.company_id', '=', $company->id);
            }
        });
    }
}
