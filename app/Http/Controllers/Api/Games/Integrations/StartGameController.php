<?php

namespace App\Http\Controllers\Api\Games\Integrations;

use App\Http\Controllers\Controller;
use App\Models\Games;
use App\Models\GamesProvider;
use App\Models\User;
use App\Services\Games\Integrations\GamesProviders\PgSoftService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StartGameController extends Controller
{
    public function __invoke(Request $request, Games $game)
    {
        $user = User::find(auth()->user()->id);

        $ops = Str::uuid();

        $user->games()->attach($game->id, [
            'token' => $ops
        ]);

        return response()->json([
            'data' => [
                'operator_player_session' => $ops,
                'game_url' => (new PgSoftService($game->game_id))->generateGameUrl($ops),
            ]
        ]);
    }
}
