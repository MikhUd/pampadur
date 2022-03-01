<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use App\Services\Auth\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(UserLoginRequest $request)
    {
        $this->authService->login($request);
    }

    public function register(UserRegisterRequest $request)
    {
        $this->authService->register($request);
    }

}
