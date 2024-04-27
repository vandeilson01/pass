<?php

namespace App\Events;

use App\Models\Payment\Deposit;
use App\Models\Wallet;
use Illuminate\Foundation\Events\Dispatchable;

class ApprovedDepositEvent
{
    use Dispatchable;

    public Wallet | null $wallet;

    public function __construct(
        public Deposit $deposit
    )
    {
        $this->wallet = Wallet::find($deposit->wallet_id);
    }
}
