<?php

namespace App\Transformers\DatingCard;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ImageTransformer
{
    /**
     * Трансформирование коллекции изображений.
     * 
     * @param Collection $collection
     * @return array
     */
    public static function toArray(Collection $collection): array
    {
        return $collection->map(function($item, $key) {
            return base64_encode(file_get_contents(Storage::path($item->path)));
        })->toArray();
    }
}
