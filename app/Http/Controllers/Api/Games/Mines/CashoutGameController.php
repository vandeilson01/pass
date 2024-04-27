<?php

namespace App\Http\Controllers\Api\Games\Mines;

use App\Events\CashoutGameEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\Games\Mines\GameResource;
use App\Models\Games\Mines;

class CashoutGameController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();

        $gameInProgress = Mines::query()
            ->where('user_id', $user->id)
            ->where('finish', false)
            ->where('win', false)
            ->orderByDesc('updated_at')
            ->first();

        if (!$gameInProgress || $gameInProgress->finish || $gameInProgress->win) {
            return response()->json([
                'message' => 'Você não possui uma partida em andamento',
            ], 400);
        }

        if (count($gameInProgress->clicks) < 1) {
            return response()->json([
                'message' => 'Você deve clicar em pelo menos um campo',
                'game' => (new GameResource($gameInProgress))
            ], 400);
        }


        if (!$gameInProgress->finish && !$gameInProgress->win) {
            $gameInProgress->finish = true;
            $gameInProgress->win = true;
            $gameInProgress->save();

            CashoutGameEvent::dispatch($gameInProgress);
        }

        return response()->json([
            'message' => 'Partida encerrada com sucesso',
            'game' => (new GameResource($gameInProgress))
        ], 200);
    }
}
