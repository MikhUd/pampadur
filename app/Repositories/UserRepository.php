<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserRole;
use App\Repositories\Interfaces\UserRepositoryContract;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryContract
{
    private $model;
    const EARTH_RADIUS = 6371;
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Создание пользователя.
     *
     * @param array $fields
     * @return User
     */
    public function create(array $fields): User
    {
        return $this->model->create($fields);
    }

    /**
     * Прикрепление роли к пользователю.
     * 
     * @param User $user
     * @param UserRole $role
     * @return User
     */
    public function bindRole(User $user, UserRole $role): User
    {
        $user->role()->associate($role);
        $user->save();

        return $user;
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
        try {
            $user->update($fields);

            return $user;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Фильтрация пользователей.
     *
     * @param array $filters
     * @param array $with
     * @return Collection
     */
    public function getAllByFilter(array $filters = [], array $with = []): Collection
    {
        if (empty($filters)) {
            return $this->model->all();
        }

        return $this->model->query()
            ->when(isset($filters['select']), function ($query) use ($filters) {
                $query->select($filters['select']);
            })
            ->when(isset($filters['ids']), function ($query) use ($filters) {
                $query->whereIn('id', $filters['ids']);
            })
            ->when(isset($filters['birth_date_range']), function ($query) use ($filters) {
                [$from, $to] = explode(',', $filters['birth_date_range']);
                $from = Carbon::parse($from)->startOfDay();
                $to = Carbon::parse($to)->endOfDay();
                $query->whereBetween('birth_date', [$from, $to]);
            })
            ->with($with)
            ->get();
    }

    /**
     * Получение пользователей с их анкетами по фильтрам.
     * 
     * @param array $filters
     * @return Collection
     */
    public function getUsersWithDatingCardsByFilters(array $filters): Collection
    {
        $users = $this->model->query();
        
        return $users
            ->select(['id', 'birth_date', DB::raw('round((' . self::EARTH_RADIUS . '
                * acos(cos(radians(' . $filters['coords'][0] . ')) * cos(radians(latitude))
                * cos( radians(longitude) - radians(' . $filters['coords'][1] . '))
                + sin(radians(' . $filters['coords'][0] . ')) * sin( radians(latitude)))), 0)
                as distance_to_user')
            ])
            ->when(isset($filters['gender']), function ($query) use ($filters) {
                $query->where('gender', $filters['gender']);
            })
            ->when(isset($filters['birth_date_range']), function ($query) use ($filters) {
                [$from, $to] = explode(',', $filters['birth_date_range']);
                $from = Carbon::parse($from)->startOfDay();
                $to = Carbon::parse($to)->endOfDay();
                $query->whereBetween('birth_date', [$from, $to]);
            })
            ->when(isset($filters['distance']), function ($query) use ($filters) {
                $query->havingRaw('distance_to_user < ' . $filters['distance']);
            })
            ->orderBy('id')
            ->whereHas('datingCard', function($query) use ($filters) {
                $query->liked($filters['like_status'] ?? null);
            })
            ->with('images')
            ->limit(50)
            ->get();
    }
}
