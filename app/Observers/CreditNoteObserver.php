<?php

namespace App\Observers;


use App\CreditNotes;

class CreditNoteObserver
{

    public function saving(CreditNotes $invoice)
    {
        // Cannot put in creating, because saving is fired before creating. And we need company id for check bellow
        if (company()) {
            $invoice->company_id = company()->id;
        }
    }

}
