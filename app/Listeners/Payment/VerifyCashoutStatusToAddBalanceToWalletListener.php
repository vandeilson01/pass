<?php

namespace App\Listeners\Payment;

use App\Enum\TransactionStatus;

class VerifyCashoutStatusToAddBalanceToWalletListener
{
    public function __construct()
    {
    }

    public function handle($event): void
    {
        $cashout = $event->cashout;

        if ($cashout->status == TransactionStatus::Refused->value) {
            $cashout->wallet->balance += $cashout->amount;
            $cashout->wallet->save();
        }
    }
}
