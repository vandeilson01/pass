<?php

namespace App\Http\Controllers\Api\Games\Mines;

use App\Http\Controllers\Controller;
use App\Http\Requests\Games\Mines\StartGameRequest;
use App\Http\Resources\Games\Mines\GameResource;
use App\Models\Games\Mines;
use App\Services\Games\Mines\CalculateMultiplierService;
use App\Services\Wallet\BalanceService;
use Illuminate\Support\Str;

class StartGameController extends Controller
{
    public function __invoke(StartGameRequest $request)
    {$user = auth()->user();
        $validated = $request->validated();

        $gameInProgress = Mines::query()
            ->where('user_id', $user->id)
            ->where('finish', false)
            ->first();

        if ($gameInProgress) {
            return response()->json([
                'message' => 'Você já possui uma partida em andamento',
                'game' => (new GameResource($gameInProgress))
            ], 200);
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

        $bombs = $this->generateBombs($validated['number_of_bombs']);

        $mines = Mines::create([
            'hash' => Str::uuid(),
            'bet' => $validated['value_to_bet'],
            'balance_type' => $balanceType,
            'number_of_bombs' => $validated['number_of_bombs'],
            'bombs' => $bombs,
            'clicks' => [],
            'finish' => false,
            'win' => false,
            'user_id' => $user->id,
            'payout_multiplier' => (new CalculateMultiplierService($validated['number_of_bombs'], 0))->multiplier(),
            'payout_multiplier_on_next' => (new CalculateMultiplierService($validated['number_of_bombs'], 1))->multiplier(),
        ]);

        return [
            'message' => 'Jogo iniciado com sucesso',
            'game' => (new GameResource(Mines::find($mines->id)))
        ];
    }

    private function generateBombs($numberOfBombs)
    {
        $bombs = range(1, 25);

        shuffle($bombs);
        shuffle($bombs);
        shuffle($bombs);

        $bombs = array_slice($bombs, 0, $numberOfBombs);
        sort($bombs);

        return $bombs;
    }
}
