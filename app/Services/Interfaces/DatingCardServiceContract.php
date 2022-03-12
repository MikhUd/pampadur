<?php

namespace App\Services\Interfaces;

use App\Http\Requests\DatingCard\CreateDatingCardRequest;
use Illuminate\Http\JsonResponse;

interface DatingCardServiceContract
{
    public function store(CreateDatingCardRequest $request): JsonResponse;
}
