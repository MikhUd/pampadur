<?php

namespace App\Services;

use App\Contracts\HasImages;
use App\Models\Image;
use App\Services\Interfaces\ImageServiceContract;
use Illuminate\Support\Facades\Storage;

class ImageService implements ImageServiceContract
{
    public function attachImages(HasImages $model, array $images)
    {
        foreach ($images as $image) {
             $model->images()->save(new Image([
                 'path' => Storage::put('images', $image)
             ]));
        }
    }
}
