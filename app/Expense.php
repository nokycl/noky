<?php

namespace App;

use App\Observers\ExpenseObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $dates = ['purchase_date', 'purchase_on'];

    protected $appends = ['total_amount', 'purchase_on'];

    protected static function boot()
    {
        parent::boot();

        static::observe(ExpenseObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('expenses.company_id', '=', $company->id);
            }
        });
    }

    public function currency(){
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id')->withoutGlobalScopes(['active']);
    }


    public function getTotalAmountAttribute(){

        if(!is_null($this->price) && !is_null($this->currency_symbol)){
            return $this->currency->currency_symbol . $this->price;
        }

        return "";
    }

    public function getPurchaseOnAttribute(){
        if(!is_null($this->purchase_date)){
            return $this->purchase_date->format('d M, Y');
        }
        return "";
    }


}
