<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketTag extends Model
{
    protected $guarded = ['id'];

    public function tag(){
        return $this->belongsTo(TicketTagList::class, 'tag_id');
    }
}
