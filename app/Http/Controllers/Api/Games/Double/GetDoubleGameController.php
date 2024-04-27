<?php

namespace App\Http\Controllers\Api\Games\Double;

use App\Enum\DoubleStatus;
use App\Enum\DoubleWinningColor;
use App\Http\Controllers\Controller;
use App\Http\Resources\Games\Double\GameResource;
use App\Jobs\Games\Double\DoubleJob;
use App\Models\Games\Double;
use App\Services\Games\Double\CalculateMultiplierService;
use Carbon\Carbon;
use Illuminate\Support\Str;

class GetDoubleGameController extends Controller
{
    public function __invoke()
    {
        $lastGame = Double::query()
            ->latest()
            ->first();

        $lastGameFinished = Double::query()
            ->where('status', DoubleStatus::Finished->value)
            ->latest()
            ->first();

        if ($lastGameFinished && Carbon::parse($lastGameFinished->updated_at)->diffInSeconds(now()) >= 120) {
            DoubleJob::dispatch();
        }

        if (!$lastGame) {
            $winning_number = (new CalculateMultiplierService())->multiplier();

            $lastGame = Double::query()
                ->create([
                    'hash' => Str::random(32),
                    'status' => DoubleStatus::Pending->value,
                    'pending_at' => now()->addSeconds(15),
                    'winning_number' => $winning_number,
                    'winning_color' => DoubleWinningColor::getColor($winning_number)->value,
                ]);
        }

        return [
            'message' => 'Double Iniciado',
            'game' => (new GameResource($lastGame))
        ];
    }
}
