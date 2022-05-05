<?php

namespace App\Repositories;

use App\Models\DatingCard;
use App\Models\Like;
use App\Models\User;
use App\Repositories\Interfaces\FilterRepositoryContract;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FilterRepository implements FilterRepositoryContract
{
    const EARTH_RADIUS = 6371;
    /**
     * Обработка фильтров на анкету.
     * 
     * @param array $filters
     * @return Like
     */
    public function processingDatingCardFilters(array $filters = []): void
    {
        $datingCard = new DatingCard();
        $query = $datingCard->query();
        $query
            ->when(isset($filters['gender']), function ($query) use ($filters) {
                $query->where('gender', $filters['gender']);
            })
            ->when(isset($filters['tags']), function ($query) use ($filters) {
                $query->whereHas('tags', 
                fn($query) => $query->whereRaw('lower(name) like (?)', ['%'.Str::lower($filters['tags']).'%']));
            });
    }

    /**
     * Обработка фильтров на пользователя.
     * 
     * @param array $filters
     * @return Like
     */
    public function processingUserFilters(array $filters = []): void
    {
        $user = new User();
        $query = $user->query();
        $query
            ->when(isset($filters['birth_date_range']), function ($query) use ($filters) {
                [$from, $to] = explode(',', $filters['birth_date_range']);
                $from = Carbon::parse($from)->startOfDay();
                $to = Carbon::parse($to)->endOfDay();
                $query->whereBetween('birth_date', [$from, $to]);
            })
            ->when(isset($filters['coords']), function ($query) use ($filters) {
                $query->select(['id', 'birth_date', DB::raw('round((' . self::EARTH_RADIUS . '
                    * acos(cos(radians(' . $filters['coords'][0] . ')) * cos(radians(latitude))
                    * cos( radians(longitude) - radians(' . $filters['coords'][1] . '))
                    + sin(radians(' . $filters['coords'][0] . ')) * sin( radians(latitude)))), 0)
                    as distance_to_user')
                ]);
            })
            ->when(isset($filters['distance']), function ($query) use ($filters) {
                $query->havingRaw('distance_to_user < ' . $filters['distance']);
            });
    }
}
