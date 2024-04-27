<?php

namespace App\Events;

use App\Models\Rollover;
use Illuminate\Foundation\Events\Dispatchable;

class UpdateRolloverEvent
{
    use Dispatchable;

    public function __construct(
        public Rollover $rollover
    )
    {
    }
}
