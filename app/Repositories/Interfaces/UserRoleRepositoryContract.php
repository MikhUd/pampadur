<?php

namespace App\Repositories\Interfaces;

use App\Models\UserRole;

interface UserRoleRepositoryContract
{
    /**
     * Создание или получение роли.
     *
     * @param array $find
     * @param array $create
     * @return UserRole
     */
    public function firstOrCreate(array $find, array $create = []): UserRole;
}
