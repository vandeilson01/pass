<?php

namespace App\Listeners;

use App\Mail\Deposit\ApproveDeposit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendApprovedDepositEmailListener
{
    use Queueable;

    public function __construct()
    {
        $this->onQueue('default' . env('APP_NAME'));
    }

    public function handle($event): void
    {
        $deposit = $event->deposit;

        Mail::to($deposit->user)->send(new ApproveDeposit($deposit));
    }
}
