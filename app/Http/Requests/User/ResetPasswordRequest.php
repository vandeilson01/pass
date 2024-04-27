<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'password' => 'required|confirmed|min:8',
            'token' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'token.required' => 'Token está Inválido ou Expirado!',
            'password.required' => 'O campo de senha é obrigatório.',
            'password.confirmed' => 'A confirmação da senha não corresponde',
            'password.min' => 'A senha deve ter pelo menos :min caracteres.',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
