<?php

namespace App\Services\Interfaces;

use App\Models\DatingCard;

interface DatingCardServiceContract
{
    public function store(array $fields): ?DatingCard;
}
