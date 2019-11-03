<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientPayment extends Model
{
    protected $table = 'payments';

    protected $dates = ['paid_on'];

    public function invoice() {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
