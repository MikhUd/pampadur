<?php

namespace App\Services\Interfaces;

use App\Http\Requests\Meeting\IndexMeetingRequest;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\JsonResponse;

interface UserServiceContract
{
    public function bindRole(User $user, string $role_code): ?UserRole;

    public function create(array $fields): ?User;

    public function update(User $user, array $fields): ?User;

    public function getUsersWithDatingCardsByFilters(IndexMeetingRequest $request): JsonResponse;
}
