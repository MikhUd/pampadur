<?php

namespace App\Services\Interfaces;

use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface AuthServiceContract
{
    public function getToken(UserLoginRequest $request): JsonResponse;

    public function register(UserRegisterRequest $request): JsonResponse;

    public function deleteToken(): JsonResponse;
}
