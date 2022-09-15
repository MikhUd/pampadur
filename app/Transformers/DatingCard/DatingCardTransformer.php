<?php

namespace App\Transformers\DatingCard;

use Illuminate\Support\Collection;
use App\Transformers\DatingCard\ImageTransformer;
use Carbon\Carbon;

class DatingCardTransformer
{
    /**
     * Трансформирование коллекции анкет.
     *
     * @param Collection $collection
     * @return array
     */
    public static function toArray(Collection $collection): array
    {
        return $collection->map(function($item, $key) {
            return [
                'id' => $item->id ?? null,
                'name' => $item->name ?? null,
                'about' => $item->about ?? null,
                'gender' => $item->gender ?? null,
                'seeking_for' => $item->seeking_for ?? null,
                'tags' => isset($item->tags) ? array_column($item->tags->toArray(), 'name') : null,
                'liked_me' => isset($item->liked_me) ? true : false,
                'user' => [
                    'id' => $item->user->id ?? null,
                    'distance' => isset($item->user->distance_to_user) ? intval($item->user->distance_to_user) : null,
                    'age' => Carbon::parse($item->user->birth_date)->diffInYears(Carbon::now()),
                ],
                'images' => [
                    ImageTransformer::toArray($item->images),
                ]
            ];
        })->toArray();
    }
}
