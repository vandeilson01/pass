<?php

namespace App\Http\Controllers\Api\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Resources\Wallet\GetWalletsResource;
use App\Models\Wallet;

class GetWalletsController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();

        $wallets = Wallet::query()
            ->where('user_id', $user->id)
            ->where('status', true)
            ->where(function ($query) {
                $query->where('type', 'main')
                    ->orWhere('balance', '>', 0);
            })->get();

        return response()->json(GetWalletsResource::collection($wallets));
    }
}
