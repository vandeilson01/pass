<?php

namespace App\Observers\Game;

use App\Events\Broadcast\Games\Crash\CrashGameEvent;
use App\Http\Resources\Games\Crash\GameResource;
use App\Jobs\Games\Crash\CrashJob;
use App\Models\Games\Crash;

class CrashObserver
{
    public function created(Crash $crash): void
    {
        CrashGameEvent::dispatch((new GameResource($crash)));
    }
}
