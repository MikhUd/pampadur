<?php

namespace App\Services\Interfaces;

use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface AuthServiceContract
{
    /**
     * Логин и выдача токена.
     *
     * @param UserLoginRequest $request
     * @return JsonResponse
     */
    public function getToken(UserLoginRequest $request): JsonResponse;

    /**
     * Регистрация и выдача токена.
     *
     * @param UserRegisterRequest $request
     * @return JsonResponse
     */
    public function register(UserRegisterRequest $request): JsonResponse;

    /**
     * Удаление токена.
     *
     * @return JsonResponse
     */
    public function deleteToken(): JsonResponse;
}
