<?php

namespace App\Repositories\Interfaces;

interface FilterRepositoryContract
{
    public function processingDatingCardFilters(array $filters): void;
    public function processingUserFilters(array $filters): void;
}