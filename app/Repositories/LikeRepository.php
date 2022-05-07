<?php

namespace App\Repositories;

use App\Models\Like;
use App\Repositories\Interfaces\LikeRepositoryContract;
use Illuminate\Support\Collection;

class LikeRepository implements LikeRepositoryContract
{
    private $model;

    public function __construct(Like $like)
    {
        $this->model = $like;
    }

    /**
     * Добавление лайка/дизлайка на анкету.
     *
     * @param array $fields
     * @return Like
     */
    public function setLikeOrDislike(array $fields): Like
    {
        return $this->model->create($fields);
    }

    /**
     * Получение взимно оцененных лайков лайков
     *
     * @param int $datingCardId
     * @return Collection
     */
    public function getAssessedLikes(int $datingCardId, int $assess = null, int $backAssess = null): Collection
    {
        $query = $this->model->query();
        if (isset($backAssess)) {
            $query->where('is_liked', $backAssess);
        }
        return $query->where('liked_id', $datingCardId)->whereIn('liker_id', function ($query) use ($datingCardId, $assess) {
            $query->select('liked_id')->from('likes')->where('liker_id', $datingCardId);
            if (isset($assess)) {
                $query->where('is_liked', $assess);
            }
        })->get();
    }

    /**
     * Получение не оценненых лайков пользователем
     *
     * @param int $datingCardId
     * @return Collection
     */
    public function getNotAssessedLikesByCard(int $datingCardId): Collection
    {
        return $this->model->query()->liked()->where('liked_id', $datingCardId)->whereNotIn('liker_id', function ($query) use ($datingCardId) {
            $query->select('liked_id')->from('likes')->where('liker_id', $datingCardId);
        })->get();
    }
}
