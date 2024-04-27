<?php

namespace App\Events;

use App\Models\Transaction;
use Illuminate\Foundation\Events\Dispatchable;

class CreateTransactionEvent
{
    use Dispatchable;

    public function __construct(public Transaction $transaction)
    {
    }
}
