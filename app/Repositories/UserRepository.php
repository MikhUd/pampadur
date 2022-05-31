<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserRole;
use App\Repositories\Interfaces\UserRepositoryContract;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryContract
{
    private $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Создание пользователя.
     *
     * @param array $fields
     * @return User
     */
    public function create(array $fields): User
    {
        return $this->model->create($fields);
    }

    /**
     * Прикрепление роли к пользователю.
     * 
     * @param User $user
     * @param UserRole $role
     * @return User
     */
    public function bindRole(User $user, UserRole $role): User
    {
        $user->role()->associate($role);
        $user->save();

        return $user;
    }

    /**
     * Обновление пользователя.
     * 
     * @param User $user
     * @param array $fields
     * @return User
     */
    public function update(User $user, array $fields): ?User
    {
        try {
            $user->update($fields);

            return $user;
        } catch (\Exception $e) {
            return null;
        }
    }
}
