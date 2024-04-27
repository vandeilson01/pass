<?php

namespace App\Http\Resources\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetUsersStatisticsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $users = new User();

        $total = $users->where('is_fake', false)->count();
        $totalToday = $users->where('is_fake', false)->whereDate('created_at', today())->count();
        $totalYesterday = $users->where('is_fake', false)->whereDate('created_at', today()->subDay())->count();
        $totalThisWeek = $users->where('is_fake', false)->whereBetween('created_at', [today()->startOfWeek(), today()->endOfWeek()])->count();
        $totalPreviousWeek = $users->where('is_fake', false)->whereBetween('created_at', [today()->startOfWeek()->subWeek(), today()->endOfWeek()->subWeek()])->count();
        $totalLastThirtyDays = $users->where('is_fake', false)->whereBetween('created_at', [today()->subDays(30), today()->endOfDay()])->count();
        $totalPreviousThirtyDays = $users->where('is_fake', false)->whereBetween('created_at', [today()->subDays(60), today()->subDays(30)])->count();

        return [
            'total' => $total,
            'total_today' => $totalToday,
            'total_yesterday' => $totalYesterday,
            'total_this_week' => $totalThisWeek,
            'total_previous_week' => $totalPreviousWeek,
            'total_last_thirdy_days' => $totalLastThirtyDays,
            'total_previous_thirty_days' => $totalPreviousThirtyDays,
        ];
    }
}
