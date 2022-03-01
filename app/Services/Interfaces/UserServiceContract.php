<?php

namespace App\Services\Interfaces;

use App\Models\User;
use App\Models\UserRole;

interface UserServiceContract
{
    public function bindRole(User $user, $role_code): ?UserRole;

    public function create(array $fields): ?User;
}
