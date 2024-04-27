<?php

namespace App\Observers;

use App\Events\CreateCashoutEvent;
use App\Events\UpdateCashoutEvent;
use App\Models\Payment\Cashout;

class CashoutObserver
{
    public function created(Cashout $cashout): void
    {
        CreateCashoutEvent::dispatch($cashout);
    }

    public function updated(Cashout $cashout): void
    {
        UpdateCashoutEvent::dispatch($cashout);
    }
}
