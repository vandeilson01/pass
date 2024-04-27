<?php

namespace App\Http\Requests\Admin\Permissions;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'O campo título é obrigatório.',
            'title.string' => 'O campo título deve ser uma string.',
            'title.max' => 'O campo título deve ter no máximo 255 caracteres.',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
