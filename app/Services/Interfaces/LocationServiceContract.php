<?php

namespace App\Services\Interfaces;

interface LocationServiceContract
{
    public function getDistance(float $latitude1, float $longitude1, float $latitude2, float $longitude2): int;
}
