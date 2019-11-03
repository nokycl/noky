<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ModuleSetting extends Model
{

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('module_settings.company_id', '=', $company->id);
            }
        });
    }

    public static function checkModule($moduleName) {
        $user = auth()->user();

        $module = ModuleSetting::where('module_name', $moduleName);

        if ($user->hasRole('admin')) {
            $module = $module->where('type', 'admin');

        } elseif ($user->hasRole('client')) {
            $module = $module->where('type', 'client');

        } elseif ($user->hasRole('employee')) {
            $module = $module->where('type', 'employee');
        }

        $module = $module->where('status', 'active');

        $module = $module->first();
        if($module){
            if($module->status == 'active'){
                return true;
            }
        }

        return false;
    }
}
