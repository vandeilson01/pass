<?php

namespace App\Http\Controllers\Api\Games\Integrations\PgSoft;

use App\Http\Controllers\Controller;
use App\Models\Games;
use App\Models\GamesProvider;
use App\Models\PgLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VerifySessionController extends Controller
{
    public function __invoke(Request $request)
    {
        PgLog::create([
            'name' => 'VerifySession',
            'request' => $request->all(),
        ]);

        $token = $request->operator_player_session;

        $user = User::whereHas('games', function ($query) use ($token) {
            $query->where('games_user.token', $token);
        })->first();

        if (empty($user)) {
            return response()->json([
                'data' => null,
                'error' => [
                    'code' => '1200',
                    'message' => 'Invalid session',
                ],
            ]);
        }

        return response()->json([
            'data' => [
                'player_name' => $user->email,
                'nickname' => Str::slug($user->name),
                'currency' => 'BRL',
            ],
            'error' => null,
        ]);
    }
}
