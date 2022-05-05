<?php

namespace App\Http\Controllers\DatingCard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Like\LikeRequest;
use App\Services\Interfaces\LikeServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function __construct(
        private LikeServiceContract $likeService
    ) {}

    public function setLikeOrDislike(LikeRequest $request): JsonResponse
    {
        return $this->likeService->setLikeOrDislike($request);
    }
}
