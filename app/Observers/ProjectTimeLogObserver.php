<?php

namespace App\Observers;

use App\ProjectTimeLog;

class ProjectTimeLogObserver
{

    public function saving(ProjectTimeLog $log)
    {
        // Cannot put in creating, because saving is fired before creating. And we need company id for check bellow
        if (company()) {
            $log->company_id = company()->id;
        }
    }

}
