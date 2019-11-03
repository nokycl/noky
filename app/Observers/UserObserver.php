<?php

namespace App\Observers;

use App\User;

class UserObserver
{

    public function saving(User $user)
    {
        // Cannot put in creating, because saving is fired before creating. And we need company id for check bellow
        if (request()->has('company_id')) {
            $user->company_id = request()->company_id;
        }
        elseif (company()) {
            $user->company_id = company()->id;
        }
    }

}
