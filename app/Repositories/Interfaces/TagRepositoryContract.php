<?php

namespace App\Repositories\Interfaces;

use App\Models\Tag;

interface TagRepositoryContract
{
    public function firstOrCreate(array $field): Tag;
    
    public function getByName(array $name): Tag;
}