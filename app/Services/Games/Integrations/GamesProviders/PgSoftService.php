<?php

namespace App\Services\Games\Integrations\GamesProviders;

use GuzzleHttp\Client;
use http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PgSoftService
{
    private $baseUrl;
    private $operator_token;
    private $secret_key;
    private $salt;
    private $name;

    public function __construct(public string $gameId = '1')
    {
        // $this->baseUrl = 'https://api.pg-bo.me';
        $this->baseUrl = env('PG_BASE_URL');
        $this->operator_token = env('PG_OPERATOR_TOKEN');
        $this->secret_key = env('PG_SECRET_KEY');
        $this->salt = env('PG_SALT');
        $this->name = env('PG_NAME');
    }

    public function generateGameUrl(string $ops)
    {
        return $this->baseUrl . '/' . $this->gameId . '/index.html?ot=' . $this->operator_token . '&ops=' . $ops . '&btt=1';
    }

    public function getGameList()
    {
        try {
            $client = new Client();
            $headers = [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ];
            $options = [
                'form_params' => [
                    'operator_token' => '795f1791e4a756a69ffeb02cbea430de',
                    'secret_key' => '95f743c2afda06446417ac41d25bd5f8',
                    'currency' => 'BRL',
                    'status' => '1',
                ],
            ];
            $request = $client->request('POST', 'https://api.pg-bo.me/external/Game/v2/Get?trace_id=' . Str::uuid(), $headers);
            $res = $client->sendAsync($request, $options)->wait();
            return $res->getBody();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
