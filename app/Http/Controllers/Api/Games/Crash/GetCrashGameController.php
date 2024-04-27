<?php

namespace App\Http\Controllers\Api\Games\Crash;

use App\Enum\CrashStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Games\Crash\GameResource;
use App\Jobs\Games\Crash\CrashJob;
use App\Models\Games\Crash;
use App\Models\SettingsCrash;
use App\Services\Games\Crash\CalculateMultiplierService;
use Carbon\Carbon;
use Illuminate\Support\Str;

class GetCrashGameController extends Controller
{
  public function __invoke()
  {
    try {
      $lastGame = Crash::query()
      ->orderByRaw('FIELD(status, "pending") DESC')
      ->orderByRaw('FIELD(status, "started") DESC')
      ->latest()
      ->first();

    return [
      'message' => 'Crash Iniciado',
      'game' => (new GameResource($lastGame))
    ];
    } catch (\Throwable $th) {
      return $th;
    }
    
  }
}
