<?php

namespace App\Repositories\Interfaces;

use App\Models\DatingCard;

interface DatingCardRepositoryContract
{
    public function create(array $fields): DatingCard;
}
