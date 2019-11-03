<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'companies';

    public function currency() {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}
