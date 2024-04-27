<?php

namespace App\Observers;

use App\Events\CashoutGameEvent;
use App\Events\CreateBetGameEvent;
use App\Events\CreatePgGameEvent;
use App\Models\GamesBet;

class GamesBetObserver
{
    public function created(GamesBet $model)
    {
        CreatePgGameEvent::dispatch($model);
    }
}
