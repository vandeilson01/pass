<?php

namespace App\Http\Requests\Games\Mines;

use Illuminate\Foundation\Http\FormRequest;

class PlayGameRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'position' => 'required|integer|min:1|max:25'
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function messages()
    {
        return [
            'position.required' => 'Você deve informar a posição',
            'position.integer' => 'A posição deve ser um número inteiro',
            'position.min' => 'A posição deve ser entre 1 e 25',
            'position.max' => 'A posição deve ser entre 1 e 25',
        ];
    }
}
