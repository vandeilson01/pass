<?php

namespace App\Filters;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Spatie\QueryBuilder\Filters\Filter;

class FilterBetweenDates implements Filter
{
    public function __invoke(Builder $query, $value, $property): Builder
    {
        $startDate = Carbon::createFromFormat('Y-m-d', $value['from'])->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $value['to'])->endOfDay();

        return $query->whereBetween($property, [$startDate, $endDate]);
    }
}
