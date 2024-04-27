<?php

namespace App\Listeners;

use App\Mail\Cashout\CreateCashoutMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendApproveCashoutEmailListener implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        $this->onQueue('default' . env('APP_NAME'));
    }

    public function handle($event): void
    {
        $cashout = $event->cashout;

        if ($cashout->status == 'approved')
        {
            Mail::to($cashout->user)->send(new CreateCashoutMail($cashout));
        }
    }
}
