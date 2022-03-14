<?php

namespace App\Repositories;

use App\Contracts\HasImages;
use App\Contracts\HasUser;
use App\Models\DatingCard;
use App\Models\Image;
use App\Models\User;
use App\Repositories\Interfaces\DatingCardRepositoryContract;

class DatingCardRepository implements DatingCardRepositoryContract
{
    private $model;

    public function __construct(DatingCard $user)
    {
        $this->model = $user;
    }

    /**
     * Создание анкеты.
     *
     * @return DatingCard
     */
    public function create(array $fields): DatingCard
    {
        return $this->model->create($fields);
    }

    /**
     * Прикрепление изображения к анкете.
     *
     * @return void
     */
    public function bindImage(HasImages $model, Image $image): void
    {
        $model->images()->save($image);
    }

    /**
     * Прикрепление пользователя к анкете.
     *
     * @return void
     */
    public function bindUser(HasUser $model, User $user): void
    {
        $model->user()->associate($user)->save();
    }
}
