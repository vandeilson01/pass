<?php
// app/Filters/FilterAffiliateRole.php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterAffiliateRole implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        if ($value) {
            return $query->whereHas('roles', function ($q) {
                $q->where('name', 'affiliate');
            });
        }

        return $query;
    }
}
