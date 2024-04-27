<?php

namespace App\Listeners\Transaction;

use App\Models\Bonus;
use App\Models\Rollover;
use App\Models\Wallet;
use Illuminate\Support\Facades\Log;

class CreatePgGameTransactionsAndFetchBalanceListener
{
    public function __construct()
    {
    }

    public function handle($event): void
    {
        $game = $event->game;

        if ($game->user->is_fake) {
            return;
        }

        $value = $game->bet * $game->payout_multiplier;

        $game->transaction()->create([
            'hash' => $game->hash,
            'amount' =>  $value,
            'name' => 'cassino',
            'type' => $value >= 0 ? 'credit' : 'debit',
            'status' => 'approved',
            'game_id' => $game->id,
            'wallet_id' => $game->balance_type === 'wallet' ? $game->user->wallet->id : null,
            'bonus_id' => null,
            'user_id' => $game->user_id,
        ]);

        if ($game->balance_type === 'wallet') {
            $wallet = Wallet::find($game->user->wallet->id);
            $wallet->balance += $value;
            $wallet->save();
        }

    }
}
