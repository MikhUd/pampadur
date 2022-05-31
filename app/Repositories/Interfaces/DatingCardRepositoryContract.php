<?php

namespace App\Repositories\Interfaces;

use App\Contracts\HasImages;
use App\Contracts\HasUser;
use App\Models\DatingCard;
use App\Models\Image;
use App\Models\User;
use Illuminate\Support\Collection;

interface DatingCardRepositoryContract
{
    /**
     * Создание анкеты.
     *
     * @param array $fields
     * @return DatingCard
     */
    public function create(array $fields): DatingCard;

    /**
     * Обновление анкеты.
     *
     * @param DatingCard $datingCard
     * @param array $fields
     * @return DatingCard
     */
    public function update(DatingCard $datingCard, array $fields): DatingCard;

    /**
     * Прикрепление изображения к анкете.
     *
     * @param HasImages $model
     * @param Image $image
     * @return void
     */
    public function attachImage(HasImages $model, Image $image): void;

    /**
     * Открепление изображения от анкеты.
     *
     * @param HasImages $model
     * @param Image $image
     * @return void
     */
    public function detachImage(HasImages $model, Image $image): void;

    /**
     * Прикрепление пользователя к анкете.
     *
     * @param HasUser $model
     * @param User $user
     * @return void
     */
    public function bindUser(HasUser $model, User $user): void;

    /**
     * Получение анкеты по параметрам.
     *
     * @param array $fields
     * @param array $with
     * @return Collection
     */
    public function getDatingCard(array $fields, array $with = []): ?DatingCard;

    /**
     * Получение анкет по id.
     *
     * @param array $ids
     * @param array $with
     * @return Collection
     */
    public function getDatingCardsByIds(array $ids, array $with): Collection;

    /**
     * Получение рандомных анкет, которых не видел текущий пользователь и которые не лайкнули анкету текущего пользователя (текущий их не оценивал и они его тоже).
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
    ): Collection;

    /**
     * Получение анкет с лайками на текущую анкету пользователя, на которые пользователь еще не поставил отметку (которые лайкнули текущего, а текущий их не видел).
     *
     * @param int $datingCardId
     * @param array $filters
     * @return Collection
     */
    public function getCardsWithNotAssessedLikesById(int $datingCardId, array $filters): Collection;
}
