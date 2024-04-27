<?php

namespace App\Http\Controllers\Api\Games\Integrations\PgSoft\Cash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Integrations\PgSoft\Cash\TransferInOutRequest;
use App\Models\Games;
use App\Models\GamesBet;
use App\Models\PgLog;
use App\Models\User;
use App\Models\Wallet;
use App\Services\Wallet\BalanceService;


class TransferInOutController extends Controller
{
    public function __invoke(TransferInOutRequest $request)
    {
        //TODO: remover
        PgLog::create([
            'name' => 'TransferInOutRequest',
            'request' => $request->all(),
        ]);

        $token = $request->operator_player_session;

        $user = User::whereHas('games', function ($query) use ($token) {
            $query->where('games_user.token', $token);
        })->first();

        $game = Games::whereHas('users', function ($query) use ($token) {
            $query->where('games_user.token', $token);
        })->first();

        $isWin = (bool)number_format(((float)$request->get('win_amount')) * 100, 0, '', '') > 0;
        $betAmount = (int)number_format(((float)$request->get('bet_amount')) * 100, 0, '', '');
        $winAmount = (int)number_format(((float)$request->get('win_amount')) * 100, 0, '', '');
        $transferAmount = (int)number_format(((float)$request->get('transfer_amount')) * 100, 0, '', '');

        if ($betAmount > 0 || $transferAmount < 0) {
            $balance = $user->wallet->balance;

            if ($betAmount > $balance || -$transferAmount > $balance) {
                PgLog::create([
                    'name' => 'InsufficientBalance',
                    'request' => $request->all(),
                ]);
                return response()->json([
                    'data' => null,
                    'error' => [
                        'code' => '3202',
                        'message' => 'Insufficient balance',
                    ],
                ]);
            }
        }

        $parentBetId = $request->get('parent_bet_id');
        $betId = $request->get('bet_id');

        if (empty($user)) {
            return response()->json([
                'data' => null,
                'error' => [
                    'code' => '3004',
                    'message' => 'Player does not exist',
                ],
            ]);
        }

        if (empty($user->wallet)) {
            return response()->json([
                'data' => null,
                'error' => [
                    'code' => '3005',
                    'message' => 'Player wallet does not exist',
                ],
            ]);
        }

        if (
            $betAmount <= 0 &&
            $winAmount <= 0
        ) {
            $balance = Wallet::where('user_id', $user->id)->where('type', 'main')->first()->balance;

            return response()->json([
                'data' => [
                    'currency_code' => 'BRL',
                    'balance_amount' => number_format($balance / 100, 2, '.', ''),
                    'updated_time' => microtime(true),
                ],
                'error' => null,
            ]);
        }

        $payoutMultiplier = -1;

        if ($betAmount > 0 && $winAmount > 0) {
            $payoutMultiplier = ($winAmount - $betAmount) / $betAmount;
        }

        if ($betAmount <= 0 && $winAmount > 0) {
            $payoutMultiplier = 1;
        }

        GamesBet::query()->firstOrCreate(
            [
                'user_id' => $user->id,
                'parent_bet_id' => $parentBetId,
                'bet_id' => $betId,
                'game_id' => $game->id,
            ],
            [
                'bet' => $betAmount > 0 ? $betAmount : max($winAmount, 0),
                'balance_type' => 'wallet',
                'win' => $isWin,
                'payout_multiplier' => $payoutMultiplier,
            ]
        );

        $balance = Wallet::where('user_id', $user->id)->where('type', 'main')->first()->balance;

        PgLog::create([
            'name' => 'response-transfer-in-out',
            'request' => number_format($balance / 100, 2, '.', ''),
        ]);

        return response()->json([
            'data' => [
                'currency_code' => 'BRL',
                'balance_amount' => number_format($balance / 100, 2, '.', ''),
                'updated_time' => microtime(true),
            ],
            'error' => null,
        ]);
    }
}
