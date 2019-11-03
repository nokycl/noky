<?php

namespace App\Observers;

use App\Ticket;

class TicketObserver
{

    public function saving(Ticket $ticket)
    {
        // Cannot put in creating, because saving is fired before creating. And we need company id for check bellow
        if (company()) {
            $ticket->company_id = company()->id;
        }
    }

}
