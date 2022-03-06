<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use App\Models\UserRole;

interface UserRepositoryContract
{
    public function create(array $fields): User;

    public function bindRole(User $user, UserRole $role): User;
}
