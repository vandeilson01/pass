<?php

namespace App\Observers\Game;

use App\Enum\DoubleStatus;
use App\Events\Broadcast\Games\Double\DoubleGameEvent;
use App\Http\Resources\Games\Double\GameResource;
use App\Jobs\Games\Double\CashoutGameJob;
use App\Jobs\Games\Double\DoubleJob;
use App\Models\Games\Double;

class DoubleObserver
{
    public function created(Double $double): void
    {
        DoubleGameEvent::dispatch((new GameResource($double)));
        DoubleJob::dispatch();
    }

    public function updated(Double $double): void
    {
        if($double->status == DoubleStatus::Finished->value) {
            CashoutGameJob::dispatch($double);
        }
    }

}
