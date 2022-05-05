<?php

namespace App\Services;

use App\Http\Requests\Like\LikeRequest;
use App\Repositories\Interfaces\LikeRepositoryContract;
use App\Services\Interfaces\LikeServiceContract;
use Illuminate\Http\JsonResponse;

class LikeService implements LikeServiceContract
{

    public function __construct(
        private LikeRepositoryContract $likeRepository
    ) {}

    public function setLikeOrDislike(LikeRequest $request): JsonResponse
    {
        if ($like = $this->likeRepository->setLikeOrDislike($request->all())) {
            return response()->json([
                'success' => true,
                'Like' => $like,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => "Exception while creating like",
        ], 403);
    }
}
