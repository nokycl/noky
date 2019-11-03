<?php

namespace App\Observers;

use App\LeaveType;

class LeaveTypeObserver
{
    /**
     * Handle the leave type "saving" event.
     *
     * @param  \App\LeaveType  $leaveType
     * @return void
     */
    public function saving(LeaveType $leaveType)
    {
        // Cannot put in creating, because saving is fired before creating. And we need company id for check bellow
        if (company()) {
            $leaveType->company_id = company()->id;
        }
    }

}
