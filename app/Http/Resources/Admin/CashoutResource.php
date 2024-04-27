<?php

namespace App\Http\Resources\Admin;

use App\Models\Payment\Cashout;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

class CashoutResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $cashout = new Cashout();

        $sumTotal = $cashout->whereNotNull('external_id')->where('status', 'approved')->sum('amount');
        $sumToday = $cashout->whereNotNull('external_id')->where('status', 'approved')->whereDate('created_at', now()->toDateString())->sum('amount');
        $sumYesterday = $cashout->whereNotNull('external_id')->where('status', 'approved')->whereDate('created_at', today()->subDay())->sum('amount');
        $sumLastThirtyDays = $cashout->whereNotNull('external_id')->where('status', 'approved')->whereBetween('created_at', [today()->subDays(30), today()])->sum('amount');
        $sumPreviousThirtyDays = $cashout->whereNotNull('external_id')->where('status', 'approved')->whereBetween('created_at', [today()->subDays(60), today()->subDays(30)])->sum('amount');
        $sumLastYear = $cashout->whereNotNull('external_id')->where('status', 'approved')->whereYear('created_at', now()->year)->sum('amount');

        return [
            'sum_total' => (int) $sumTotal,
            'sum_today' => (int) $sumToday,
            'sum_yesterday' => (int)  $sumYesterday,
            'sum_last_thirty_days' => (int) $sumLastThirtyDays,
            'sum_previous_thirty_days' => (int) $sumPreviousThirtyDays,
            'sum_last_year' => (int) $sumLastYear,
        ];
    }
}
