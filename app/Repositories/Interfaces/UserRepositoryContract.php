<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Collection;

interface UserRepositoryContract
{
    /**
     * Создание пользователя.
     *
     * @param array $fields
     * @return User
     */
    public function create(array $fields): User;

    /**
     * Прикрепление роли к пользователю.
     * 
     * @param User $user
     * @param UserRole $role
     * @return User
     */
    public function bindRole(User $user, UserRole $role): User;

    /**
     * Обновление пользователя.
     * 
     * @param User $user
     * @param array $fields
     * @return User
     */
    public function update(User $user, array $fields): ?User;
}
