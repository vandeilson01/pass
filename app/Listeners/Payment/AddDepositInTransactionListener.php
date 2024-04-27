<?php

namespace App\Listeners\Payment;

use App\Models\Transaction;

class AddDepositInTransactionListener
{
    public function __construct()
    {
    }

    public function handle($event): void
    {
        $deposit = $event->deposit;

        $deposit->transaction()->create([
            'hash' => $deposit->hash,
            'name' => 'deposit',
            'status' => $deposit->status,
            'amount' => $deposit->amount,
            'type' => 'credit',
            'wallet_id' => $deposit->wallet_id,
            'user_id' => $deposit->user_id,
        ]);
    }
}
