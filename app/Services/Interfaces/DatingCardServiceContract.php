<?php

namespace App\Services\Interfaces;

use App\Http\Requests\DatingCard\CreateDatingCardRequest;
use App\Http\Requests\DatingCard\UpdateDatingCardRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

interface DatingCardServiceContract
{
    public function store(CreateDatingCardRequest $request): JsonResponse;

    public function update(UpdateDatingCardRequest $request): JsonResponse;

    public function getCardsWithReciprocalLikes(Request $request): JsonResponse;

    public function getCardsToAssess(Request $request): JsonResponse;
}
