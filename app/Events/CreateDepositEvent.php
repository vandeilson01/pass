<?php

namespace App\Events;

use App\Models\Payment\Deposit;
use Illuminate\Foundation\Events\Dispatchable;

class CreateDepositEvent
{
    use Dispatchable;

    public function __construct(
        public Deposit $deposit
    )
    {
    }
}
