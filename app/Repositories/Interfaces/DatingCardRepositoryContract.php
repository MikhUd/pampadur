<?php

namespace App\Repositories\Interfaces;

use App\Contracts\HasImages;
use App\Models\DatingCard;
use App\Models\Image;

interface DatingCardRepositoryContract
{
    public function create(array $fields): DatingCard;

    public function bindImage(HasImages $model, Image $image): void;
}
