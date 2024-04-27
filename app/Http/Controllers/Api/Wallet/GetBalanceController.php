<?php

namespace App\Http\Controllers\Api\Wallet;

use App\Http\Controllers\Controller;

class GetBalanceController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user()->load('bonus');
        $balance = $user->wallet->balance ?? 0;
        $bonus = $user->bonus->balance ?? 0;

        return [
            'balance' => $balance,
            'bonus' => $bonus,
        ];
    }
}
