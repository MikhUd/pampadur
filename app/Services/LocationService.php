<?php

namespace App\Services;

use App\Services\Interfaces\LocationServiceContract;

class LocationService implements LocationServiceContract
{
    const EARTH_RADIUS = 6371000;

    /**
     * Нахождение дистанции в км по координатам.
     *
     * @return void
     */
    public function getDistance(float $latitude1, float $longitude1, float $latitude2, float $longitude2): int
    {
        $latitude1 = $latitude1 * M_PI / 180;
        $latitude2 = $latitude2 * M_PI / 180;
        $longitude1 = $longitude1 * M_PI / 180;
        $longitude2 = $longitude2 * M_PI / 180;

        $cl1 = cos($latitude1);
        $cl2 = cos($latitude2);
        $sl1 = sin($latitude1);
        $sl2 = sin($latitude2);
        $delta = $longitude2 - $longitude1;
        $cdelta = cos($delta);
        $sdelta = sin($delta);

        $y = sqrt(pow($cl2 * $sdelta, 2) + pow($cl1 * $sl2 - $sl1 * $cl2 * $cdelta, 2));
        $x = $sl1 * $sl2 + $cl1 * $cl2 * $cdelta;

        return round(atan2($y, $x) / 1000 * self::EARTH_RADIUS);
    }
}
