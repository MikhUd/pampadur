<?php

namespace App\Services;

use App\Models\DatingCard;
use App\Services\Interfaces\DatingCardServiceContract;

class DatingCardService implements DatingCardServiceContract
{

    public function __construct()
    {

    }

    public function store(array $fields): ?DatingCard
    {
        return null;
    }

}
