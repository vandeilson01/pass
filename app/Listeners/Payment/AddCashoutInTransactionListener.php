<?php

namespace App\Listeners\Payment;

class AddCashoutInTransactionListener
{
    public function __construct()
    {
    }

    public function handle($event): void
    {
        $cashout = $event->cashout;

        $cashout->transaction()->create([
            'hash' => $cashout->hash,
            'name' => 'cashout',
            'status' => $cashout->status,
            'amount' => -$cashout->amount,
            'type' => 'debit',
            'wallet_id' => $cashout->wallet_id,
            'user_id' => $cashout->user_id,
        ]);
    }
}
