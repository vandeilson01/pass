<?php

namespace App\Http\Resources\Admin;

use App\Models\Payment\Deposit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepositsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $deposit = new Deposit();

        $sumTotal = $deposit->whereNotNull('external_id')->where('status', 'approved')->sum('amount');
        $sumToday = $deposit->whereNotNull('external_id')->where('status', 'approved')->whereDate('created_at', now()->toDateString())->sum('amount');
        $sumYesterday = $deposit->whereNotNull('external_id')->where('status', 'approved')->whereDate('created_at', today()->subDay())->sum('amount');

        $sumLastThirtyDays = $deposit->whereNotNull('external_id')->where('status', 'approved')->whereBetween('created_at', [today()->subDays(30), today()->endOfDay()])->sum('amount');
        $sumPreviousThirtyDays = $deposit->whereNotNull('external_id')->where('status', 'approved')->whereBetween('created_at', [today()->subDays(60), today()->subDays(30)->endOfDay()])->sum('amount');
        $sumLastYear = $deposit->whereNotNull('external_id')->where('status', 'approved')->whereYear('created_at', now()->year)->sum('amount');

        return [
            'sum_total' => (int) $sumTotal,
            'sum_today' => (int) $sumToday,
            'sum_yesterday' => (int) $sumYesterday,
            'sum_last_thirty_days' => (int) $sumLastThirtyDays,
            'sum_previous_thirty_days' => (int) $sumPreviousThirtyDays,
            'sum_last_year' => (int) $sumLastYear,
        ];
    }
}
