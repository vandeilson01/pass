<?php

namespace App\Observers;

use App\Events\CreateTransactionEvent;
use App\Models\Transaction;

class TransactionObserver
{
    public function created(Transaction $transaction)
    {
        CreateTransactionEvent::dispatch($transaction);
    }
}
