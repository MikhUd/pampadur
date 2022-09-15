<?php

namespace App\Repositories\Interfaces;

use App\Models\Like;
use Illuminate\Support\Collection;

interface LikeRepositoryContract
{
    /**
     * Добавление лайка/дизлайка на анкету.
     *
     * @param array $fields
     * @return Like
     */
    public function createLike(array $fields): Like;

    /**
     * Получение лайка по параметрам.
     *
     * @param array $fields
     * @return Like
     */
    public function getLikeByFields(array $fields): ?Like;

    /**
     * Получение взаимных лайков.
     *
     * @param int $datingCardId
     * @param int $assess
     * @param int $backAssess
     * @return Collection
     */
    public function getAssessedLikes(int $datingCardId, int $assess = null, int $backAssess = null): Collection;
}
