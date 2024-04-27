<?php

namespace App\Http\Resources\Admin\Configs\Gateways;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingsGatewayResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'gateway_id' => $this->gateway_id,
            'credentials' => $this->credentials,
            'is_active' => $this->is_active,
        ];
    }
}
