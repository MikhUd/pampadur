<?php

namespace App\Repositories;

use App\Contracts\HasTags;
use App\Models\Tag;
use App\Repositories\Interfaces\TagRepositoryContract;

class TagRepository implements TagRepositoryContract
{
    private $model;

    public function __construct(Tag $tag)
    {
        $this->model = $tag;
    }

    /**
     * Создание или получение тега по полю.
     *
     * @param array $fields
     * @return Tag
     */
    public function firstOrCreate(array $fields): Tag
    {
        return $this->model->firstOrCreate($fields);
    }

    /**
     * Получение тега по name.
     *
     * @param array $name
     * @return Tag
     */
    public function getByName(array $name): Tag
    {
        return $this->model->where($name)->first();
    }

    /**
     * Закрепление модели к тегу.
     *
     * @param Tag $tag
     * @param HasTags $model
     * @return void
     */
    public function bindModel(Tag $tag, HasTags $model): void
    {
        $tag->datingCards()->attach($model);
    }

    /**
     * Открепление модели от тега.
     *
     * @param Tag $tag
     * @param HasTags $model
     * @return void
     */
    public function detachModel(Tag $tag, HasTags $model): void
    {
        $tag->datingCards()->detach($model);
    }
}
