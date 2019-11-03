<?php

namespace App;

use App\Observers\ProductObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = ['name', 'price', 'tax_id'];
    protected $appends = ['total_amount'];

    protected static function boot()
    {
        parent::boot();

        static::observe(ProductObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('products.company_id', '=', $company->id);
            }
        });
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function getTotalAmountAttribute(){

        if(!is_null($this->price) && !is_null($this->tax)){
            return $this->price + ($this->price * ($this->tax->rate_percent/100));
        }

        return "";
    }
}
