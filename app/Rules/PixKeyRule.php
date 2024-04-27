<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;
use LaravelLegends\PtBrValidator\Rules\Cpf;

class PixKeyRule implements ValidationRule
{


    public function __construct(private readonly string $pixKeyType = 'empty')
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        match ($this->pixKeyType) {
            'cpf' => $this->validateCpf($attribute, $value, $fail),
            'cnpj' => $this->validateCnpj($attribute, $value, $fail),
            'email' => $this->validateEmail($attribute, $value, $fail),
            'phone' => $this->validatePhone($attribute, $value, $fail),
            'random' => $this->validateRandom($attribute, $value, $fail),
            default => $fail('Tipo de chave pix inválida.')
        };
    }

    private function validateCpf(string $attribute, mixed $value, Closure $fail): void
    {

        if(preg_replace('/[^0-9]/','',auth()->user()->document) !== preg_replace('/[^0-9]/','', $value)){
            $fail('O CPF informado não é o mesmo do usuário.');
            return;
        }

        $c = preg_replace('/\D/', '', $value);

        if (strlen($c) != 11 || preg_match("/^{$c[0]}{11}$/", $c)) {
            $fail('O campo de CPF deve ser um CPF válido.');
            return;
        }

        for ($s = 10, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--);

        if ($c[9] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            $fail('O campo de CPF deve ser um CPF válido.');
            return;
        }

        for ($s = 11, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--);

        if ($c[10] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            $fail('O campo de CPF deve ser um CPF válido.');
            return;
        }
    }

    private function validateCnpj(string $attribute, mixed $value, Closure $fail): void
    {
        if(preg_replace('/[^0-9]/','',auth()->user()->document) !== preg_replace('/[^0-9]/','', $value)){
            $fail('O CNPJ informado não é o mesmo do usuário.');
            return;
        }

        $c = preg_replace('/\D/', '', $value);
        $b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        if (strlen($c) != 14) {
            $fail('O campo de CNPJ deve ser um CNPJ válido.');
            return;
        }

        // Remove sequências repetidas como "111111111111"
        // https://github.com/LaravelLegends/pt-br-validator/issues/4

        elseif (preg_match("/^{$c[0]}{14}$/", $c) > 0) {
            $fail('O campo de CNPJ deve ser um CNPJ válido.');
            return;
        }

        for ($i = 0, $n = 0; $i < 12; $n += $c[$i] * $b[++$i]);

        if ($c[12] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            $fail('O campo de CNPJ deve ser um CNPJ válido.');
            return;
        }

        for ($i = 0, $n = 0; $i <= 12; $n += $c[$i] * $b[$i++]);

        if ($c[13] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            $fail('O campo de CNPJ deve ser um CNPJ válido.');
            return;
        }
    }

    private function validateEmail(string $attribute, mixed $value, Closure $fail): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $fail('O campo de e-mail deve ser um e-mail válido.');
            return;
        }
    }

    private function validatePhone(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^\(\d{2}\)\s?\d{4,5}-\d{4}$/', $value) > 0) {
            $fail('O campo de telefone deve ser um telefone válido.');
            return;
        }
    }

    private function validateRandom(string $attribute, mixed $value, Closure $fail): void
    {
        return;
    }
}
