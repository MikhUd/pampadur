<?php

namespace App\Repositories\Interfaces;

use App\Models\Like;
use Illuminate\Support\Collection;

interface LikeRepositoryContract
{
    public function setLikeOrDislike(array $fields): Like;

    public function getLikeByFields(array $fields): ?Like;

    public function getAssessedLikes(int $datingCardId, int $assess = null, int $backAssess = null): Collection;
}
