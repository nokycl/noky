<?php

namespace App;

use App\Observers\LeaveObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Leave extends Model
{
    protected $dates = ['leave_date'];
    protected $appends = ['date'];

    protected static function boot()
    {
        parent::boot();

        static::observe(LeaveObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('leaves.company_id', '=', $company->id);
            }
        });
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id')->withoutGlobalScopes(['active']);
    }

    public function type(){
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }
    public function getDateAttribute()
    {
        return $this->leave_date->toDateString();
    }

    public static function byUser($userId){

        $user = User::withoutGlobalScope('active')->findOrFail($userId);
        $setting = Company::find($user->company_id);

        if($setting->leaves_start_from == 'joining_date' && isset($user->employee[0])) {
            return Leave::where('user_id', $userId)
                ->where('leave_date','<=', $user->employee[0]->joining_date->format((Carbon::now()->year+1).'-m-d'))
                ->where('status', 'approved')
                ->get();

        } else{
            return Leave::where('user_id', $userId)
                ->where('leave_date','<=', Carbon::today()->endOfYear()->format('Y-m-d'))
                ->where('status', 'approved')
                ->get();
        }
    }
}
