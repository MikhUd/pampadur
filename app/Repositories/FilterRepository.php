<?php

namespace App\Repositories;

use App\Models\Like;
use App\Repositories\Interfaces\FilterRepositoryContract;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FilterRepository implements FilterRepositoryContract
{
    const EARTH_RADIUS = 6371;
    
    /**
     * Обработка фильтров на анкету.
     * 
     * @param Builder $query
     * @param array $filters
     * @return Builder
     */
    public function processingDatingCardFilters(Builder $query, array $filters = []): Builder
    {
        $query->whereRelation('user', function ($query) use ($filters) {
            $this->getUserFilters($query, $filters);
        })->with('user');

        if ($query->getModel() instanceof Like) {
            return $query->whereRelation('datingCard', function ($query) use ($filters) {
                $this->getDatingCardFilters($query, $filters);
            });
        }
        
        return $this->getDatingCardFilters($query, $filters)->with('images');
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
     * @param Builder $query
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
            ->when(isset($filters['age_range']), function ($query) use ($filters) {
                [$to, $from] = $filters['age_range'];
                $to = Carbon::now()->subYear($to)->format('Y-m-d');
                $from = Carbon::now()->subYear($from)->format('Y-m-d');
                $query->whereBetween('birth_date', [$from, $to]);
            })
            ->when(isset($filters['distance']), function ($query) use ($filters) {
                $query->havingRaw('distance_to_user < ' . $filters['distance']);
            })
        ;
    }
}
