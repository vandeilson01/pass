<?php

namespace App\Listeners\Payment;

use App\Models\Payment\Deposit;
use App\Models\User;

class AddCpaValueBeforeDepositApprovedListener
{
    public function __construct()
    {
    }

    public function handle($event): void
    {
        $deposit = $event->deposit;
        $user = $deposit->user;

        if (
            $user->hasRole('fake') ||
            $user->hasRole('youtuber') ||
            $user->hasRole('moderator') ||
            $user->hasRole('admin')
        ) {
            return;
        }

        if ($user->affiliate_id) {
            $affiliate = User::find($user->affiliate_id);

            $firstDeposit = Deposit::query()
                ->where('user_id', $user->id)
                ->where('status', 'approved')
                ->where('amount', '>=', $affiliate->affiliate_min_deposit_cpa)
                ->first();

            if (!$firstDeposit) {
                return;
            }

            if (
                $affiliate && ($firstDeposit || $deposit->id === $firstDeposit->id)
            ) {
                $this->commissionCpa($user, $affiliate, 'wallet_cpa', $deposit->hash);
            }
        }
    }

    private function commissionCpa(User $user, User $affiliate, string $type, $hash)
    {
        $amount = $affiliate->affiliate_cpa ?? 0;
        $wallet = $affiliate->$type;

        $wallet->balance += $amount;
        $wallet->save();

        $user->transaction()->create([
            'hash' => $hash,
            'amount' => $amount,
            'name' => 'affiliate_cpa',
            'type' => 'credit',
            'status' => 'approved',
            'wallet_id' => $wallet->id,
            'user_id' => $affiliate->id,
        ]);

        if ($affiliate->affiliate_id) {
            $affiliateSub = User::find($affiliate->affiliate_id);

            if ($affiliateSub) {
                $this->commissionCpaSub($affiliate, $affiliateSub, 'wallet_cpa', $hash);
            }
        }
    }

    private function commissionCpaSub(User $user, User $affiliate, string $type, $hash)
    {
        $amount = $affiliate->affiliate_cpa_sub ?? 0;
        $wallet = $affiliate->$type;

        $wallet->balance += $amount;
        $wallet->save();

        $user->transaction()->create([
            'hash' => $hash,
            'amount' => $amount,
            'name' => 'affiliate_cpa',
            'type' => 'credit',
            'status' => 'approved',
            'wallet_id' => $wallet->id,
            'user_id' => $affiliate->id,
        ]);
    }
}
