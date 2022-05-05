<?php

namespace App\Services\Interfaces;

use App\Http\Requests\Like\LikeRequest;
use Illuminate\Http\JsonResponse;

interface LikeServiceContract
{
    public function setLikeOrDislike(LikeRequest $request): JsonResponse;
}
