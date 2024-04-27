<?php

namespace App\Http\Resources\Admin\Deposits;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetDepositsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'external_id' => $this->external_id,
            'user_id' => $this->user_id,
            'user' => [
                'name' => $this->user->name,
                'email' => $this->user->email,
                'document' => $this->user->document,
                'phone' => $this->user->phone,
            ],
            'amount' => $this->amount,
            'currency' => $this->currency,
            'has_bonus' => $this->has_bonus,
            'status' => $this->status,
            'refused_reason' => $this->refused_reason,
            'wallet_id' => $this->wallet_id,
            'gateway_id' => $this->gateway_id,
            'gateway' => [
                'name' => $this->gateway->name,
            ],
            'created_by' => [
                'name' => $this->createdBy->name,
                'email' => $this->createdBy->email,
            ],
            'created_at' => $this->created_at,
        ];
    }
}
