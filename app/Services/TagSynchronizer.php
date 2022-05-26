<?php

namespace App\Services;

use App\Contracts\HasTags;
use Illuminate\Support\Collection;
use App\Repositories\Interfaces\TagRepositoryContract;
use App\Services\Interfaces\TagSynchronizerContract;

class TagSynchronizer implements TagSynchronizerContract
{
    public function __construct(
        private TagRepositoryContract $tagRepository
    ) {}

    /**
     * Синхронизация тегов с БД.
     *
     * @param HasTags $model
     * @param Collection $tags
     * @return void
     */
    public function sync(HasTags $model, Collection $tags): void
    {
        $tagsToAttach = function($tags, $model) {
            foreach ($tags as $tag => $name) {
                $tag = $this->tagRepository->firstOrCreate(['name' => $name]);
                $this->tagRepository->bindModel($tag, $model);
            };
        };

        $tagsToDetach = function($tags, $model) {
            foreach ($tags as $tag => $name) {
                $tag = $this->tagRepository->getByName(['name' => $name]);
                $this->tagRepository->detachModel($tag, $model);
            }
        };

        if (!$model->tags->isEmpty()) {
            $oldTags = $model->tags->pluck('name')->diff($tags);
            $newTags = $tags->diff($model->tags->pluck('name'));
            $tagsToAttach($newTags, $model);
            $tagsToDetach($oldTags, $model);
        } else {
            $tagsToAttach($tags, $model);
        }
    }
}
