<?php

namespace App\Services\Interfaces;

use App\Contracts\HasTags;
use Illuminate\Support\Collection;

interface TagSynchronizerContract
{
    public function sync(HasTags $model, Collection $tags): void;
}
