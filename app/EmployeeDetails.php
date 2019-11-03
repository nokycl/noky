<?php

namespace App;

use App\Observers\EmployeeDetailObserver;
use App\Traits\CustomFieldsTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EmployeeDetails extends Model
{
    use CustomFieldsTrait;

    protected $table = 'employee_details';

    protected $dates = ['joining_date', 'last_date'];

    protected static function boot()
    {
        parent::boot();

        static::observe(EmployeeDetailObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('employee_details.company_id', '=', $company->id);
            }
        });
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id')->withoutGlobalScopes(['active']);
    }
}
