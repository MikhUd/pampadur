<?php

namespace App\Repositories;

use App\Contracts\HasImages;
use App\Contracts\HasUser;
use App\Models\DatingCard;
use App\Models\Image;
use App\Models\Like;
use App\Models\User;
use App\Services\Interfaces\TagSynchronizerContract;
use App\Services\Interfaces\ImageServiceContract;
use App\Repositories\Interfaces\DatingCardRepositoryContract;
use App\Repositories\Interfaces\FilterRepositoryContract;
use App\Traits\Cache\CacheKeys;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use \Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DatingCardRepository implements DatingCardRepositoryContract
{
    use CacheKeys;

    private $model;
    private $filterRepository;
    const ATTRIBUTES = [
        'SIMPLY_CHANGEABLE' => [
            'name',
            'about',
            'gender',
            'seeking_for',
            'birth_date',
        ],
        'LOGIC_IN_SERVICE' => [
            'tags' => [
                'service' => TagSynchronizerContract::class,
                'method' => 'sync',
            ],
            'images' => [
                'service' => ImageServiceContract::class,
                'method' => 'sync',
            ]
        ]
    ];
    const RELATIONS = [
        'user',
        'images',
    ];

    public function __construct(DatingCard $datingCard, FilterRepositoryContract $filterRepository)
    {
        $this->model = $datingCard;
        $this->filterRepository = $filterRepository;
    }

    /**
     * Создание анкеты.
     *
     * @param array $fields
     * @return DatingCard
     */
    public function create(array $fields): DatingCard
    {
        return $this->model->create($fields);
    }

    /**
     * Обновление анкеты.
     *
     * @param DatingCard $datingCard
     * @param array $fields
     * @return DatingCard
     */
    public function update(DatingCard $datingCard, array $fields): DatingCard
    {
        foreach (self::ATTRIBUTES['SIMPLY_CHANGEABLE'] as $attr) {
            if (array_key_exists($attr, $fields)) {
                $datingCard->{$attr} = $fields[$attr];
            }
        }

        foreach (self::ATTRIBUTES['LOGIC_IN_SERVICE'] as $attr => $logic) {
            if (array_key_exists($attr, $fields)) {
                app($logic['service'])->{$logic['method']}($datingCard, $fields[$attr]);
            }
        }

        $datingCard->save();

        return $datingCard;
    }

    /**
     * Прикрепление изображения к анкете.
     *
     * @param HasImages $model
     * @param Image $image
     * @return void
     */
    public function attachImage(HasImages $model, Image $image): void
    {
        $model->images()->save($image);
    }

    /**
     * Открепление изображения от анкеты.
     *
     * @param HasImages $model
     * @param Image $image
     * @return void
     */
    public function detachImage(HasImages $model, Image $image): void
    {
        $model->images()->delete($image);
    }

    /**
     * Прикрепление пользователя к анкете.
     *
     * @param HasUser $model
     * @param User $user
     * @return void
     */
    public function bindUser(HasUser $model, User $user): void
    {
        $model->user()->associate($user)->save();
    }

    /**
     * Получение анкет по id.
     *
     * @param array $ids
     * @param array $with
     * @return Collection
     */
    public function getDatingCardsByIds(array $ids, array $with = []): Collection
    {
        $cacheTags = [
            $this->getDatingCardsCacheTag(),
        ];

        foreach ($ids as $id) {
            $cacheTags[] = $this->getDatingCardsByIdsCacheTag($id);
        }

        return Cache::tags($cacheTags)
            ->rememberForever($this->getDatingCardsByIdsCacheKey($ids), function() use ($ids, $with) {
                return $this->model->whereIn('id', $ids)->with(empty($with) ? self::RELATIONS : $with)->get();
            })
        ;
    }

    /**
     * Получение рандомных анкет, которых не видел текущий пользователь и которые не лайкнули анкету текущего пользователя.
     *
     * @param DatingCard $datingCard
     * @param Collection $exclude
     * @param int $limit
     * @return Collection
     */
    public function getRandomCardsThatNotHaveBeenAssessed(
        DatingCard $datingCard,
        Collection $exclude,
        int $limit,
        array $filters
    ): Collection
    {
        $query = $this->model->query()->whereNotExists(function ($query) use ($datingCard) {
            $query->select(DB::raw('1'))->from('likes')->where('liker_id', $datingCard->id)->whereRaw('`liked_id` = dating_cards.id');
        })->whereNotIn('id', $exclude->pluck('id'));
        $filters['limit'] = $limit;

        return $this->getFilters($query, $filters);
    }

    /**
     * Получение карт лайков на текущую анкету пользователя от анкет, на которые пользователь еще не поставил отметку.
     *
     * @param int $datingCardId
     * @param array $filters
     * @return Collection
     */
    public function getCardsWithNotAssessedLikesById(int $datingCardId, array $filters): Collection
    {
        $query = $this->model->query()
            ->selectRaw('dating_cards.*')
            ->join('likes', 'liker_id', '=', 'dating_cards.id')
            ->where('liked_id', $datingCardId)
            ->where('is_liked', 1)
            ->whereNotIn('liker_id', function ($query) use ($datingCardId) {
                $query->select('liked_id')->from('likes')->where('liker_id', $datingCardId);
            });

        return $this->getFilters($query, $filters);
    }

    /**
     * Получение фильтров на анкеты.
     *
     * @param Builder $query
     * @param array $filters
     * @return Collection
     */
    private function getFilters(Builder $query, array $filters): Collection
    {
        return $this->filterRepository->processingDatingCardFilters($query, $filters);
    }
}
