<?php

namespace App\Http\Resources\Wallet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetBonusResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'status' => $this->status,
            'balance' => $this->balance,
            'credit_hold' => $this->credit_hold,
            'expiration_at' => $this->expiration_at,
            'rollover' => [
                'amount' => $this->rollover->amount,
                'count' => $this->rollover->count,
                'multiplier' => $this->rollover->multiplier,
                'rollover_count' => $this->rollover->rollover_count,
            ],
        ];
    }
}
