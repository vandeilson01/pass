<?php

namespace App\Listeners\Transaction;

use App\Models\Transaction;
use App\Models\User;

class CheckTransactionAffiliatesListener
{
    public function __construct()
    {
    }

    public function handle($event): void
    {
        $transaction = $event->transaction;

        if($transaction->name === 'cassino' && !is_null($transaction->wallet_id) && is_null($transaction->bonus_id)) {
            $user = User::find($transaction->user_id);

            if(
                $user->hasRole('fake') ||
                $user->hasRole('youtuber') ||
                $user->hasRole('moderator') ||
                $user->hasRole('admin')
            ){
                return;
            }

            $amount = -1 * $transaction->amount;

            if($user->affiliate_id) {
                $affiliate = User::find($user->affiliate_id);

                if ($affiliate) {
                    $this->commission($user, $affiliate, 'wallet_revenue_share', $amount, $transaction->hash);
                }
            }
        }
    }

    private function commission(User $user, User $affiliate, string $type, $amount, $hash)
    {
        $amount = $amount * $affiliate->affiliate_percent_revenue_share/100;

        $wallet = $affiliate->$type;

        $wallet->balance += $amount;
        $wallet->save();

        if($amount == 0){
            return;
        }

        if($amount >= 0){
            $type = 'credit';
        }else{
            $type = 'debit';
        }

        $user->transaction()->create([
            'hash' => $hash,
            'amount' => $amount,
            'name' => 'affiliate_revenue_share',
            'type' => $type,
            'status' => 'approved',
            'wallet_id' => $wallet->id,
            'user_id' => $affiliate->id,
        ]);

        if($affiliate->affiliate_id){
            $affiliateSub = User::find($affiliate->affiliate_id);

            if($affiliateSub){
                $this->commissionSub($affiliate, $affiliateSub, 'wallet_revenue_share', $amount, $hash);
            }
        }
    }

    private function commissionSub(User $user, User $affiliate, string $type, $amount , $hash)
    {
        $amount = $amount * $affiliate->affiliate_percent_revenue_share_sub/100;
        $wallet = $affiliate->$type;

        $wallet->balance += $amount;
        $wallet->save();

        if($amount == 0){
            return;
        }

        if($amount >= 0){
            $type = 'credit';
        }else{
            $type = 'debit';
        }

        $user->transaction()->create([
            'hash' => $hash,
            'amount' => $amount,
            'name' => 'affiliate_revenue_share',
            'type' => $type,
            'status' => 'approved',
            'wallet_id' => $wallet->id,
            'user_id' => $affiliate->id,
        ]);
    }
}
