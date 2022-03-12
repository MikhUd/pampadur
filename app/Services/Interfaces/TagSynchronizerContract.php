<?php

namespace App\Services\Interfaces;

use App\Contracts\HasTags;
use Illuminate\Support\Collection;

interface TagSynchronizerContract
{
    public function sync(Collection $tags, HasTags $model): void;
}
