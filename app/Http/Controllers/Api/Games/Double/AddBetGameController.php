<?php

namespace App\Http\Controllers\Api\Games\Double;

use App\Http\Controllers\Controller;
use App\Http\Requests\Games\Double\AddBetGameRequest;
use App\Models\Games\Double;
use App\Models\Games\DoubleBet;
use App\Services\Wallet\BalanceService;
use Illuminate\Support\Str;

class AddBetGameController extends Controller
{
    public function __invoke(AddBetGameRequest $request)
    {
        $validated = $request->validated();

        $double = Double::query()
            ->latest()
            ->first();

        if(!$double){
            return response()->json([
                'message' => 'Double não iniciado'
            ], 404);
        }

        if($double->status !== 'pending'){
            return response()->json([
                'message' => 'Aguarde a próxima rodada para apostar'
            ], 400);
        }

        $user = auth()->user();

        $hasBetColor = DoubleBet::query()
            ->where('double_id', $double->id)
            ->where('user_id', $user->id)
            ->where('bet_color', $validated['color'])
            ->first();

        if($hasBetColor){
            return response()->json([
                'message' => 'Você já apostou nesta cor nesta rodada'
            ], 400);
        }

        $countBets = DoubleBet::query()
            ->where('double_id', $double->id)
            ->where('user_id', $user->id)
            ->count();

        if($countBets >= 2){
            return response()->json([
                'message' => 'Você atingiu o limite de apostas nesta rodada'
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

        $bet = $double->bets()->create([
            'hash' => Str::uuid(),
            'bet' => $validated['value_to_bet'],
            'balance_type' => $balanceType,
            'bet_color' => $validated['color'],
            'user_id' => $user->id,
            'payout_multiplier' => 0,
            'win' => false
        ]);

        return response()->json([
            'message' => 'Aposta realizada com sucesso',
            'bet' => [
                'id' => $bet->id,
                'bet' => $bet->bet,
                'balance_type' => $bet->balance_type,
                'bet_color' => $bet->bet_color,
                'win' => $bet->win,
            ]
        ]);
    }
}
