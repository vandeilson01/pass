<?php

namespace App\Listeners\Transaction;

use App\Models\Bonus;
use App\Models\Rollover;
use App\Models\Wallet;
use Illuminate\Support\Facades\Log;

class CreateGameTransactionsAndRemoveBalanceListener
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

        $game->transaction()->create([
            'hash' => $game->hash,
            'amount' => -$game->bet,
            'name' => 'cassino',
            'type' => 'debit',
            'status' => 'approved',
            'game_id' => $game->id,
            'wallet_id' => $game->balance_type === 'wallet' ? $game->user->wallet->id : null,
            'bonus_id' => $game->balance_type === 'bonus' ? $game->user->bonus->id : null,
            'user_id' => $game->user_id,
        ]);

        if ($game->balance_type === 'wallet') {
            $wallet = Wallet::find($game->user->wallet->id);
            $wallet->balance -= $game->bet;
            $wallet->save();
        }

        if ($game->balance_type === 'bonus') {
            $bonus = Bonus::find($game->user->bonus->id);
            $bonus->balance -= $game->bet;
            $bonus->save();

            $rollover = Rollover::where('bonus_id', $bonus->id)->first();
            $rollover->count += 1;
            $rollover->amount += $game->bet;
            $rollover->save();
        }
    }
}
