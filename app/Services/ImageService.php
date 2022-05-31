<?php

namespace App\Services;

use App\Contracts\HasImages;
use App\Models\Image;
use App\Repositories\Interfaces\DatingCardRepositoryContract;
use App\Services\Interfaces\ImageServiceContract;
use Illuminate\Support\Facades\Storage;

class ImageService implements ImageServiceContract
{
    public function __construct(
        private DatingCardRepositoryContract $datingCardRepository
    ) {}

    /**
     * Синхронизация изображений.
     *
     * @param HasImages $model
     * @param array $newImages
     * @return void
     */
    public function sync(HasImages $model, array $newImages): void
    {
        if (isset($model->images)) {
            foreach ($model->images as $oldImage) {
                $this->datingCardRepository->detachImage($model, $oldImage);
                Storage::delete($oldImage->path);
            }
        }

        foreach ($newImages as $newImage) {
            $this->datingCardRepository->attachImage($model, new Image([
                'path' => Storage::put('images', $newImage)
            ]));
        }
    }
}
