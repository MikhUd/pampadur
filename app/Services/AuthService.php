<?php

namespace App\Services;

use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Services\Interfaces\AuthServiceContract;
use App\Services\Interfaces\UserServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthService implements AuthServiceContract
{
    private $userService;

    public function __construct(UserServiceContract $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Логин
     *
     * @return JsonResponse
     */
    public function token(UserLoginRequest $request): JsonResponse
    {
        if (auth()->user()) {
            return response()->json([
                'success' => false,
                'message' => 'User is already logged in'
            ], 204);
        }

        if (auth()->attempt($request->all())) {

            return response()->json([
                'success' => true,
                'token' => auth()->user()->createToken(Str::random(5))->plainTextToken,
            ], 203);
        }

        return response()->json([
            'success' => false,
            'message' => 'Password is incorrect',
        ]);
    }

    /**
     * Регистрация
     *
     * @return JsonResponse
     */
    public function register(UserRegisterRequest $request): JsonResponse
    {
        if (auth()->user()) {
            return response()->json([
                'success' => false,
                'message' => 'User is already logged in'
            ]);
        }

        $user = $this->userService->create($request->all());

        $token = $user->createToken('test')->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
        ], 201);
    }
}
