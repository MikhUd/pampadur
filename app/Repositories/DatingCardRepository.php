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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use \Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\DB;

class DatingCardRepository implements DatingCardRepositoryContract
{

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
     * Получение анкет по лайкам.
     *
     * @param Collection $likes
     * @return Collection
     */
    public function getLikerCardsByLikes(Collection $likes): Collection
    {
        return EloquentCollection::wrap($likes->load('datingCard')->pluck('datingCard'))->load(self::RELATIONS);
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
        })->whereNotIn('id', $exclude->pluck('id'))->limit($limit)->inRandomOrder();

        dd($this->filterRepository->processingDatingCardFilters($query, $filters)->limit(1)->get());
        return $this->filterRepository->processingDatingCardFilters($query, $filters)->get();
    }
}
