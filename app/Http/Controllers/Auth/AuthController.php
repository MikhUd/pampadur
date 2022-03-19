<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Services\AuthService;
use App\Services\Interfaces\AuthServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function __construct(
        private AuthServiceContract $authService
    ) {}

    public function getToken(UserLoginRequest $request): JsonResponse
    {
        return $this->authService->getToken($request);
    }

    public function register(UserRegisterRequest $request): JsonResponse
    {
        return $this->authService->register($request);
    }

    public function deleteToken(): JsonResponse
    {
        return $this->authService->deleteToken();
    }
}
