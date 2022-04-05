<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Services\Interfaces\AuthServiceContract;
use App\Services\Interfaces\UserServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function __construct(
        private AuthServiceContract $authService,
        private UserServiceContract $userService,
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

    public function test(Request $request)
    {
        //dd(auth()->guard('sanctum')->user());
        dd($this->userService->getNearestUsersWithDistances(auth()->user(), 15));
    }
}
