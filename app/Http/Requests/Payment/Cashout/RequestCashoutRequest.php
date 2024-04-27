<?php

namespace App\Http\Requests\Payment\Cashout;

use App\Rules\CashoutMinRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RequestCashoutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'wallet_id' => [
                'required',
                Rule::exists('wallets', 'id')->where('user_id', $this->user_id)
            ],
            'amount' => [
                'required',
                'numeric',
                new CashoutMinRule($this->input('user_id'), $this->input('wallet_id')),
            ],
        ];
    }

    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->id == $this->user_id;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => $this->has('user_id') ? $this->user_id : auth()->user()->id,
        ]);
    }

    public function messages(): array
    {
        return [
            'wallet_id.exists' => 'Carteira inválida.',
        ];
    }
}
