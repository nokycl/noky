<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GlobalSetting extends Model
{
    protected $table = 'global_settings';

    public function logo() {
        if($this->logo == null) {
            return asset('logo-1.png');
        }

        return asset('user-uploads/app-logo/'.$this->logo);
    }

    public function currency()
    {
        return $this->belongsTo(GlobalCurrency::class, 'currency_id');
    }
}
