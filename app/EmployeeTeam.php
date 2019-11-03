<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeTeam extends Model
{
    public function user(){
        return $this->belongsTo(User::class, 'user_id')->withoutGlobalScopes(['active']);
    }
}
