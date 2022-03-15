<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;


class AuthTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function registration_test()
    {
        $data = [
            'email' => $this->faker->unique()->safeEmail,
            'name' => $this->faker->name,
            'password' => 'testpassword',
            'password_confirmation' => 'testpassword',
        ];
        $this->post('/api/register', $data);
        $this->assertResponseStatus(201);
        $createdUser = User::where('email', $data['email'])->first();
        $this->assertNotNull($createdUser);
    }

    /**
     * @test
     */
    public function authenticate_test()
    {
        $data = [
            'email' => $this->faker->unique()->safeEmail,
            'name' => $this->faker->name,
            'password' => 'testpassword',
            'password_confirmation' => 'testpassword',
            'role_code' => User::DEFAULT_USER_ROLE_CODE
        ];

        User::create($data);

        $this->post('/api/get-token', Arr::only($data, ['email', 'password']));
        $this->assertResponseStatus(200);

    }
}
