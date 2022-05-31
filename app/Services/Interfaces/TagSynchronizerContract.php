<?php

namespace App\Services\Interfaces;

use App\Contracts\HasTags;
use Illuminate\Support\Collection;

interface TagSynchronizerContract
{
    /**
     * Синхронизация тегов с БД.
     *
     * @param HasTags $model
     * @param Collection $tags
     * @return void
     */
    public function sync(HasTags $model, Collection $tags): void;
}
