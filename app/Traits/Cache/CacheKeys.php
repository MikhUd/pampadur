<?php

namespace App\Traits\Cache;

use App\Repositories\FilterRepository;
use Illuminate\Support\Arr;

trait CacheKeys
{
    public function getDatingCardImagesByUserIdCacheKey(int $userId): string
    {
        return 'datingCardImages|' . $userId;
    }

    public function getDatingCardsToAssessCacheKey(array $request): string
    {
        return 'datingCardsToAssess|' . auth()->user()->email . json_encode(Arr::only($request, FilterRepository::FILTERS));
    }

    public function getMaxCountDatingCardsToAssessCacheKey(): string
    {
        return 'maxCountDatingCardsToAssess|' . auth()->user()->email;
    }
}
