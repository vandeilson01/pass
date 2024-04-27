<?php

namespace App\Http\Controllers\Api\Games\Integrations\PgSoft\Cash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Integrations\PgSoft\Cash\GetRequest;
use App\Models\PgLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GetController extends Controller
{
    public function __invoke(GetRequest $request)
    {
        PgLog::create([
            'name' => 'CashGet',
            'request' => $request->all(),
        ]);

        $token = $request->operator_player_session;

        $user = User::whereHas('games', function ($query) use ($token) {
            $query->where('games_user.token', $token);
        })->first();

        if (empty($user->wallet)) {
            return response()->json([
                'data' => null,
                'error' => [
                    'code' => '3005',
                    'message' => 'Player wallet does not exist',
                ],
            ]);
        }

        PgLog::create([
            'name' => 'get-response',
            'request' => number_format($user->wallet->balance / 100, 2, '.', ''),
        ]);

        return response()->json([
            'data' => [
                'currency_code' => 'BRL',
                'balance_amount' => number_format($user->wallet->balance / 100, 2, '.', ''),
                'updated_time' => microtime(true),
            ],
            'error' => null,
        ]);
    }
}
