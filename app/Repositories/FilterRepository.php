<?php

namespace App\Repositories;

use App\Models\Like;
use App\Repositories\Interfaces\FilterRepositoryContract;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class FilterRepository implements FilterRepositoryContract
{
    const EARTH_RADIUS = 6371;
    const WITH = ['tags', 'images'];
    
    /**
     * Обработка фильтров на анкету.
     * 
     * @param Builder $query
     * @param array $filters
     * @return Collection
     */
    public function processingDatingCardFilters(Builder $query, array $filters = []): Collection
    {
        $query->whereHas('user', function ($query) use ($filters) {
            $this->getUserFilters($query, $filters);
        })->with(['user' => function ($query) use ($filters) {
            $query
            ->select(['id', 'birth_date', DB::raw('round((' . self::EARTH_RADIUS . '
                * acos(cos(radians(' . $filters['coords'][0] . ')) * cos(radians(latitude))
                * cos( radians(longitude) - radians(' . $filters['coords'][1] . '))
                + sin(radians(' . $filters['coords'][0] . ')) * sin( radians(latitude)))), 0)
                as distance_to_user')
            ]);
        }]);

        return $this->getDatingCardFilters($query, $filters)
            ->limit($filters['limit'])
            ->with(self::WITH)
            ->get();
    }

    /**
     * Получение фильтров на анкету.
     * 
     * @param Builder $query
     * @param array $filters
     * @return Builder
     */
    private function getDatingCardFilters(Builder $query, array $filters = []): Builder
    {
        return $query
            ->when(isset($filters['gender']), fn($query) => $query->where('gender', $filters['gender']))
            ->when(isset($filters['tag']), fn($query) => 
                $query->whereRelation('tags', 
                    fn($query) => $query->whereRaw('lower(name) like (?)', ['%' . Str::lower($filters['tag']) . '%'])
                )
            )
        ;
    }

    /**
     * Получение фильтров на пользователя.
     * 
     * @param BelongsTo $query
     * @param array $filters 
     * @return Builder
     */
    private function getUserFilters(Builder $query, array $filters = []): Builder
    {
        return $query
            ->select(['id', 'birth_date', DB::raw('round((' . self::EARTH_RADIUS . '
                * acos(cos(radians(' . $filters['coords'][0] . ')) * cos(radians(latitude))
                * cos( radians(longitude) - radians(' . $filters['coords'][1] . '))
                + sin(radians(' . $filters['coords'][0] . ')) * sin( radians(latitude)))), 0)
                as distance_to_user')
            ])
            ->when(isset($filters['distance']), function ($query) use ($filters) {
                $query->havingRaw('distance_to_user < ' . $filters['distance']);
            })
            ->when(isset($filters['age_range']), function ($query) use ($filters) {
                [$to, $from] = $filters['age_range'];
                $to = Carbon::now()->subYear($to)->format('Y-m-d');
                $from = Carbon::now()->subYear($from)->format('Y-m-d');
                $query->whereBetween('birth_date', [$from, $to]);
            })
        ;
    }
}
