<?php

namespace App\Services\Interfaces;

use App\Models\User;
use App\Models\UserRole;

interface UserServiceContract
{
    /**
     * Создание пользователя.
     *
     * @param array $fields
     * @param string $role_code
     * @return User
     */
    public function create(array $fields): ?User;

    /**
     * Обновление пользователя.
     *
     * @param User $user
     * @param array $fields
     * @return User
     */
    public function update(User $user, array $fields): ?User;

    /**
     * Закрепление роли к пользователю.
     *
     * @param User $user
     * @param string $role_code
     * @return UserRole
     */
    public function bindRole(User $user, string $role_code): ?UserRole;
}
