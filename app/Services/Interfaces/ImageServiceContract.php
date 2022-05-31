<?php

namespace App\Services\Interfaces;

use App\Contracts\HasImages;

interface ImageServiceContract
{
    /**
     * Синхронизация изображений.
     *
     * @param HasImages $model
     * @param array $newImages
     * @return void
     */
    public function sync(HasImages $model, array $images): void;
}
