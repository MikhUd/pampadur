<?php

namespace App\Services;

use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Models\User;
use App\Services\Interfaces\AuthServiceContract;
use App\Services\Interfaces\UserServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceContract
{

    public function __construct(
        private UserServiceContract $userService
    ) {}

    /**
     * Логин и выдача токена.
     *
     * @return JsonResponse
     */
    public function getToken(UserLoginRequest $request): JsonResponse
    {
        if (auth()->user()) {
            return response()->json([
                'success' => false,
                'message' => 'User is already logged in'
            ]);
        }

        $user = User::where('email', $request->email)->first();


        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password is incorrect',
            ]);
        }

        $user->tokens()->delete();

        return response()->json([
            'success' => true,
            'token' => $user->createToken('auth_token')->plainTextToken,
        ]);
    }

    /**
     * Регистрация и выдача токена.
     *
     * @return JsonResponse
     */
    public function register(UserRegisterRequest $request): JsonResponse
    {
        if (auth()->user()) {
            return response()->json([
                'success' => false,
                'message' => 'User is already logged in'
            ], 400);
        }

        $user = $this->userService->create($request->all());

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
        ], 201);
    }

    /**
     * Удаление токена.
     *
     * @return JsonResponse
     */
    public function deleteToken(): JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Token was deleted'
        ]);
    }
}
