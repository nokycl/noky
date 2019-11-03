<?php

namespace App;

use App\Observers\StorageSettingObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class StorageSetting extends Model
{
    protected $table = 'file_storage_settings';

    protected $fillable = ['filesystem','auth_keys','status'];

    protected static function boot()
    {
        parent::boot();

        static::observe(StorageSettingObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('file_storage_settings.company_id', '=', $company->id);
            }
        });
    }

}
