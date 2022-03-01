<?php

namespace App\Services\Interfaces\Auth;

interface AuthServiceContract
{
    public function login($request);

    public function register($request);
}
