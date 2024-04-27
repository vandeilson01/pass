<?php

namespace App\Listeners\Payment;

use App\Listeners\Wallet;
use App\Models\Payment\Deposit;

class AddDepositBalanceToWalletListener
{
    public function __construct()
    {

    }

    public function handle($event): void
    {
        $deposit = $event->deposit;
        $wallet = $event->wallet;

        $wallet->balance += $deposit->amount;
        $wallet->save();
    }
}
