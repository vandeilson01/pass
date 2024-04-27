<?php

namespace App\Rules;

use App\Models\Gateway;
use App\Models\SettingsGateway;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateActiveGatewayRule implements ValidationRule
{
    public function __construct(
        private int $gatewayId
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ((boolean)$value === false) {

            $activeSettingsGateway = SettingsGateway::where('is_active', true)->get();

            if ($activeSettingsGateway->count() === 1 && $activeSettingsGateway->first()->gateway_id === $this->gatewayId) {
                $gateway = Gateway::find($this->gatewayId);
                $fail("O gateway {$gateway->name} é o único gateway ativo, não é possível desativá-lo");
            }
        }
    }
}
