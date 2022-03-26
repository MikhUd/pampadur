<?php

namespace App\Services\Interfaces;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Eloquent\Collection;

interface UserServiceContract
{
    public function bindRole(User $user, string $role_code): ?UserRole;

    public function create(array $fields): ?User;

    public function update(User $user, array $fields): ?User;

    public function getNearestUsers(User $user, int $distance): Collection;
}
