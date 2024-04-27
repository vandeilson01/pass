<?php

namespace App\Http\Requests\Admin\Configs\Gateways;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CreateAvailableGatewayRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'slug' => ['required', 'string'],
            'fields' => ['required', 'array'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório',
            'name.string' => 'O campo nome deve ser uma string',
            'slug.required' => 'O campo slug é obrigatório',
            'slug.string' => 'O campo slug deve ser uma string',
            'fields.required' => 'O campo fields é obrigatório',
            'fields.array' => 'O campo fields deve ser um array',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'fields' => $this->fields,
            'slug' => Str::slug($this->name)
        ]);
    }
}
