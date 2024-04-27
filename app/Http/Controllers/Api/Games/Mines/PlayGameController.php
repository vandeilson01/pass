<?php

namespace App\Http\Controllers\Api\Games\Mines;

use App\Events\CashoutGameEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Games\Mines\PlayGameRequest;
use App\Http\Resources\Games\Mines\GameResource;
use App\Models\Games\Mines;
use App\Services\Games\Mines\CalculateMultiplierService;

class PlayGameController extends Controller
{
    public function __invoke(PlayGameRequest $request)
    {
        $user = auth()->user();
        $validated = $request->validated();

        $gameInProgress = Mines::query()
            ->where('user_id', $user->id)
            ->where('finish', false)
            ->orderByDesc('updated_at')
            ->first();

        if (!$gameInProgress) {
            return response()->json([
                'message' => 'Você não possui uma partida em andamento',
            ], 400);
        }

        if (in_array($validated['position'], $gameInProgress->clicks)) {
            return response()->json([
                'message' => 'Você já clicou nessa posição',
                'game' => (new GameResource($gameInProgress))
            ], 200);
        }

        $clicks = array_merge($gameInProgress->clicks, [(int) $validated['position']]);
        $gameInProgress->clicks = $clicks;
        $gameInProgress->save();


        if($user->hasRole('player')){
            if(
                $gameInProgress->bet * (new CalculateMultiplierService($gameInProgress->number_of_bombs, count($gameInProgress->clicks)))->multiplier() >= 15000 ||
                (new CalculateMultiplierService($gameInProgress->number_of_bombs, count($gameInProgress->clicks)))->multiplier() >= 1.00 + (mt_rand() / mt_getrandmax() * (4.00 - 1.00))
            ){
                $bombs = $gameInProgress->bombs;
                array_pop($bombs);
                $bombs[] = (int) $validated['position'];
                sort($bombs);

                $gameInProgress->bombs = $bombs;
                $gameInProgress->save();
            }
        }

        if (in_array($validated['position'], $gameInProgress->bombs)) {
            $gameInProgress->finish = true;
            $gameInProgress->win = false;
            $gameInProgress->payout_multiplier = 0;
            $gameInProgress->save();

            return response()->json([
                'message' => 'Você clicou em uma bomba e perdeu',
                'game' => (new GameResource($gameInProgress))
            ], 200);
        }

        $gameInProgress->payout_multiplier = (new CalculateMultiplierService($gameInProgress->number_of_bombs, count($gameInProgress->clicks)))->multiplier();
        $gameInProgress->payout_multiplier_on_next = (new CalculateMultiplierService($gameInProgress->number_of_bombs, count($gameInProgress->clicks) + 1))->multiplier();
        $gameInProgress->save();

        if (count($gameInProgress->clicks) + $gameInProgress->number_of_bombs === 25) {
            $gameInProgress->finish = true;
            $gameInProgress->win = true;
            $gameInProgress->save();

            CashoutGameEvent::dispatch($gameInProgress);

            return response()->json([
                'message' => 'Você ganhou',
                'game' => (new GameResource($gameInProgress))
            ], 200);
        }

        return response()->json([
            'message' => 'Você clicou na posição ' . $validated['position'],
            'game' => (new GameResource($gameInProgress))
        ], 200);
    }
}
