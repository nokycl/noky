<?php

namespace App\Observers;

use App\Notice;

class NoticeObserver
{
    /**
     * Handle the notice "saving" event.
     *
     * @param  \App\Notice  $notice
     * @return void
     */
    public function saving(Notice $notice)
    {
        // Cannot put in creating, because saving is fired before creating. And we need company id for check bellow
        if (company()) {
            $notice->company_id = company()->id;
        }
    }
}
