<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $table = 'proposals';
//    use Notifiable;

    protected $dates = ['valid_till'];

    public function items() {
        return $this->hasMany(ProposalItem::class);
    }

    public function currency(){
        return $this->belongsTo(Currency::class, 'currency_id');
    }
    public function lead(){
        return $this->belongsTo(Lead::class);
    }

}
