<?php

namespace App\Repositories;

use App\Models\DatingCard;
use App\Repositories\Interfaces\DatingCardRepositoryContract;

class DatingCardRepository implements DatingCardRepositoryContract
{
    private $model;

    public function __construct(DatingCard $user)
    {
        $this->model = $user;
    }

    public function create(array $fields): DatingCard
    {
        return $this->model->create($fields);
    }
}
