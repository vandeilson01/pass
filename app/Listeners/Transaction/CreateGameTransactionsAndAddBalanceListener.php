<?php

namespace App\Listeners\Transaction;

use App\Models\Bonus;
use App\Models\Transaction;
use App\Models\Wallet;
use DB;

class CreateGameTransactionsAndAddBalanceListener
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

        if (!$game->win) {
            return;
        }

        $verifyTransaction = Transaction::query()
            ->where('hash', $game->hash)
            ->where('user_id', $game->user_id)
            ->where('typable_id', $game->id)
            ->where('typable_type', get_class($game))
            ->where('type', 'credit')
            ->first();

        if ($verifyTransaction) {
            return;
        }

        $value = (float)($game->bet * $game->payout_multiplier);


        DB::beginTransaction();

        try {
            if ($game->balance_type == 'wallet') {
                $wallet = Wallet::find($game->user->wallet->id);
                $wallet->balance += $value;
                $wallet->save();
            }

            if ($game->balance_type == 'bonus') {
                $bonus = Bonus::query()
                    ->whereUserId($game->user_id)
                    ->whereStatus(true)->first();

                if ($bonus) {
                    $bonus->balance += $value;
                    $bonus->save();
                } else {
                    $wallet = Wallet::find($game->user->wallet->id);
                    $wallet->balance += $value;
                    $wallet->save();

                    $game->balance_type = 'wallet';
                    $game->save();
                }
            }

            $newTransaction = Transaction::updateOrCreate([
                'hash' => $game->hash,
                'user_id' => $game->user_id,
                'typable_id' => $game->id,
                'typable_type' => get_class($game),
                'type' => 'credit',
            ], [
                'amount' => $value,
                'name' => 'cassino',
                'status' => 'approved',
                'wallet_id' => $game->balance_type === 'wallet' ? $game->user->wallet->id : null,
                'bonus_id' => $game->balance_type === 'bonus' ? $bonus?->id : null,
            ]);

            if (!$newTransaction->wasRecentlyCreated) {
                DB::rollBack();
            }

            $countTransaction = Transaction::query()
                ->where('hash', $game->hash)
                ->where('user_id', $game->user_id)
                ->where('typable_id', $game->id)
                ->where('typable_type', get_class($game))
                ->where('type', 'credit')
                ->count();

            if ($countTransaction > 1) {
                DB::rollBack();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return;
        }
    }
}
