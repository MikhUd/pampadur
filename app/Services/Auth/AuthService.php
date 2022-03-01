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
            Log::info('User successfully logged in', ['email' => $request->email]);

            $request->session()->regenerate();
            
            return response()->json([
                'success' => true,
            ], 203);
        }
        
        Log::error('Attempt to login failed', ['email' => $request->email]);

        return response()->json([
            'success' => false,
        ], 422);
    }

    public function register($request)
    {
        return $this->userService->create($request->all());
    }
}
