<?php

namespace App\Http\Controllers\Api\Payment\Cashout;

use App\Enum\TransactionStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\Cashout\RequestCashoutRequest;
use App\Models\Gateway;
use App\Models\Payment\Cashout;
use App\Models\SettingsGateway;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RequestCashoutController extends Controller
{
    public function __invoke(RequestCashoutRequest $request)
    {
        $validated = $request->validated();
        $user = User::find($validated['user_id']);
        $wallet = Wallet::find($validated['wallet_id']);
        $activeGateway = SettingsGateway::where('is_active', true)->first();

        if (!$activeGateway) {
            return response()->json(['message' => 'Não há gateway de pagamento ativo. Entre em contato com o suporte.'], 400);
        }

        $verifyPendingCashout = Cashout::query()
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists();

        if ($verifyPendingCashout) {
            return response()->json(['message' => 'Você já possui um pedido de saque em andamento.'], 400);
        }

        if (!Carbon::now()->isMonday() && $wallet->type === 'affiliate_cpa') {
            return response()->json(['message' => 'Você só pode fazer saques do tipo CPA às segundas-feiras.'], 400);
        }

        $cashout = Cashout::create([
            'hash' => Str::uuid(),
            'status' => TransactionStatus::Pending->value,
            'amount' => $validated['amount'],
            'pix_key' => $user->pix_key,
            'pix_key_type' => $user->pix_key_type,
            'gateway_id' => $activeGateway->id,
            'user_id' => $user->id,
            'wallet_id' => $wallet->id
        ]);

        if (!$cashout) {
            return response()->json(['message' => 'Não foi possível criar o pedido de saque.'], 400);
        }

        if (
            $user->hasRole('fake') ||
            $user->hasRole('youtuber') ||
            $user->hasRole('moderator') ||
            $user->hasRole('admin')
        ) {
            $cashout->update([
                'status' => TransactionStatus::Approved->value,
                'gateway_id' => SettingsGateway::find(Gateway::where('slug', 'manual')->first()->id)->id,
                'approved_by' => $user->id,
            ]);
        }

        return response()->json([
            'message' => 'Pedido de saque criado com sucesso!',
        ], 201);
    }
}
