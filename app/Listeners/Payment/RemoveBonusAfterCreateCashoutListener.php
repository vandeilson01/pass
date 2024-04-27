<?php

namespace App\Listeners\Payment;

class RemoveBonusAfterCreateCashoutListener
{
    public function __construct()
    {
    }

    public function handle($event): void
    {
        $cashout = $event->cashout;

        $wallet = $cashout->user->wallet;

        if($wallet->type == 'main'){
            $cashout->user->bonus()->update(['status' => false]);
        }
    }
}
