<?php

namespace App\Services;

use App\Contracts\HasImages;
use App\Models\Image;
use App\Repositories\Interfaces\DatingCardRepositoryContract;
use App\Services\Interfaces\ImageServiceContract;
use Illuminate\Support\Facades\Storage;

class ImageService implements ImageServiceContract
{
    private $datingCardRepository;

    public function __construct(DatingCardRepositoryContract $datingCardRepository)
    {
        $this->datingCardRepository = $datingCardRepository;
    }

    /**
     * Прикрепление изображений к модели
     * 
     * @return void
     */
    public function attachImages(HasImages $model, array $images): void
    {
        foreach ($images as $image) {
            $this->datingCardRepository->bindImage($model, new Image([
                'path' => Storage::put('images', $image)
            ]));
        }
    }
}
