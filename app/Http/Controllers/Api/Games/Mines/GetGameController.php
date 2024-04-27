<?php

namespace App\Http\Controllers\Api\Games\Mines;

use App\Http\Controllers\Controller;
use App\Http\Resources\Games\Mines\GameResource;
use App\Models\Games\Mines;

class GetGameController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();

        $gameInProgress = Mines::query()
            ->where('user_id', $user->id)
            ->where('finish', false)
            ->orderByDesc('updated_at')
            ->first();

        if ($gameInProgress) {
            return response()->json([
                'message' => 'Você já possui uma partida em andamento',
                'game' => (new GameResource($gameInProgress))
            ], 200);
        }

        return response()->json([
            'message' => 'Você não possui uma partida em andamento',
        ], 200);
    }
}
