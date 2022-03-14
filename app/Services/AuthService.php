<?php

namespace App\Services;

use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Services\Interfaces\AuthServiceContract;
use App\Services\Interfaces\UserServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
    public function login(UserLoginRequest $request): JsonResponse
    {
        if (auth()->user()) {
            return response()->json([
                'success' => false,
                'message' => 'User is already logged in'
            ], 204);
        }

        if (auth()->attempt($request->all())) {

            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'user' => auth()->user(),
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
            ], 204);
        }

        $user = $this->userService->create($request->all());
        $request->session()->invalidate();
        $request->session()->regenerate();

        auth()->login($user);

        return response()->json([
            'success' => true,
            'user' => auth()->user(),
        ], 203);
    }

    /**
     * Логаут
     * 
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json([
            'success' => true
        ], 204);
    }
}
