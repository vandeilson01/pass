<?php

namespace App\Listeners;

use App\Models\Bonus;
use App\Models\Transaction;
use App\Models\Wallet;

class CheckRolloverListener
{
    public function __construct()
    {
    }

    public function handle($event): void
    {
        $rollover = $event->rollover;
        $executeRollover = false;

        if($rollover->count >= $rollover->rollover_count){
            $executeRollover = true;
        }

        if($rollover->amount >= ($rollover->multiplier * $rollover->bonus->credit_hold)){
            $executeRollover = true;
        }

        $bonus = Bonus::query()
            ->where('status', true)
            ->where('id', $rollover->bonus_id)
            ->first();

        if($executeRollover && $bonus){
            $wallet = Wallet::query()
                ->where('user_id', $bonus->user_id)
                ->where('status', true)
                ->first();

            $wallet->balance += $bonus->balance;
            $wallet->save();

            $bonus->status = false;
            $bonus->save();

            $rollover->transaction()->create([
                'hash' => $rollover->hash,
                'amount' => $bonus->balance,
                'name' => 'rollover',
                'type' => 'credit',
                'status' => 'approved',
                'wallet_id' => $wallet->id,
                'user_id' => $wallet->user_id,
            ]);
        }
    }
}
