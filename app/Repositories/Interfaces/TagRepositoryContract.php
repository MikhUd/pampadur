<?php

namespace App\Repositories\Interfaces;

use App\Contracts\HasTags;
use App\Models\Tag;

interface TagRepositoryContract
{
    /**
     * Создание или получение тега по полю.
     *
     * @param array $fields
     * @return Tag
     */
    public function firstOrCreate(array $fields): Tag;
    
    /**
     * Получение тега по name.
     *
     * @param array $name
     * @return Tag
     */
    public function getByName(array $name): Tag;

    /**
     * Закрепление модели к тегу.
     *
     * @param Tag $tag
     * @param HasTags $model
     * @return void
     */
    public function bindModel(Tag $tag, HasTags $model): void;

    /**
     * Открепление модели от тега.
     *
     * @param Tag $tag
     * @param HasTags $model
     * @return void
     */
    public function detachModel(Tag $tag, HasTags $model): void;
}