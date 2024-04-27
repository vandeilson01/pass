<?php

namespace App\Http\Controllers\Api\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Resources\Wallet\GetBonusResource;
use App\Models\Bonus;

class GetBonusController extends Controller
{
    public function __invoke()
    {
        $bonus = Bonus::query()
                ->with('rollover')
                ->where('user_id', auth()->user()->id)
                ->where('status', true)
                ->orderBy('created_at', 'desc')
            ->first();

        if(!$bonus) {
            return response()->json([
                'message' => 'Sem Bônus Ativo!'
            ], 200);
        }

        return response()->json(new GetBonusResource($bonus));
    }
}
