<?php

namespace Tests;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, WithFaker;

    protected function getUser(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'testpassword',
            'password_confirmation' => 'testpassword',
            'role_code' => User::DEFAULT_USER_ROLE_CODE
        ];
    }

    protected function getDatingCard(): array
    {
        return [
            'name' => $this->faker->realText(rand(10, 50)),
            'about' => $this->faker->realText(rand(20, 80)),
            'gender' => rand(1, 2),
            'seeking_for' => rand(1, 2),
            'published_at' => rand(1, 2) == 1 ? $this->faker->dateTimeBetween('now','+14 days',null) : null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }
}
