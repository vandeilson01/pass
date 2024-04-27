<?php

namespace App\Events;

use App\Models\Bonus;
use Illuminate\Foundation\Events\Dispatchable;

class CreateBonusEvent
{
    use Dispatchable;

    public function __construct(
        public Bonus $bonus
    )
    {
    }
}
