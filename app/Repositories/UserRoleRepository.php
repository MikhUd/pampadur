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

    public function firstOrCreate(array $find, array $create = []): UserRole
    {
        return $this->model->firstOrCreate($find, $create);
    }
}
