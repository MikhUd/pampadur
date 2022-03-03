<?php

namespace App\Services\Auth;

use App\Services\Interfaces\Auth\AuthServiceContract;
use App\Services\Interfaces\UserServiceContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthService implements AuthServiceContract
{
    private $userService;

    public function __construct(UserServiceContract $userService)
    {
        $this->userService = $userService;
    }

    public function login($request)
    {
        if (Auth::attempt($request)) {

            $request->session()->regenerate();

            return response()->json([
                'success' => true,
            ], 203);
        }


        return response()->json([
            'success' => false,
        ], 422);
    }

    public function register($request)
    {
        if (auth()->user()) {
            return response()->json([
                'success' => false
            ], 400);
        }
        $user = $this->userService->create($request->all());
        auth()->login($user);

        return response()->json([
            'success' => true,
            'message' => 'User is already logged in'
        ], 200);
    }
}
