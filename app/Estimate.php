<?php

namespace App;

use App\Observers\EstimateObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Estimate extends Model
{
    use Notifiable;

    protected $dates = ['valid_till'];
    protected $appends = ['total_amount', 'valid_date', 'estimate_number', 'original_estimate_number'];

    protected static function boot()
    {
        parent::boot();

        static::observe(EstimateObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use ($company) {
            if ($company) {
                $builder->where('estimates.company_id', '=', $company->id);
            }
        });
    }

    public function items()
    {
        return $this->hasMany(EstimateItem::class, 'estimate_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id')->withoutGlobalScopes(['active']);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function getTotalAmountAttribute()
    {

        if (!is_null($this->total) && !is_null($this->currency_symbol)) {
            return $this->currency_symbol . $this->total;
        }

        return "";
    }

    public function getValidDateAttribute()
    {
        if (!is_null($this->valid_till)) {
            return Carbon::parse($this->valid_till)->format('d F, Y');
        }
        return "";
    }

    public function getOriginalEstimateNumberAttribute()
    {
        $invoiceSettings = InvoiceSetting::select('estimate_digit')->first();
        $zero = '';
        if (strlen($this->estimate_number) < $invoiceSettings->estimate_digit) {
            for ($i = 0; $i < $invoiceSettings->estimate_digit - strlen($this->estimate_number); $i++) {
                $zero = '0' . $zero;
            }
        }
        $zero = $zero . $this->estimate_number;
        return $zero;
    }

    public function getEstimateNumberAttribute($value)
    {
        if (!is_null($value)) {
            $invoiceSettings = InvoiceSetting::select('estimate_prefix', 'estimate_digit')->first();
            $zero = '';
            if (strlen($value) < $invoiceSettings->estimate_digit) {
                for ($i = 0; $i < $invoiceSettings->estimate_digit - strlen($value); $i++) {
                    $zero = '0' . $zero;
                }
            }
            $zero = $invoiceSettings->estimate_prefix . '#' . $zero . $value;
            return $zero;
        }
        return "";
    }
}
