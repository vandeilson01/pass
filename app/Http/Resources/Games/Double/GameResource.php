<?php

namespace App\Http\Resources\Games\Double;

use App\Enum\CrashStatus;
use App\Enum\DoubleStatus;
use App\Models\Games\CrashBet;
use App\Models\Games\Double;
use App\Models\Games\DoubleBet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class GameResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        $latestDoubles = Double::query()
            ->select('hash', 'winning_number')
            ->where('status', DoubleStatus::Finished->value)
            ->orderByDesc('created_at')
            ->limit(20)
            ->get()
            ->makeVisible('winning_number');

        $user = auth('sanctum')->user();

        $bets = DoubleBet::query()
            ->with('user')
            ->when($user, function ($query) use ($user) {
                return $query->orderByRaw('FIELD(user_id, ' . $user['id'] . ') DESC');
            })
            ->where('double_id', $this->id)
            ->orderByDesc('bet')
            ->get();

        $data = [
            "id" => $this->id,
            "hash" => $this->hash,
            "winning_number" => $this->winning_number,
            "winning_color" => $this->winning_color,
            "status" => $this->status,
            "pending_at" => $this->pending_at,
            "latest_double" => $latestDoubles,
            "bets" => ListBetsResource::collection($bets),
        ];

        if ($this->status === DoubleStatus::Pending->value) {
            unset($data['winning_number']);
            unset($data['winning_color']);
        }

        if ($this->status !== DoubleStatus::Pending->value) {
            unset($data['pending_at']);
        }


        if (!$user) {
            return $data;
        }

        $bet = DoubleBet::query()
            ->where('user_id', $user['id'])
            ->where('double_id', $this->id)
            ->get();

        if ($bet) {
            $data['bet'] = $bet;
        }

        return $data;
    }
}
