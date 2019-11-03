<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Entrust;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class UserChat extends Authenticatable
{

    protected $table = 'users_chat';

    public $timestamps = true;

    protected $guarded = ["id"];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $dates = ['created_at', 'updated_at'];

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from')->withoutGlobalScopes(['active']);
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to')->withoutGlobalScopes(['active']);
    }

    public static function chatDetail($id,$userID)
    {
        return UserChat::where(function($q) use ($id,$userID) {
            $q->Where('user_id', $id)->Where('user_one', $userID)
                ->orwhere(function($q) use ($id,$userID) {
                    $q->Where('user_one', $id)
                        ->Where('user_id', $userID);
                });
        })

            ->orderBy('created_at', 'asc')->get();
    }

    public static function messageSeenUpdate($loginUser,$toUser,$updateData)
    {
        return UserChat::where('from', $toUser)->where('to', $loginUser)->update($updateData);
    }

}
