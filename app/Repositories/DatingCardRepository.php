<?php

namespace App\Repositories;

use App\Contracts\HasImages;
use App\Contracts\HasUser;
use App\Models\DatingCard;
use App\Models\Image;
use App\Models\User;
use App\Services\Interfaces\TagSynchronizerContract;
use App\Services\Interfaces\ImageServiceContract;
use App\Repositories\Interfaces\DatingCardRepositoryContract;

class DatingCardRepository implements DatingCardRepositoryContract
{
    private $model;
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

    public function __construct(DatingCard $user)
    {
        $this->model = $user;
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
}
