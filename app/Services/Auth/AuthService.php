<?php

namespace App\Services\Auth;

use App\Services\Interfaces\Auth\AuthServiceContract;
use App\Services\Interfaces\UserServiceContract;

class AuthService implements AuthServiceContract
{
    private $userService;

    public function __construct(UserServiceContract $userService)
    {
        $this->userService = $userService;
    }

    public function login($request)
    {
        if (auth()->user()) {
            return response()->json([
                'success' => false,
                'message' => 'User is already logged in'
            ], 200);
        }
        if (auth()->attempt($request->all())) {

            $request->session()->regenerate();

            return response()->json([
                'success' => true,
            ], 203);
        }


        return response()->json([
            'success' => false,
        ]);
    }

    public function register($request)
    {
        if (auth()->user()) {
            return response()->json([
                'success' => false,
                'message' => 'User is already logged in'
            ], 200);
        }
        $user = $this->userService->create($request->all());
        auth()->login($user);

        return response()->json([
            'success' => true,
        ]);
    }
}
