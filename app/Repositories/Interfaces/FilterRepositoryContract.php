<?php

namespace App\Repositories\Interfaces;
use Illuminate\Database\Eloquent\Builder;

interface FilterRepositoryContract
{
    public function processingDatingCardFilters(Builder $query, array $filters): Builder;
}