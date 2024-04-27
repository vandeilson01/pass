<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function messages()
    {
        return [
            'current_password.required' => 'O campo senha atual é obrigatório',
            'current_password.string' => 'O campo senha atual deve ser uma string',
            'password.required' => 'O campo senha é obrigatório',
            'password.string' => 'O campo senha deve ser uma string',
            'password.min' => 'O campo senha deve ter no mínimo 8 caracteres',
            'password.confirmed' => 'O campo senha não confere com o campo confirmação de senha',
        ];
    }

}
