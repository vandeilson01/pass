<?php

namespace App\Observers\Game;

use App\Events\Broadcast\Games\Crash\CrashBetEvent;
use App\Events\CreateBetGameEvent;
use App\Http\Resources\Games\Crash\ListBetsResource;
use App\Models\Games\CrashBet;

class CrashBetObserver
{
    public function created(CrashBet $bet)
    {
        CrashBetEvent::dispatch(new ListBetsResource($bet));
        CreateBetGameEvent::dispatch($bet);
    }

    public function updated(CrashBet $bet)
    {
        CrashBetEvent::dispatch(new ListBetsResource($bet));
    }

}
