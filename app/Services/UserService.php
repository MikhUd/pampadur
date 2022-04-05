<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserRole;
use App\Repositories\Interfaces\UserRepositoryContract;
use App\Repositories\Interfaces\UserRoleRepositoryContract;
use App\Services\Interfaces\LocationServiceContract;
use App\Services\Interfaces\UserServiceContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class UserService implements UserServiceContract
{

    public function __construct(
        private UserRepositoryContract $userRepository,
        private UserRoleRepositoryContract $userRoleRepository,
        private LocationServiceContract $locationService,
    ) {}

    /**
     * Закрепление роли к пользователю.
     *
     * @return UserRole
     */
    public function bindRole(User $user, string $role_code): ?UserRole
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

    /**
     * Создание пользователя.
     *
     * @return User
     */
    public function create(array $fields, string $role_code = User::DEFAULT_USER_ROLE_CODE): ?User
    {
        $fields['role_code'] = $role_code;

        if ($user = $this->userRepository->create($fields)) {
            return $user;
        }

        return null;
    }

    /**
     * Обновление пользователя.
     *
     * @return User
     */
    public function update(User $user, array $fields): ?User
    {
        if ($updatedUser = $this->userRepository->update($user, $fields)) {
            return $updatedUser;
        }

        Log::error('User update failed', ['id' => $user->id]);

        return null;
    }

    /**
     * Получение ближайших по фильтру(distance) пользователей с расстоянием до них.
     *
     * @return array
     */
    public function getNearestUsersWithDistances(User $user, int $distance): array
    {
        return $this->userRepository->getNearestByDistance([$user->latitude, $user->longitude], $distance)->toArray();
    }
}
