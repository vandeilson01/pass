<?php

namespace App\Observers;

use App\Events\CreateBonusEvent;
use App\Models\Bonus;

class BonusObserver
{
    public function created(Bonus $bonus): void
    {
        CreateBonusEvent::dispatch($bonus);
    }

}
