<?php

namespace App\Http\Requests\Admin\Roles;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRolesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|unique:roles,name,' . $this->role->id,
            'name' => 'required|string',
            'permissions' => 'required|array',
            'permissions.*' => 'required|string|exists:permissions,name',
            'guard_name' => 'string'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'O campo título é obrigatório.',
            'title.string' => 'O campo título deve ser uma string.',
            'title.unique' => 'O campo título deve ser único.',
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'permissions.required' => 'O campo permissões é obrigatório.',
            'permissions.array' => 'O campo permissões deve ser um array.',
            'permissions.*.required' => 'O campo permissões é obrigatório.',
            'permissions.*.string' => 'O campo permissões deve ser uma string.',
            'permissions.*.exists' => 'O campo permissões deve existir na tabela permissions.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'name' => strtolower($this->name),
            'guard_name' => 'web'
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }
}
