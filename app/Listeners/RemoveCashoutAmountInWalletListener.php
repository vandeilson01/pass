<?php

namespace App\Listeners;

class RemoveCashoutAmountInWalletListener
{
    public function __construct()
    {
    }

    public function handle($event): void
    {
        $wallet = $event->cashout->wallet;

        $wallet->balance -= $event->cashout->amount;
        $wallet->save();
    }
}
