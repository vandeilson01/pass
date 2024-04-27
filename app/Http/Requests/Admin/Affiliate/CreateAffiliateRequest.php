<?php

namespace App\Http\Requests\Admin\Affiliate;

use App\Enum\PixKeyType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;

class CreateAffiliateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'document' => 'required|cpf_ou_cnpj|unique:users,document',
            'phone' => 'sometimes|celular_com_ddd',
            'username' => 'sometimes|string|max:255|unique:users,username',
            'ref_code' => 'sometimes|string|max:255|unique:users,ref_code',
            'affiliate_id' => 'sometimes|nullable|exists:users,id',
            'affiliate_percent_revenue_share' => 'required|integer',
            'affiliate_percent_revenue_share_sub' => 'required|integer',
            'affiliate_cpa' => 'required|integer',
            'affiliate_cpa_sub' => 'required|integer',
            'affiliate_min_deposit_cpa' => 'required|integer',
            'fake_affiliate_percent_revenue_share' => 'required|integer',
            'fake_affiliate_percent_revenue_share_sub' => 'required|integer',
            'fake_affiliate_cpa' => 'required|integer',
            'fake_affiliate_cpa_sub' => 'required|integer',
            'fake_affiliate_min_deposit_cpa' => 'required|integer',
            'password' => 'required|string|min:6|max:255',
            'roles' => 'required|array',
            'roles.*' => 'required|exists:roles,name',
            'pix_key' => 'required|string|max:255',
            'pix_key_type' => ['required', new Enum(PixKeyType::class)],
        ];
    }

    function messages()
    {
        return [
            'name.required' => 'O campo de nome é obrigatório.',
            'name.string' => 'O campo de nome deve ser uma string.',
            'name.max' => 'O campo de nome deve ter no máximo :max caracteres.',
            'email.required' => 'O campo de e-mail é obrigatório.',
            'email.email' => 'O campo de e-mail deve ser um e-mail válido.',
            'email.unique' => 'O e-mail informado já está em uso.',
            'email.max' => 'O campo de e-mail deve ter no máximo :max caracteres.',
            'document.required' => 'O campo de documento é obrigatório.',
            'document.cpf_ou_cnpj' => 'O campo de documento deve ser um CPF ou CNPJ válido.',
            'document.unique' => 'O documento informado já está em uso.',
            'phone.celular_com_ddd' => 'O campo de telefone deve ser um telefone válido.',
            'affiliate_percent_revenue_share.required' => 'O campo de percentual de revenue share é obrigatório.',
            'affiliate_percent_revenue_share.integer' => 'O campo de percentual de revenue share deve ser um inteiro.',
            'affiliate_percent_revenue_share_sub.required' => 'O campo de percentual de revenue share sub é obrigatório.',
            'affiliate_percent_revenue_share_sub.integer' => 'O campo de percentual de revenue share sub deve ser um inteiro.',
            'affiliate_cpa.required' => 'O campo de CPA é obrigatório.',
            'affiliate_cpa.integer' => 'O campo de CPA deve ser um inteiro.',
            'affiliate_cpa_sub.required' => 'O campo de CPA sub é obrigatório.',
            'affiliate_cpa_sub.integer' => 'O campo de CPA sub deve ser um inteiro.',
            'affiliate_min_deposit_cpa.required' => 'O campo de depósito mínimo é obrigatório.',
            'affiliate_min_deposit_cpa.integer' => 'O campo de depósito mínimo deve ser um inteiro.',
            'fake_affiliate_percent_revenue_share.required' => 'O campo de percentual de revenue share é obrigatório.',
            'fake_affiliate_percent_revenue_share.integer' => 'O campo de percentual de revenue share deve ser um inteiro.',
            'fake_affiliate_percent_revenue_share_sub.required' => 'O campo de percentual de revenue share sub é obrigatório.',
            'fake_affiliate_percent_revenue_share_sub.integer' => 'O campo de percentual de revenue share sub deve ser um inteiro.',
            'fake_affiliate_cpa.required' => 'O campo de CPA é obrigatório.',
            'fake_affiliate_cpa.integer' => 'O campo de CPA deve ser um inteiro.',
            'fake_affiliate_cpa_sub.required' => 'O campo de CPA sub é obrigatório.',
            'fake_affiliate_cpa_sub.integer' => 'O campo de CPA sub deve ser um integer.',
            'fake_affiliate_min_deposit_cpa.required' => 'O campo de depósito mínimo é obrigatório.',
            'fake_affiliate_min_deposit_cpa.integer' => 'O campo de depósito mínimo deve ser um inteiro.',
            'roles.required' => 'O campo de perfis é obrigatório.',
            'roles.array' => 'O campo de perfis deve ser um array.',
            'roles.*.required' => 'O campo de perfis é obrigatório.',
            'roles.*.exists' => 'O perfil informado não existe.',
            'pix_key.required' => 'O campo de chave PIX é obrigatório.',
            'pix_key.string' => 'O campo de chave PIX deve ser uma string.',
            'pix_key.max' => 'O campo de chave PIX deve ter no máximo :max caracteres.',
            'pix_key_type.required' => 'O campo de tipo de chave PIX é obrigatório.',
            'pix_key_type.enum' => 'O campo de tipo de chave PIX deve ser um dos seguintes valores: :values.',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'ref_code' => Str::upper(Str::random(10)),
            'username' => Str::lower(Str::random()),
            'password' => Str::random(10),
        ]);
    }
}
