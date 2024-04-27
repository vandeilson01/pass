<?php

namespace App\Http\Requests\Games\Double;

use Illuminate\Foundation\Http\FormRequest;

class AddBetGameRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'value_to_bet' => 'required|numeric|min:1',
            'color' => 'required|in:white,black,green',
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
            'color.required' => 'Selecione uma cor antes de iniciar sua aposta.',
            'color.in' => 'Selecione uma cor antes de iniciar sua aposta.',
        ];
    }
}
