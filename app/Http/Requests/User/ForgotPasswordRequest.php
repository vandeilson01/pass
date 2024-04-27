<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'O campo de e-mail é obrigatório.',
            'email.email' => 'O campo de e-mail deve ser um e-mail válido.',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
