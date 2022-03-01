<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserRole;
use App\Repositories\Interfaces\UserRepositoryContract;

class UserRepository implements UserRepositoryContract
{
    private $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function create(array $fields)
    {
        if ($result = $this->model->create($fields)) {
            $this->model->clearCache();
        }

        return $result;
    }

    public function bindRole(User $user, UserRole $role)
    {
        $user->role()->associate($role);
        $user->save();

        return $user;
    }
}
