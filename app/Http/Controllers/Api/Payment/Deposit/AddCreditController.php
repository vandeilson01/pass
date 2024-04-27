<?php

namespace App\Http\Controllers\Api\Payment\Deposit;

use App\Enum\TransactionStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\Deposit\AddCreditRequest;
use App\Models\Payment\Deposit;
use App\Models\SettingsGateway;
use App\Models\User;
use App\Services\Payment\GatewayService;
use Illuminate\Support\Str;

class AddCreditController extends Controller
{
    public function __invoke(AddCreditRequest $request)
    {
        $validated = $request->validated();
        $settingsGateway = SettingsGateway::where('is_active', true)->first();
        $user = User::with('wallet')->where('id', $validated['user_id'])->first();

        if(!$settingsGateway){
            return response()->json(['message' => 'Não foi possível encontrar um gateway ativo.'], 400);
        }

        $deposit = Deposit::create([
            'hash' => Str::uuid(),
            'status' => 'pending',
            'amount' => $validated['amount'],
            'currency' => 'brl',
            'has_bonus' => $validated['has_bonus'],
            'wallet_id' => $user->wallet->id,
            'user_id' => $validated['user_id'],
            'gateway_id' => $settingsGateway->gateway->id,
            'created_by' => auth()->user()->id,
        ]);

        if(!$deposit){
            return response()->json(['message' => 'Não foi possível criar o deposito.'], 400);
        }

        $qr_code = (new GatewayService($settingsGateway->gateway, $user))->createPixPayment($deposit);

        if(data_get($qr_code,'response_status', false) !== 200){
            $deposit->update([
                'status' => TransactionStatus::Error->value,
                'refused_reason' => data_get($qr_code,'message', '')
            ]);

            return response()->json(['message' => 'Não foi possível criar o QR Code, tente novamente!'], 400);
        }

        $deposit->update([
            'external_id' => $qr_code['external_id'],
            'pix_url' => $qr_code['pix_url'],
            'pix_qr_code' => $qr_code['pix_qr_code'],
        ]);        
        
        return response()->json([
            'message' => 'Deposito criado com sucesso!',
            'pix_url' => $deposit->pix_url,
            'pix_qr_code' => $deposit->pix_qr_code,
            'amount' => $deposit->amount,
        ], 201);
    }
}
