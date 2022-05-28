<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;


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
            'password' => 'testpassword',
            'password_confirmation' => 'testpassword',
        ];
        $response = $this->post('/api/register', $data);
        $this->assertEquals(201, $response->status());
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
            'password' => 'testpassword',
            'password_confirmation' => 'testpassword',
            'role_code' => User::DEFAULT_USER_ROLE_CODE
        ];

        User::create($data);

        $response = $this->post('/api/get-token', Arr::only($data, ['email', 'password']));
        $this->assertEquals(200, $response->status());

    }

    /**
     * @test
     */
    public function repeatedAuthenticate_test()
    {
        $data = [
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'testpassword',
            'password_confirmation' => 'testpassword',
            'role_code' => User::DEFAULT_USER_ROLE_CODE
        ];

        $user = User::create($data);
        $this->actingAs($user);

        $response = $this->postJson('/api/get-token', Arr::only($data, ['email', 'password']));

        $response->assertStatus(200);
        $response->assertJson(fn($json) => $json->where('success', false)->etc());
    }
}
