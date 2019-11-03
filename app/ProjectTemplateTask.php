<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ProjectTemplateTask extends Model
{
    use Notifiable;

    public function routeNotificationForMail()
    {
        return $this->user->email;
    }

    public function projectTemplate(){
        return $this->belongsTo(ProjectTemplate::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id')->withoutGlobalScopes(['active']);
    }
}
