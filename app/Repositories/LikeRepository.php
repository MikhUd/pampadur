<?php

namespace App\Repositories;

use App\Models\Like;
use App\Repositories\Interfaces\LikeRepositoryContract;

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
}
