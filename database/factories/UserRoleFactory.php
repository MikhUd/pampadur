<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserRoleFactory extends Factory
{

    public function definition()
    {
        return [
            'code' => Str::random(10)
        ];
    }
}
