<?php

namespace App\Observers;

use App\Proposal;

class ProposalObserver
{

    public function saving(Proposal $proposal)
    {
        // Cannot put in creating, because saving is fired before creating. And we need company id for check bellow
        if (company()) {
            $proposal->company_id = company()->id;
        }
    }

}
