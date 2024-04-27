<?php

namespace App\Observers;

use App\Events\UpdateRolloverEvent;
use App\Models\Rollover;

class RolloverObserver
{
    public function updated(Rollover $rollover): void
    {
        UpdateRolloverEvent::dispatch($rollover);
    }
}
