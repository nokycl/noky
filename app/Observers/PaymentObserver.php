<?php

namespace App\Observers;

use App\Estimate;
use App\Payment;

class PaymentObserver
{

    public function saving(Payment $payment)
    {
        // Cannot put in creating, because saving is fired before creating. And we need company id for check bellow
        if (company()) {
            $payment->company_id = company()->id;
        }
    }

}
