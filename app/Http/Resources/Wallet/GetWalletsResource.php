<?php

namespace App\Http\Resources\Wallet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetWalletsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type'  => $this->type,
            'balance' => $this->balance,
            'min_cashout_amount' => $this->min_cashout_amount,
        ];
    }
}
