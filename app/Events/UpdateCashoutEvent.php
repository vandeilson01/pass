<?php

namespace App\Events;

use App\Models\Payment\Cashout;
use Illuminate\Foundation\Events\Dispatchable;

class UpdateCashoutEvent
{
    use Dispatchable;

    public function __construct(
        public Cashout $cashout
    )
    {
    }
}
