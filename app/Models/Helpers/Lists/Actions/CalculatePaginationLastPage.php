<?php

namespace App\Models\Helpers\Lists\Actions;

use Illuminate\Database\Eloquent\Builder;

class CalculatePaginationLastPage
{
    public static function fromQuery(Builder $query, int $limit): int
    {
        $limit = (in_array($limit, config('snappy.pagination.limits')))
            ? $limit
            : config('snappy.pagination.limits.fifty');

        return ceil($query->count() / $limit);
    }
}
