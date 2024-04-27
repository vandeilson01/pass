<?php

namespace App\Rules;

use App\Models\Wallet;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CashoutMinRule implements ValidationRule
{

    public function __construct(
        private $user_id,
        private $wallet_id
    )
    {
    }


    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $wallet = Wallet::query()
            ->where('user_id', $this->user_id)
            ->where('id', $this->wallet_id)
            ->first();

        if(!$wallet){
            $fail('Carteira inválida.');
            return;
        }

        if($wallet->balance < $value){
            $fail('O valor solicitado é maior que o saldo disponível.');
            return;
        }

        if($value < $wallet->min_cashout_amount){
            $fail('O valor solicitado é menor que o valor mínimo para saque.');
            return;
        }

        $max_cashout_amount = $wallet->max_cashout_amount == 0 ? $wallet->balance : $wallet->max_cashout_amount;

        if($value > $max_cashout_amount){
            $fail('O valor solicitado é maior que o valor máximo para saque.');
            return;
        }
    }
}
