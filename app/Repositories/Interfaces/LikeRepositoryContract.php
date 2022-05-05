<?php

namespace App\Repositories\Interfaces;

use App\Models\Like;

interface LikeRepositoryContract
{
    public function setLikeOrDislike(array $fields): Like;
}