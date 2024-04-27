<?php

namespace App\Http\Resources\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetTransactionsResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'amount' => $this->amount,
            'type' => $this->type,
            'typable_type' => $this->typable_type,
            'created_at' => $this->created_at->format('d/m/Y H:i:s'),
            'balance_type' => ($this->wallet_id && is_null($this->bonus_id)) ? 'wallet' : 'bonus',
        ];
    }
}
