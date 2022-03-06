<?php

namespace App\Services\Interfaces\Auth;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface AuthServiceContract
{
    public function login(UserLoginRequest $request): JsonResponse;

    public function register(UserRegisterRequest $request): JsonResponse;

    public function logout(Request $request): JsonResponse;
}
