<?php

namespace App\Services\Interfaces;

use App\Http\Requests\Like\LikeRequest;
use Illuminate\Http\JsonResponse;

interface LikeServiceContract
{
    /**
     * Добавление лайка/дизлайка на анкету.
     *
     * @param LikeRequest $request
     * @return JsonResponse
     */
    public function createLike(LikeRequest $request): JsonResponse;
}
