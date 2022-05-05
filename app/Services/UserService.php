<?php

namespace App\Services;

use App\Http\Requests\Meeting\IndexMeetingRequest;
use App\Models\User;
use App\Models\UserRole;
use App\Repositories\Interfaces\UserRepositoryContract;
use App\Repositories\Interfaces\UserRoleRepositoryContract;
use App\Services\Interfaces\PrivateFilesServiceContract;
use App\Services\Interfaces\UserServiceContract;
use App\Transformers\DatingCard\DatingCardTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class UserService implements UserServiceContract
{
    const FILTERS = [
        'USER' => [
            'coords',
            'birth_date',
            'distance',
        ],
        'DATING_CARD' => [
            'gender',
            'tags',
        ]
    ];

    public function __construct(
        private UserRepositoryContract $userRepository,
        private UserRoleRepositoryContract $userRoleRepository,
        private PrivateFilesServiceContract $privateFilesService,
    ) {}

    /**
     * Закрепление роли к пользователю.
     *
     * @param User $user
     * @param string $role_code
     * @return UserRole
     */
    public function bindRole(User $user, string $role_code = User::DEFAULT_USER_ROLE_CODE): ?UserRole
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
     * @param array $fields
     * @param string $role_code
     * @return User
     */
    public function create(array $fields, string $role_code = User::DEFAULT_USER_ROLE_CODE): ?User
    {
        $fields['role_code'] = $role_code;

        if ($user = $this->userRepository->create($fields)) {
            return $user;
        }

        Log::error('User create failed');

        return null;
    }

    /**
     * Обновление пользователя.
     *
     * @param User $user
     * @param array $fields
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
     * Получение пользователей по фильтру с их анкетами.
     *
     * @param IndexMeetingRequest $request
     * @return array
     */
    public function getUsersWithDatingCardsByFilters(IndexMeetingRequest $request): JsonResponse
    {
        $fields = $request->all();
        $fields['coords'] = [$request->user()->latitude, $request->user()->longitude];

        if ($usersWithDatingCards = $this->userRepository->getUsersWithDatingCardsByFilters($fields)) {
            return response()->json([
                'success' => true,
                'users' => DatingCardTransformer::toArray($usersWithDatingCards),
            ], 200);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong',
        ], 400);
    }
}
