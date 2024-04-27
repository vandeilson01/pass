<?php

namespace App\Http\Controllers\Api\Games\Crash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Games\Crash\AddBetGameRequest;
use App\Models\Games\Crash;
use App\Models\Games\CrashBet;
use App\Models\Games\Mines;
use App\Services\Wallet\BalanceService;
use Illuminate\Support\Str;

class AddBetGameController extends Controller
{
    public function __invoke(AddBetGameRequest $request)
    {
        $validated = $request->validated();

        $crash = Crash::query()
            ->latest()
            ->first();

        if(!$crash){
            return response()->json([
                'message' => 'Crash não iniciado'
            ], 404);
        }

        if($crash->status !== 'pending'){
            return response()->json([
                'message' => 'Aguarde a próxima rodada para apostar'
            ], 400);
        }

        $user = auth()->user();

        $hasBet = CrashBet::query()
            ->where('crash_id', $crash->id)
            ->where('user_id', $user->id)
            ->first();

        if($hasBet){
            return response()->json([
                'message' => 'Você já apostou nesta rodada'
            ], 400);
        }

        $balanceType = (new BalanceService())->getBalanceType($user, $validated['value_to_bet']);

        if(!$balanceType) {
            return response()->json([
                'message' => 'Saldo insuficiente para iniciar a partida.',
                'errors' => [
                    'value_to_bet' => 'Saldo insuficiente para iniciar a partida.'
                ]
            ], 400);
        }

        $bet = $crash->bets()->create([
            'hash' => Str::uuid(),
            'bet' => $validated['value_to_bet'],
            'balance_type' => $balanceType,
            'user_id' => $user->id,
            'win' => false,
            'payout_multiplier' => 1,
        ]);

        return [
            'message' => 'Aposta realizada com sucesso',
            'bet' => [
                'id' => $bet->id,
                'bet' => $bet->bet,
                'balance_type' => $bet->balance_type,
                'multiplier' => $bet->payout_multiplier,
                'profit' => $bet->bet * $bet->payout_multiplier,
                'win' => $bet->win,
            ]
        ];

    }
}
