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
    public function create(array $fields): DatingCard;

    public function update(DatingCard $datingCard, array $fields): DatingCard;

    public function attachImage(HasImages $model, Image $image): void;

    public function detachImage(HasImages $model, Image $image): void;

    public function bindUser(HasUser $model, User $user): void;

    public function getLikerCardsByLikes(Collection $likes): Collection;

    public function getRandomCardsThatNotHaveBeenAssessed(DatingCard $datingCard, Collection $exclude, int $limit): Collection;
}
