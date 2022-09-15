<?php

namespace App\Repositories;

use App\Models\UserRole;
use App\Repositories\Interfaces\UserRoleRepositoryContract;

class UserRoleRepository implements UserRoleRepositoryContract
{
    private $model;

    public function __construct(UserRole $userRole)
    {
        $this->model = $userRole;
    }

    /**
     * Создание или получение роли.
     *
     * @param array $find
     * @param array $create
     * @return UserRole
     */
    public function firstOrCreate(array $find, array $create = []): UserRole
    {
        return $this->model->firstOrCreate($find, $create);
    }
}
