<?php

namespace App\Observers;

use App\Estimate;

class EstimateObserver
{

    public function saving(Estimate $estimate)
    {
        // Cannot put in creating, because saving is fired before creating. And we need company id for check bellow
        if (company()) {
            $estimate->company_id = company()->id;
        }
    }

}
