<?php

namespace App\Observers;

use App\LeadStatus;

class LeadStatusObserver
{

    public function saving(LeadStatus $status)
    {
        // Cannot put in creating, because saving is fired before creating. And we need company id for check bellow
        if (company()) {
            $status->company_id = company()->id;
        }
    }

}
