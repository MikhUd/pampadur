<?php

namespace App\Services;

use App\Contracts\HasTags;
use Illuminate\Support\Collection;
use App\Repositories\Interfaces\TagRepositoryContract;
use App\Services\Interfaces\TagSynchronizerContract;

class TagSynchronizer implements TagSynchronizerContract
{
    private $tagRepository;

    public function __construct(TagRepositoryContract $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * Синхронизация тегов с БД
     * @return void
     */
    public function sync(Collection $tags, HasTags $model): void
    {
        $tagsToAttach = function($tags, $model) {
            foreach ($tags as $tag => $name) {
                $tag = $this->tagRepository->firstOrCreate(['name' => $name]);
                $tag->datingCards()->attach($model);
            };
        };

        $tagsToDetach = function($tags, $model) {
            foreach ($tags as $tag => $name) {
                $tag = $this->tagRepository->getByName(['name' => $name]);
                $tag->datingCards()->detach($model);
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
