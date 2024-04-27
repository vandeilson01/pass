<?php

namespace App\Services\Payment;

use App\Enum\GatewayType;
use App\Models\Gateway;
use App\Models\Payment\Cashout;
use App\Models\Payment\Deposit;
use App\Models\User;
use App\Services\Payment\Gateways\EzzeBankService;

class GatewayService
{

    public function __construct(
        public Gateway $gateway,
        public User | null $user = null
    )
    {
    }

    public function createPixPayment(Deposit $deposit)
    {
        $serviceClass = $this->getGatewayClass($this->gateway->slug);
        return (new $serviceClass($this->gateway, $this->user))->generateQrCode($deposit);
    }

    public function getStatusDeposit(string|int $transactionId)
    {
        $serviceClass = $this->getGatewayClass($this->gateway->slug);
        return (new $serviceClass($this->gateway))->getStatusDeposit($transactionId);
    }

    public function validateReturn()
    {
        $serviceClass = $this->getGatewayClass($this->gateway->slug);
        return (new $serviceClass($this->gateway))->validateReturn();
    }

    public function sendPayment(Cashout $cashout)
    {
        $serviceClass = $this->getGatewayClass($this->gateway->slug);
        return (new $serviceClass($this->gateway))->sendPayment($cashout);
    }

    public function getPaymentStatus(string|int $transactionId)
    {
        $serviceClass = $this->getGatewayClass($this->gateway->slug);
        return (new $serviceClass($this->gateway))->getPaymentStatus($transactionId);
    }

    private function getGatewayClass(string $gatewayType): string|bool
    {
        return match ($gatewayType) {
            GatewayType::EzzeBank->value => EzzeBankService::class,
            default => 'false'
        };
    }

}
