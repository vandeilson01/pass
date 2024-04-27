<?php

namespace App\Listeners\Payment;

class ChangeStatusCashoutInTransactionListener
{
    public function __construct()
    {
    }

    public function handle($event): void
    {
        $cashout = $event->cashout;

        $cashout->transaction()->update([
            'status' => $cashout->status
        ]);
    }
}
