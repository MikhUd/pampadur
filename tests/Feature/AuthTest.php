<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;


class AuthTest extends TestCase
{
    use WithFaker;

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
