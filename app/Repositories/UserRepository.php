<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserRole;
use App\Repositories\Interfaces\UserRepositoryContract;
use Carbon\Carbon;
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
     * @return User
     */
    public function create(array $fields): User
    {
        return $this->model->create($fields);
    }

    /**
     * Прикрепление роли к пользователю.
     *
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
     */
    public function getAllByFilter(array $filters = [], array $with = [])
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
     * Получение ближайших пользователей по расстоянию.
     *
     */
    public function getNearestByDistance(array $currentUserCoords, int $distance)
    {
        $users = $this->model->query();

        return $users
            ->select(['id', 'email', 'role_code', 'birth_date', DB::raw('round(('.self::EARTH_RADIUS.'
            * acos(cos(radians('.$currentUserCoords[0].')) * cos(radians(latitude))
            * cos( radians(longitude) - radians('.$currentUserCoords[1].'))
            + sin(radians('.$currentUserCoords[0].')) * sin( radians(latitude)))), 0)
            as distance_to_user')])
            ->havingRaw('distance_to_user < '.$distance)
            ->orderBy('id')
            ->with('datingCard')
            ->get();
    }
}
