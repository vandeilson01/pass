<?php

namespace App\Observers\Game;

use App\Events\CreateBetGameEvent;
use App\Models\Games\Mines;

class MinesObserver
{
    public function created(Mines $mines): void
    {
        CreateBetGameEvent::dispatch($mines);
    }
}
