<?php

namespace App\Http\Resources\Games\Crash;

use App\Models\Games\Crash;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HistoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'hash' => $this->hash,
            'multiplier' => $this->multiplier_crashed,
        ];
    }
}
