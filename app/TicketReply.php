<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketReply extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id')->withoutGlobalScopes(['active']);
    }
}
