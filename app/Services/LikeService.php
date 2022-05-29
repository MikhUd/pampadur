<?php

namespace App\Services;

use App\Http\Requests\Like\LikeRequest;
use App\Models\Like;
use App\Repositories\Interfaces\LikeRepositoryContract;
use App\Services\Interfaces\LikeServiceContract;
use App\Traits\Cache\CacheKeys;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class LikeService implements LikeServiceContract
{
    use CacheKeys;

    public function __construct(
        private LikeRepositoryContract $likeRepository
    ) {}

    /**
     * Добавление лайка/дизлайка на анкету.
     *
     * @param LikeRequest $request
     * @return JsonResponse
     */
    public function setLikeOrDislike(LikeRequest $request): JsonResponse
    {
        $fields = $request->all();

        if ($like = $this->likeRepository->getLikeByFields(Arr::only($fields, ['liker_id', 'liked_id']))) {
            return response()->json([
                'success' => false,
                'message' => "Like already exists",
            ], 403);
        }

        $count = intval(
            Cache::tags([$this->getDatingCardsCacheTag(), $tag = $this->getDailyMaxCountDatingCardsToAssessCacheTag($email = auth()->user()->email)])->get(
                $key = $this->getDailyMaxCountDatingCardsToAssessCacheKey($email)
            )
        );
        Cache::tags($tag)->flush();
        Cache::tags([$this->getDatingCardsCacheTag(), $tag])->rememberForever(
            $key,
            fn() => $count - 1
        );

        if ($like = $this->likeRepository->setLikeOrDislike($fields)) {
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
