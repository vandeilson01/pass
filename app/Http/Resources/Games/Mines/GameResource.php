<?php

namespace App\Http\Resources\Games\Mines;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        $data = [
            "bet" => $this->bet,
            "balance_type" => $this->balance_type,
            "number_of_bombs" => $this->number_of_bombs,
            "clicks" => $this->clicks,
            "finish" => $this->finish,
            "win" => $this->win,
            "payout_multiplier" => (float) number_format($this->payout_multiplier, 2, '.', ''),
            "payout_multiplier_on_next" => (float) number_format($this->payout_multiplier_on_next, 2, '.', ''),
            "bombs" => $this->bombs,
        ];

        if (!$this->finish) {
            unset($data['bombs']);
        }

        return $data;
    }
}
