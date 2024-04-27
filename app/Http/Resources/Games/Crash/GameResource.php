<?php

namespace App\Http\Resources\Games\Crash;

use App\Enum\CrashStatus;
use App\Models\Games\Crash;
use App\Models\Games\CrashBet;
use App\Models\Games\DoubleBet;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        $latestCrashes = Crash::query()
            ->select('hash', 'multiplier')
            ->where('status', CrashStatus::Crashed->value)
            ->orderByDesc('created_at')
            ->limit(20)
            ->get()
            ->makeVisible('multiplier_crashed');


        $user = auth('sanctum')->user();

        $bets = CrashBet::query()
            ->with('user')
            ->when($user, function ($query) use ($user) {
                return $query->orderByRaw('FIELD(user_id, ' . $user['id'] . ') DESC');
            })
            ->where('crash_id', $this->id)
            ->orderByDesc('bet')
            ->get();

        $data = [
            "id" => $this->id,
            "status" => $this->status,
            "hash" => $this->hash,
            "pending_at" => $this->pending_at,
            "multiplier" => $this->multiplier,
            "multiplier_crashed" => $this->multiplier_crashed,
            "started_at" => $this->started_at,
            "latest_crash" => $latestCrashes,
            "bets" => ListBetsResource::collection($bets),
        ];

        if ($this->status !== CrashStatus::Crashed->value) {
            unset($data['multiplier_crashed']);
        }

        if ($this->status !== CrashStatus::Pending->value) {
            unset($data['pending_at']);
        }

        if (!$user) {
            return $data;
        }

        $bet = CrashBet::query()
            ->where('user_id', $user['id'])
            ->where('crash_id', $this->id)
            ->first();

        if ($bet) {
            $data['bet'] = $bet;
        }

        return $data;
    }
}
