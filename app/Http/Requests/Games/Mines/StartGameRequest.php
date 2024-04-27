<?php

namespace App\Http\Requests\Games\Mines;

use Illuminate\Foundation\Http\FormRequest;

class StartGameRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'value_to_bet' => 'required|numeric|min:1',
            'number_of_bombs' => 'required|numeric|min:2|max:24',
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
            'number_of_bombs.required' => 'Digite o número correto de bombas',
            'number_of_bombs.numeric' => 'Digite o número correto de bombas',
            'number_of_bombs.min' => 'Digite o número correto de bombas',
            'number_of_bombs.max' => 'Digite o número correto de bombas',
        ];
    }
}
