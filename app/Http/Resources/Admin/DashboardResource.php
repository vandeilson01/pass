<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'deposits' => new DepositsResource($this),
            'cashout' => new CashoutResource($this),
            'users' => new GetUsersStatisticsResource($this),
        ];
    }
}
