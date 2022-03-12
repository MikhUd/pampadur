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
     * @return Tag
     */
    public function firstOrCreate(array $field): Tag
    {
        return $this->model->firstOrCreate($field);
    }

    /**
     * Получение тега по name.
     *
     * @return Tag
     */
    public function getByName(array $name): Tag
    {
        return $this->model->where($name)->first();
    }

    /**
     * Закрепление модели к тегу.
     *
     * @return void
     */
    public function bindModel(Tag $tag, HasTags $model): void
    {
        $tag->datingCards()->attach($model);
    }

    /**
     * Открепление модели от тега.
     *
     * @return void
     */
    public function detachModel(Tag $tag, HasTags $model): void
    {
        $tag->datingCards()->detach($model);
    }

}
