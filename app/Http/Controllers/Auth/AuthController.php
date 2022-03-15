<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function getToken(UserLoginRequest $request)
    {
        return $this->authService->getToken($request);
    }

    public function register(UserRegisterRequest $request)
    {
        return $this->authService->register($request);
    }

    public function deleteToken()
    {
        return $this->authService->deleteToken();
    }
}
