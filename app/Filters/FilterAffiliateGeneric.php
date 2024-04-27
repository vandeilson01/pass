<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterAffiliateGeneric implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->where(function ($q) use ($value) {
            $q->where('username', 'LIKE', "%" . $value . "%")
                ->orWhere('name', 'LIKE', "%" . $value . "%")
                ->orWhere('email', 'LIKE', "%" . $value . "%")
                ->orWhere('document', 'LIKE', "%" . $value . "%")
                ->orWhere('phone', 'LIKE', "%" . $value . "%")
                ->orWhere('id', '=', $value)
                ->orWhere('ref_code', 'LIKE', "%" . $value . "%");
        });
    }
}
