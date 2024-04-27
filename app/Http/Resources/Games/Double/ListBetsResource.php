<?php

namespace App\Http\Resources\Games\Double;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListBetsResource extends JsonResource
{

    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user->id,
            'name' => $this->user->name,
            'bet' => $this->bet,
            'bet_color' => $this->bet_color,
            'win' => $this->win,
        ];
    }
}
