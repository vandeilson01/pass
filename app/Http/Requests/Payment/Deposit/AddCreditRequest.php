<?php

namespace App\Http\Requests\Payment\Deposit;

use Illuminate\Foundation\Http\FormRequest;

class AddCreditRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1000',
            'has_bonus' => 'required|boolean',
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => $this->has('user_id') ? $this->user_id : auth()->user()->id,
            'has_bonus' => $this->has('has_bonus') ? filter_var($this->has_bonus, FILTER_VALIDATE_BOOLEAN) : false,
        ]);
    }
    public function messages(): array
    {
        return [
            'amount.min' => 'O Valor mínimo para depósito é de R$ 10,00',
        ];
    }
}
