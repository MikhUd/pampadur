<?php

namespace App\Services\Interfaces;

use App\Contracts\HasImages;

interface ImageServiceContract
{
    public function sync(HasImages $model, array $images): void;
}
