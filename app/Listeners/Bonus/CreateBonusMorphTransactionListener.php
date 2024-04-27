<?php

namespace App\Listeners\Bonus;

class CreateBonusMorphTransactionListener
{
    public function __construct()
    {
    }

    public function handle($event): void
    {
        $bonus = $event->bonus;

        $bonus->transaction()->create([
            'hash' => $bonus->hash,
            'name' => 'bonus',
            'status' => $bonus->status ? 'approved' : 'refused',
            'amount' => $bonus->balance,
            'type' => 'credit',
            'user_id' => $bonus->user_id,
            'bonus_id' => $bonus->id,
        ]);
    }
}
