<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryContract
{
    public function create(array $fields): User;

    public function bindRole(User $user, UserRole $role): User;

    public function update(User $user, array $fields): ?User;

    public function getAllByFilter(array $filters, array $with);
}
