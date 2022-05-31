<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

interface FilterRepositoryContract
{
    /**
     * Обработка фильтров на анкету.
     *
     * @param Builder $query
     * @param array $filters
     * @return Collection
     */
    public function processingDatingCardFilters(Builder $query, array $filters): Collection;
}