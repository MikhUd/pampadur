<?php

namespace App\Traits\Repositories;

use Illuminate\Database\Query\Builder;

trait CanFilterQuery
{
    /**
     * Применяет переданные фильтры к запросу
     *
     * @param Builder $query
     * @param array $filters
     * @return Builder
     */
    private function filter(Builder &$query, array $filters): Builder
    {
        foreach ($filters as $filter => $value) {
            $query->where($filter, $value);
        }

        return $query;
    }
}
