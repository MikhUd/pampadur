<?php

namespace App\Repositories\Interfaces;

use App\Contracts\HasTags;
use App\Models\Tag;

interface TagRepositoryContract
{
    public function firstOrCreate(array $fields): Tag;
    
    public function getByName(array $name): Tag;

    public function bindModel(Tag $tag, HasTags $model): void;

    public function detachModel(Tag $tag, HasTags $model): void;
}