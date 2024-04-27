<?php

namespace App\Http\Requests\Account;

use App\Rules\PixKeyRule;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => [
                'sometimes',
                'email',
                'unique:users,email,'.auth()->user()->id,
                'max:255'
            ],
            'document' => [
                'sometimes',
                'cpf_ou_cnpj',
                'unique:users,document,'.auth()->user()->id
            ],
            'phone' => ['sometimes', 'celular_com_ddd'],
            'birth_date' => [
                'sometimes',
                'date_format:Y-m-d',
                'before:' . Carbon::now()->subYears(18)->format('Y-m-d')
            ],
            'pix_key_type' => [
                'sometimes',
                'in:'.implode(',', array_keys(\App\Models\User::PIX_TYPE))
            ],
            'pix_key' => [
                'sometimes',
                Rule::requiredIf(function () {
                    return $this->input('pix_key_type');
                }),
                new PixKeyRule($this->input('pix_key_type') ?? ''),
            ],
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function messages()
    {
        return [
            'name.string' => 'O campo de nome deve ser uma string.',
            'name.max' => 'O campo de nome deve ter no máximo :max caracteres.',
            'email.email' => 'O campo de e-mail deve ser um e-mail válido.',
            'email.unique' => 'O e-mail informado já está em uso.',
            'email.max' => 'O campo de e-mail deve ter no máximo :max caracteres.',
            'document.cpf_ou_cnpj' => 'O campo de documento deve ser um CPF ou CNPJ válido.',
            'document.unique' => 'O documento informado já está em uso.',
            'phone.celular_com_ddd' => 'O campo de telefone deve ser um telefone válido.',
            'birth_date.date_format' => 'O campo de data de nascimento deve ser uma data válida.',
            'birth_date.before' => 'O campo de data de nascimento deve ser anterior a :date.',
            'pix_key_type.in' => 'O tipo de chave pix deve ser um dos seguintes valores: :values.',
            'pix_key.required_if' => 'O campo de chave pix é obrigatório quando o tipo de chave pix é informado.',
            'pix_key.string' => 'O campo de chave pix deve ser uma string.',
        ];
    }
}
