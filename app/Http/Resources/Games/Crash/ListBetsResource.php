<?php

namespace App\Http\Resources\Games\Crash;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListBetsResource extends JsonResource
{

    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->user->name,
            'bet' => $this->bet,
            'multiplier' => $this->win ? $this->payout_multiplier : null,
            'profit' => $this->win ? ($this->bet * $this->payout_multiplier) : null,
            'win' => $this->win,
        ];
    }
}
