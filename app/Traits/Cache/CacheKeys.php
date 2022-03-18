<?php

namespace App\Traits\Cache;

trait CacheKeys
{
    public function getDatingCardImagesByUserIdCacheKey(int $userId) :string
    {
        return 'datingCardImages|'.$userId;
    }
}
