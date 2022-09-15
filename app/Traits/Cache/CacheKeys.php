<?php

namespace App\Traits\Cache;

use App\Repositories\FilterRepository;
use Illuminate\Support\Arr;

trait CacheKeys
{
    public function getDatingCardsCacheTag(): string
    {
        return 'datingCards';
    }

    public function getDatingCardsToAssessByFiltersCacheKey(array $fields, string $userEmail): string
    {
        return 'datingCards|toAssess|' . $userEmail . json_encode(Arr::only($fields, FilterRepository::FILTERS));
    }

    public function getDailyMaxCountDatingCardsToAssessCacheKey(string $userEmail): string
    {
        return 'max|count|datingCards|toAssess|' . $userEmail;
    }

    public function getDailyMaxCountDatingCardsToAssessCacheTag(string $userEmail): string
    {
        return 'max|count|datingCards|toAssess|' . $userEmail;
    }

    public function getDatingCardsToAssessCacheTag(int $userId): string
    {
        return 'datingCards|toAsses|' . $userId;
    }

    public function getDatingCardsByIdsCacheTag(int $id): string
    {
        return 'datingCards|by|ids|' . $id;
    }

    public function getDatingCardsByIdsCacheKey(array $ids): string
    {
        return 'datingCards|by|ids|' . json_encode($ids);
    }
}
