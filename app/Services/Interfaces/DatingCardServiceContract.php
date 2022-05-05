<?php

namespace App\Services\Interfaces;

use App\Http\Requests\DatingCard\CreateDatingCardRequest;
use App\Http\Requests\DatingCard\UpdateDatingCardRequest;
use Illuminate\Http\JsonResponse;

interface DatingCardServiceContract
{
    public function store(CreateDatingCardRequest $request): JsonResponse;

    public function update(UpdateDatingCardRequest $request): JsonResponse;
}
