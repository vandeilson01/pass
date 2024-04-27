<?php

namespace App\Observers\Game;

use App\Events\Broadcast\Games\Double\DoubleBetEvent;
use App\Events\CreateBetGameEvent;
use App\Http\Resources\Games\Double\ListBetsResource;
use App\Models\Games\DoubleBet;

class DoubleBetObserver
{
    public function created(DoubleBet $bet)
    {
        DoubleBetEvent::dispatch(new ListBetsResource($bet));
        CreateBetGameEvent::dispatch($bet);
    }

    public function updated(DoubleBet $bet)
    {
        DoubleBetEvent::dispatch(new ListBetsResource($bet));
    }

}
