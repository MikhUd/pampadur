<?php

namespace App\Repositories\Interfaces;

use App\Models\UserRole;

interface UserRoleRepositoryContract
{
    public function firstOrCreate(array $find, array $create = []): UserRole;
}
