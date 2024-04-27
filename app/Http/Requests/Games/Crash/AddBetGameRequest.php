<?php

namespace App\Http\Requests\Games\Crash;

use Illuminate\Foundation\Http\FormRequest;

class AddBetGameRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'value_to_bet' => 'required|numeric|min:1',
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function messages(): array
    {
        return [
            'value_to_bet.required' => 'Insira um valor antes de iniciar sua aposta.',
            'value_to_bet.numeric' => 'Insira um valor antes de iniciar sua aposta.',
            'value_to_bet.min' => 'Insira um valor antes de iniciar sua aposta.',
        ];
    }
}
