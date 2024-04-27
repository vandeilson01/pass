<?php

namespace App\Http\Controllers\Api\Games\Integrations\BetSac;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class GetUsernameController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = User::where('id', $request->id)->first();

        if (empty($user)) {
            return response()->json(['message' => 'Player does not exist', 'status' => 404], 404);
        }

        return response([
            'username' => $user->username,
            'balance' => (int)$user->wallet->balance
        ]);
    }
}
