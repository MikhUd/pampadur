<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserRole;
use App\Repositories\Interfaces\UserRepositoryContract;
use App\Repositories\Interfaces\UserRoleRepositoryContract;
use App\Services\Interfaces\UserServiceContract;
use Illuminate\Support\Facades\Log;

class UserService implements UserServiceContract
{
    const DEFAULT_USER_ROLE_CODE = 'xdDsklw3w';

    private $userRepository;
    private $userRoleRepository;

    public function __construct(UserRepositoryContract $userRepository, UserRoleRepositoryContract $userRoleRepository)
    {
        $this->userRepository = $userRepository;
        $this->userRoleRepository = $userRoleRepository;
    }

    public function bindRole(User $user, $role_code = self::DEFAULT_USER_ROLE_CODE): ?UserRole
    {
        $role = $this->userRoleRepository->firstOrCreate([
            'name' => $role_code,
            'code' => $role_code,
        ]);

        if (!empty($role['code'])) {
            Log::info('Binding role for user', ['id' => $user->id]);

            $result = $this->userRepository->bindRole($user, $role);

            return $result;
        }

        Log::error('Binding role for user failed', ['id' => $user->id]);

        return null;
    }

    public function create(array $fields, string $role = self::DEFAULT_USER_ROLE_CODE): ?User
    {
        $fields['role_code'] = $role;
        if ($user = $this->userRepository->create($fields)) {
           return $user;
        }

        return null;
    }
}
