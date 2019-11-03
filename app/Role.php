<?php namespace App;

use App\Observers\RoleObserver;
use Illuminate\Database\Eloquent\Builder;
use Zizaco\Entrust\EntrustRole;
use Illuminate\Support\Facades\Auth;

class Role extends EntrustRole
{

    public static function boot()
    {
        parent::boot();

        $company = company();

        static::observe(RoleObserver::class);

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('roles.company_id', '=', $company->id);
            }
        });
    }

    public function permissions(){
       return $this->hasMany(PermissionRole::class, 'role_id');
    }

    public function roleuser(){
       return $this->hasMany(RoleUser::class, 'role_id');
    }
}