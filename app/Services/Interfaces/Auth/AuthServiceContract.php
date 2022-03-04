<?php

namespace App\Services\Interfaces\Auth;
use Illuminate\Http\JsonResponse;

interface AuthServiceContract
{
    public function login($request): JsonResponse;

    public function register($request): JsonResponse;
}
