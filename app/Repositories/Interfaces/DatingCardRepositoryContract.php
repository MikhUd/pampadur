<?php

namespace App\Repositories\Interfaces;

use App\Contracts\HasImages;
use App\Contracts\HasUser;
use App\Models\DatingCard;
use App\Models\Image;
use App\Models\User;

interface DatingCardRepositoryContract
{
    public function create(array $fields): DatingCard;

    public function bindImage(HasImages $model, Image $image): void;

    public function bindUser(HasUser $model, User $user): void;
}
