<?php

namespace Tests\Feature;

use App\Models\User;
use Faker\Factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use WithFaker;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->faker = Factory::create();
    }

    /** @test */
    public function registration_test()
    {
        $data = [
            'email' => $this->faker->unique()->safeEmail,
            'name' => $this->faker->name,
            'password' => 'testpassword'
        ];

        $this->post('/registration', $data);
        $this->assertResponseStatus(200);

        $createdUser = User::where('email', $data['email'])->first();
        $this->assertNotNull($createdUser);
        $this->assertEquals($createdUser->email, auth()->user()->email);
    }
}
