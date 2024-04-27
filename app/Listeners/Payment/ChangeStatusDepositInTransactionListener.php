<?php

namespace App\Listeners\Payment;

class ChangeStatusDepositInTransactionListener
{
    public function __construct()
    {
    }

    public function handle($event): void
    {
        $deposit = $event->deposit;

        $deposit->transaction()->update([
            'status' => $deposit->status
        ]);
    }
}
