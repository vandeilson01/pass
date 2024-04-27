<?php

namespace App\Http\Resources\Admin\Cashout;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetCashoutsResource extends JsonResource
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
            'pix_key' => $this->pix_key,
            'pix_key_type' => $this->pix_key_type,
            'observation' => $this->observation,
            'status' => $this->status,
            'wallet_id' => $this->wallet_id,
            'wallet' => [
                'name' => $this->wallet?->name,
            ],
            'gateway_id' => $this->gateway_id,
            'gateway' => [
                'name' => $this->gateway?->name,
            ],
            'approved_by_id' => $this->approved_by,
            'approved_by' => [
                'name' => $this->approvedBy?->name,
                'email' => $this->approvedBy?->email,
            ],
            'created_at' => $this->created_at,
        ];
    }
}
