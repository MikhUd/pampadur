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
     * Прикрепление изображений к модели.
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

    /**
     * Обновление изображения
     *
     * @return void
     */
    public function update(HasImages $model, array $imagesData): void
    {
        $ids = $model->images->pluck('id');

        foreach ($imagesData as $data) {
            if (in_array($data['id'], $ids)) {
                $image = Image::where('id', $data['id'])->first();
                $image->path = Storage::put('images', $data['image']);
            }
        }
    }
}
