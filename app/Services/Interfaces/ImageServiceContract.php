<?php

namespace App\Services\Interfaces;

use App\Contracts\HasImages;

interface ImageServiceContract
{
    public function attachImages(HasImages $model, array $images): void;
}
