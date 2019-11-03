<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItems extends Model
{
    protected $guarded = ['id'];

    public function tax(){
        return $this->belongsTo(Tax::class, 'tax_id');
    }
}
