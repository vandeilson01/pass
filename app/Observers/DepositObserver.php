<?php

namespace App\Observers;

use App\Events\CreateDepositEvent;
use App\Events\UpdateDepositEvent;
use App\Models\Payment\Deposit;

class DepositObserver
{
    public function created(Deposit $deposit): void
    {
        CreateDepositEvent::dispatch($deposit);
    }

    public function updated(Deposit $deposit): void
    {
        UpdateDepositEvent::dispatch($deposit);
    }
}
