<?php

namespace App\Services\Wallet;

use App\Models\Bonus;
use App\Models\User;

class BalanceService
{
    public function getBalanceType(User $user, int $value_to_bet): string | bool
    {
        if ($user->wallet->balance >= $value_to_bet) {
            return 'wallet';
        }

        if ($user->wallet->balance > 0) {
            return false;
        }

        $existBonus = Bonus::query()
            ->where('status', true)
            ->where('user_id', $user->id)
            ->where('expiration_at', '>', now())
            ->exists();

        if ($existBonus && $user->bonus->balance >= $value_to_bet && $user->wallet->balance == 0) {
            return 'bonus';
        }

        return false;
    }
}
