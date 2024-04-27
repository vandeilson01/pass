<?php

namespace App\Listeners\Payment;

use App\Listeners\Wallet;
use App\Models\Bonus;
use App\Models\Payment\Deposit;
use App\Models\User;
use Carbon\Carbon;

class AddDepositBalanceIfHasBonusToBonusesListener
{
    public function __construct()
    {

    }

    public function handle($event): void
    {
        $deposit = $event->deposit;

        if($deposit->has_bonus){
            Bonus::where('user_id', $deposit->user_id)->update(['status' => false]);

            User::find($deposit->user_id)
                ->bonuses()->create([
                    'hash' => $deposit->hash,
                    'status' => true,
                    'balance' => $deposit->amount,
                    'credit_hold' => $deposit->amount,
                    'expiration_at' => Carbon::now()->addDays(1),
                    'user_id' => $deposit->user_id,
                ])->rollover()->create([
                    'hash' => $deposit->hash,
                    'amount' => 0,
                    'count' => 0,
                    'multiplier' => 50,
                    'rollover_count' => 250,
                ]);
        }
    }
}
