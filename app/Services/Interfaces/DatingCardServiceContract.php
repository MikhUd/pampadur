<?php

namespace App\Services\Interfaces;

use App\Http\Requests\DatingCard\CreateDatingCardRequest;
use App\Http\Requests\DatingCard\UpdateDatingCardRequest;
use App\Http\Requests\Meeting\ShowDatingCardsRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

interface DatingCardServiceContract
{
    /**
     * Сохранение анкеты.
     *
     * @param CreateDatingCardRequest $request
     * @return JsonResponse
     */
    public function store(CreateDatingCardRequest $request): JsonResponse;

    /**
     * Обновление анкеты.
     *
     * @param UpdateDatingCardRequest $request
     * @return JsonResponse
     */
    public function update(UpdateDatingCardRequest $request): JsonResponse;

    /**
     * Получение анкет с взаимными лайками.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getCardsWithReciprocalLikes(Request $request): JsonResponse;

    /**
     * Получение 50 анкет для оценок в рандомном порядке.
     *
     * @param ShowDatingCardsRequest $request
     * @return JsonResponse
     */
    public function getCardsToAssess(ShowDatingCardsRequest $request): JsonResponse;
}
