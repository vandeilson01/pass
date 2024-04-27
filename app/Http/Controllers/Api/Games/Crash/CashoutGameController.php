<?php

namespace App\Http\Controllers\Api\Games\Crash;

use App\Events\CashoutGameEvent;
use App\Http\Controllers\Controller;
use App\Models\Games\Crash;
use App\Models\Games\CrashBet;

class CashoutGameController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();
        $crash = Crash::query()
            ->latest()
            ->first();

        if (!$crash) {
            return response()->json([
                'message' => 'Crash não iniciado'
            ], 404);
        }

        if ($crash->status === 'crashed') {
            return response()->json([
                'message' => 'Jogo Encerrado!'
            ], 400);
        }

        $bet = CrashBet::query()
            ->where('user_id', $user->id)
            ->where('crash_id', $crash->id)
            ->first();

        if (!$bet) {
            return response()->json([
                'message' => 'Você não apostou nesta rodada'
            ], 400);
        }

        if (!$bet->win) {
            $bet->update([
                'win' => true,
                'payout_multiplier' => $crash->multiplier,
            ]);

            CashoutGameEvent::dispatch($bet);
        }

        return response()->json([
            "message" => "Aposta retirada com sucesso!",
            'bet' => [
                'id' => $bet->id,
                'bet' => $bet->bet,
                'balance_type' => $bet->balance_type,
                'multiplier' => $bet->payout_multiplier,
                'profit' => $bet->bet * $bet->payout_multiplier,
                'win' => $bet->win,
            ]
        ], 200);
    }
}
