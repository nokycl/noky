<?php

namespace App\Observers;

use App\EmployeeDetails;

class EmployeeDetailObserver
{

    public function saving(EmployeeDetails $detail)
    {
        // Cannot put in creating, because saving is fired before creating. And we need company id for check bellow
        if (company()) {
            $detail->company_id = company()->id;
        }
    }

}
