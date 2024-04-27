<?php

namespace App\Services\Payment\Gateways;

use App\Enum\TransactionStatus;
use App\Models\Gateway;
use App\Models\Payment\Deposit;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class EzzeBankService
{
    private string $baseUrl;
    private string $client_id;
    private string $client_secret;

    public function __construct(
        public Gateway $gateway,
        public User | null $user = null
    )
    {
        $this->baseUrl = env('APP_ENV') === 'local' ? 'https://api-sandbox.ezzebank.com/v2' : 'https://api.ezzebank.com/v2' ;
        $settings = $this->gateway->settings()->where('is_active', true)->first();

        $this->client_id = data_get($settings, 'credentials.client_id');
        $this->client_secret = data_get($settings, 'credentials.client_secret');
    }

    private function validate(): bool|string
    {
        if(!$this->client_id || !$this->client_secret){
            return false;
        }

        $client = new Client();

        try {
            $response = $client->post($this->baseUrl . '/oauth/token', [
                'auth' => [$this->client_id, $this->client_secret],
                'form_params' => [
                    'grant_type' => 'client_credentials',
                ]
            ]);
            return json_decode((string) $response->getBody(), true)['access_token'];

        } catch (GuzzleException $e) {
            return $e->getMessage();
        }

    }

    public function generateQrCode(
        Deposit $deposit
    ): array|bool
    {
        $bearer_token = $this->validate();

        if(!$bearer_token){
            return false;
        }

        try {
            $client = new Client();

            $response = $client->request('POST', $this->baseUrl.'/pix/qrcode', [
                'headers' => [
                    'Authorization' => 'Bearer '.$bearer_token,
                ],
                'json' => [
                    "amount" => $deposit->amount/100,
                    "payerQuestion" => "Deposito $".$deposit->id." - R$".$deposit->amount/100,
                    "external_id" => $deposit->id,
                    "payer" => [
                        "name" => $this->user->name,
                        "document" => preg_replace('/[^0-9]/','',$this->user->document),
                    ],
                ]
            ]);

            $data = json_decode((string) $response->getBody()->getContents(), true);


            return [
                'response_status' => $response->getStatusCode(),
                'pix_url' => $data['emvqrcps'],
                'pix_qr_code' => $data['base64image'],
                'external_id' => $data['transactionId'],
            ];
        }catch (\Exception $e ){
            return [
                'response_status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    public function getStatusDeposit(string $transactionId): bool|array
    {
        $bearer_token = $this->validate();

        if(!$bearer_token){
            return false;
        }

        try {
            $client = new Client();

            $response = $client->request('GET', $this->baseUrl.'/pix/qrcode/'.$transactionId.'/detail', [
                'headers' => [
                    'Authorization' => 'Bearer '.$bearer_token,
                ],
            ]);

            $data = json_decode((string) $response->getBody()->getContents(), true);

            $status = match ($data['status']) {
                'PENDING' => TransactionStatus::Pending->value,
                'APPROVED' => TransactionStatus::Approved->value,
                'EXPIRED' => TransactionStatus::Expired->value,
                'RETURNED' => TransactionStatus::Refused->value,
                default => TransactionStatus::Processing->value,
            };

            if(env('APP_ENV') === 'local'){
                $status = TransactionStatus::Approved->value;
            }

            return [
                'response_status' => $response->getStatusCode(),
                'status' => $status,
                'amount' => number_format(($data['amountPaid'] ?? $data['originalValue']), 2, '', ''),
            ];
        }catch (\Exception $e ){
            return [
                'response_status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    public function getPaymentStatus(string $transactionId): bool|array
    {
        $bearer_token = $this->validate();

        if(!$bearer_token){
            return false;
        }

        try {
            $client = new Client();

            $response = $client->request('GET', $this->baseUrl.'/pix/payment/'.$transactionId.'/status', [
                'headers' => [
                    'Authorization' => 'Bearer '.$bearer_token,
                ],
            ]);

            $data = json_decode((string) $response->getBody()->getContents(), true);

            $status = match ($data['status']) {
                'PEND_CONFIRM' => TransactionStatus::Pending->value,
                'CONFIRMED' => TransactionStatus::Approved->value,
                'CANCELED', 'RETURNED' => TransactionStatus::Refused->value,
                'ERROR' => TransactionStatus::Error->value,
                default => TransactionStatus::Processing->value,
            };

            if(env('APP_ENV') === 'local'){
                $status = TransactionStatus::Approved->value;
            }

            return [
                'response_status' => $response->getStatusCode(),
                'status' => $status,
            ];

        }catch (\GuzzleHttp\Exception\ClientException $e ){
            return [
                'response_status' => $e->getCode(),
                'message' => data_get(json_decode($e->getResponse()->getBody()->getContents()), 'message'),
            ];
        }
    }

    public function sendPayment($cashout)
    {
        $bearer_token = $this->validate();

        if(!$bearer_token){
            return false;
        }

        match ($cashout->pix_key_type) {
            'cpf' => $cashout->pix_key = sanitize_cpf($cashout->pix_key),
            'phone' => $cashout->pix_key = '+55'. preg_replace('/[^0-9]/','',$cashout->pix_key),
            default => $cashout->pix_key,
        };

        $cashout->pix_key_type = translate_pix_key_type($cashout->pix_key_type);

        try {
            $client = new Client();

            $response = $client->request('POST', $this->baseUrl.'/pix/payment', [
                'headers' => [
                    'Authorization' => 'Bearer '.$bearer_token,
                ],
                'json' => [
                    "amount" => $cashout->amount/100,
                    "description" => "Saque " . env('APP_NAME'),
                    "external_id" => $cashout->id,
                    "creditParty" => [
                        "name" => $cashout->user->name,
                        "keyType" => $cashout->pix_key_type,
                        "key" => $cashout->pix_key,
                        "taxId" => sanitize_cpf($cashout->user->document)
                    ],
                ]
            ]);

            $data = json_decode((string) $response->getBody()->getContents(), true);

            $status = match ($data['status']) {
                'PROCESSING' => TransactionStatus::Pending->value,
                'EXPIRED' => TransactionStatus::Expired->value,
                'RETURNED' => TransactionStatus::Refused->value,
                'PEND_CONFIRM' => TransactionStatus::WaitingPayment->value,
                'CONFIRMED' => TransactionStatus::Approved->value,
                'ERROR' => TransactionStatus::Error->value,
                'CANCELED' => TransactionStatus::Canceled->value,
                default => TransactionStatus::Processing->value,
            };

            return [
                'response_status' => $response->getStatusCode(),
                'external_id' => $data['transactionId'],
                'status' => $status,
            ];

        }catch (\GuzzleHttp\Exception\ClientException $e ){
            return [
                'response_status' => $e->getCode(),
                'message' => data_get(json_decode($e->getResponse()->getBody()->getContents()), 'message'),
            ];
        }
    }

    public function validateReturn(): bool | array
    {
        $request = request()->all();
        $transactionType = $request['requestBody']['transactionType'];
        $transactionId = $request['requestBody']['transactionId'];

        if ($transactionType === 'RECEIVEPIX') {
            return [
                ...$this->getStatusDeposit($transactionId),
                'external_id' => $transactionId,
            ];
        }

        if ($transactionType === 'PAYMENT') {
            return [
                ...$this->getPaymentStatus($transactionId),
                'external_id' => $transactionId,
            ];
        }

        return false;
    }
}
