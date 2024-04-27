<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class ImpersonateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
        ];
    }

    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('admin');
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'O campo de usuário é obrigatório.',
            'user_id.exists' => 'O usuário informado não existe.',
        ];
    }
}
