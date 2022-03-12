<?php

namespace App\Services\Interfaces;

use App\Http\Requests\DatingCard\CreateDatingCardRequest;
use App\Models\DatingCard;

interface DatingCardServiceContract
{
    public function store(CreateDatingCardRequest $request): ?DatingCard;
}
