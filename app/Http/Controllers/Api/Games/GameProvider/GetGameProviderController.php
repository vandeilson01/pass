<?php

namespace App\Http\Controllers\Api\Games\GameProvider;

use App\Http\Controllers\Controller;
use App\Models\Games;

class GetGameProviderController extends Controller
{
    public function __invoke(Games $game)
    {
        return response()->json($game->load('gamesProvider'));
    }
}
