<?php

use App\Enum\PixKeyType;

if (!function_exists('sanitize_cpf')) {
    function sanitize_cpf(string|null $cpf): string
    {
        if (!is_string($cpf)) {
            return '';
        }

        return preg_replace('/[^0-9]/', '', $cpf);
    }
}

if (! function_exists('translate_pix_key_type')) {
    function translate_pix_key_type($pixKeyType): string
    {
        return match ($pixKeyType) {
            PixKeyType::Cpf->value => 'CPF',
            PixKeyType::Email->value => 'EMAIL',
            PixKeyType::Phone->value => 'TELEFONE',
            PixKeyType::Random->value => 'CHAVE_ALEATORIA',
        };
    }
}


