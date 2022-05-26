<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

interface FilterRepositoryContract
{
    public function processingDatingCardFilters(Builder $query, array $filters): Collection;
}