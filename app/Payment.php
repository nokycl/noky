<?php

namespace App;

use App\Observers\PaymentObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $dates = ['paid_on'];

    protected $appends = ['total_amount', 'paid_date'];

    protected static function boot()
    {
        parent::boot();

        static::observe(PaymentObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use ($company) {
            if ($company) {
                $builder->where('payments.company_id', '=', $company->id);
            }
        });
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function offlineMethod()
    {
        return $this->belongsTo(OfflinePaymentMethod::class, 'offline_method_id');
    }

    public function getTotalAmountAttribute()
    {

        if (!is_null($this->amount) && !is_null($this->currency_symbol) && !is_null($this->currency_code)) {
            return  $this->amount;
        }

        return "";
    }

    public function getPaidDateAttribute()
    {
        if (!is_null($this->paid_on)) {
            return Carbon::parse($this->paid_on)->format('d F, Y H:i A');
        }
        return "";
    }
}
