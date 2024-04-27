<?php

namespace App\Rules;

use App\Models\Gateway;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateRequiredCredentialsFieldsRule implements ValidationRule
{
    public function __construct(
        private int $gatewayId
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $gateway = Gateway::find($this->gatewayId);

        $fields = $gateway->fields;

        foreach ($fields as $field) {
            if (!array_key_exists($field, $value)) {
                $fail("O campo {$field} é obrigatório");
            }
        }
    }
}
