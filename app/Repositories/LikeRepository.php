<?php

namespace App\Repositories;

use App\Models\Like;
use App\Repositories\Interfaces\FilterRepositoryContract;
use App\Repositories\Interfaces\LikeRepositoryContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class LikeRepository implements LikeRepositoryContract
{
    private $model;
    private $filterRepository;

    public function __construct(Like $like, FilterRepositoryContract $filterRepository)
    {
        $this->model = $like;
        $this->filterRepository = $filterRepository;
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
     * Получение взимно оцененных лайков лайков.
     *
     * @param int $datingCardId
     * @param int $assess
     * @param int $backAssess
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
     * Получение лайков на текущую анкету пользователя от анкет, на которые пользователь еще не поставил отметку.
     *
     * @param int $datingCardId
     * @param array $filters
     * @return Collection
     */
    public function getNotAssessedLikesByCard(int $datingCardId, array $filters): Collection
    {
        $query = $this->model->query()->liked()->where('liked_id', $datingCardId)->whereNotIn('liker_id', function ($query) use ($datingCardId) {
            $query->select('liked_id')->from('likes')->where('liker_id', $datingCardId);
        });

        return $this->filterRepository->processingDatingCardFilters($query, $filters)->get();
    }
}
