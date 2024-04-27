<?php

namespace App\Http\Controllers\Api\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;

class GetStatisticsController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::SUNDAY);

        $mainRevenueShareQuery = Transaction::where('user_id', $user->id)->where('name', 'affiliate_revenue_share')->where('status', 'approved');
        $mainCpaQuery = Transaction::where('user_id', $user->id)->where('name', 'affiliate_cpa')->where('status', 'approved');

        $wallet_cpa_total = with(clone $mainCpaQuery)->where('type', 'credit')->sum('amount');
        $wallet_cpa_available = with(clone $mainCpaQuery)->sum('amount');
        $commisions_cpa_today = with(clone $mainCpaQuery)->where('type', 'credit')->whereDate('created_at', today())->sum('amount');
        $commisions_cpa_weekly = with(clone $mainCpaQuery)->where('type', 'credit')->whereBetween('created_at', [$startOfWeek, $endOfWeek])->sum('amount');
        $commisions_cpa_monthly = with(clone $mainCpaQuery)->where('type', 'credit')->whereMonth('created_at', today()->month)->sum('amount');
        $commisions_cpa_total = with(clone $mainCpaQuery)->where('type', 'credit')->sum('amount');

        $wallet_revenue_share_total = with(clone $mainRevenueShareQuery)->sum('amount');
        $commissions_revenue_share_today = with(clone $mainRevenueShareQuery)->whereDate('created_at', today())->sum('amount');
        $commissions_revenue_share_weekly = with(clone $mainRevenueShareQuery)->whereBetween('created_at', [$startOfWeek, $endOfWeek])->sum('amount');
        $commissions_revenue_share_monthly = with(clone $mainRevenueShareQuery)->whereMonth('created_at', today()->month)->sum('amount');
        $commissions_revenue_share_total = with(clone $mainRevenueShareQuery)->sum('amount');

        $deposits_quantity = $user->affiliates()->with('deposits')->get()->sum(function ($affiliate) {
            return $affiliate->deposits->where('status', 'approved')->count();
        });

        $deposits_amount_total = $user->affiliates()->with('deposits')->get()->sum(function ($affiliate) {
            return $affiliate->deposits->where('status', 'approved')->sum('amount');
        });

        return [
            'wallet_cpa' => [
                'available' => (int) $wallet_cpa_available, //$user->wallet_cpa->balance,
                'total' => (int) $wallet_cpa_total,
                'value' => (int) $user->fake_affiliate_cpa,
            ],
            'wallet_revenue_share' => [
                'available' => (int) $user->wallet_revenue_share->balance,
                'total' => (int) $wallet_revenue_share_total,
                'value' => (int) $user->fake_affiliate_percent_revenue_share,
            ],
            'players' => [
                'total' => $user->affiliates()->count(),
                'today' => $user->affiliates()->whereDate('created_at', today())->count(),
                'weekly' => $user->affiliates()->whereBetween('created_at', [$startOfWeek, $endOfWeek])->count(),
                'monthly' => $user->affiliates()->whereMonth('created_at', today()->month)->count(),
            ],
            'commissions_cpa' => [
                'today' => (int) $commisions_cpa_today,
                'monthly' => (int) $commisions_cpa_monthly,
                'weekly' => (int) $commisions_cpa_weekly,
                'total' => (int) $commisions_cpa_total,
            ],
            'commissions_revenue_share' => [
                'today' => (int) $commissions_revenue_share_today,
                'monthly' => (int) $commissions_revenue_share_monthly,
                'weekly' => (int) $commissions_revenue_share_weekly,
                'total' => (int) $commissions_revenue_share_total,
            ],
            'commissions' => [
                'today' => (int) $commisions_cpa_today + (int) $commissions_revenue_share_today,
                'weekly' => (int) $commisions_cpa_weekly + (int) $commissions_revenue_share_weekly,
                'monthly' => (int) $commisions_cpa_monthly + (int) $commissions_revenue_share_monthly,
                'total' => (int) $commisions_cpa_total + (int) $commissions_revenue_share_total,
            ],
            'deposits' => [
                'quantity' => $deposits_quantity,
                'amount_total' => $deposits_amount_total,
            ],
        ];
    }
}
