<?php

namespace App\Listeners;

class CreateWalletUserListener
{
    public function __construct()
    {
    }

    public function handle($event): void
    {
        $user = $event->user;

        if($user->is_fake){
            return;
        }

        $user->wallets()->create([
            'name' => 'Real',
            'type' => 'main',
            'status' => true,
            'balance' => 0,
            'min_cashout_amount' => 10000,
            'max_cashout_amount' => 0,
        ]);

        $user->wallets()->create([
            'name' => 'Afiliado CPA',
            'type' => 'affiliate_cpa',
            'status' => true,
            'balance' => 0,
            'min_cashout_amount' => 5000,
            'max_cashout_amount' => 0,
        ]);

        $user->wallets()->create([
            'name' => 'Afiliado Revenue Share',
            'type' => 'affiliate_revenue_share',
            'status' => true,
            'balance' => 0,
            'min_cashout_amount' => 5000,
            'max_cashout_amount' => 0,
        ]);
    }
}
