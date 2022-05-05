<?php

namespace App\Transformers\DatingCard;

use Illuminate\Support\Collection;
use App\Transformers\DatingCard\ImageTransformer;

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
                'user_id' => $item->id ?? null,
                'birth_date' => $item->birth_date->format('Y-m-d') ?? null,
                'distance_to_user' => intval($item->distance_to_user) ?? null,
                'dating_card' => [
                    'id' => $item->datingCard->id ?? null,
                    'name' => $item->datingCard->name ?? null,
                    'about' => $item->datingCard->about ?? null,
                    'gender' => $item->datingCard->gender ?? null,
                    'seeking_for' => $item->datingCard->seeking_for ?? null,
                    'user_id' => $item->datingCard->user_id ?? null,
                    'published_at' => isset($item->datingCard->published_at) ?? false,
                    'tags' => isset($item->datingCard->tags) ? array_column($item->datingCard->tags->toArray(), 'name') : null,
                    'images' => [
                        ImageTransformer::toArray($item->images),
                    ],
                ],
            ];
        })->toArray();
    }
}
