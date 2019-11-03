<?php

namespace App\Observers;

use App\Expense;

class ExpenseObserver
{

    public function saving(Expense $expense)
    {
        // Cannot put in creating, because saving is fired before creating. And we need company id for check bellow
        if (company()) {
            $expense->company_id = company()->id;
        }
    }

}
