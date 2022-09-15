<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;


class AuthTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function registration_test()
    {
        DB::beginTransaction();
        $data = $this->getUser();
        $response = $this->post('/api/register', $data);
        $this->assertEquals(201, $response->status());
        $createdUser = User::where('email', $data['email'])->first();
        $this->assertNotNull($createdUser);
        DB::rollBack();
    }

    /**
     * @test
     */
    public function authenticate_test()
    {
        DB::beginTransaction();
        $data = $this->getUser();

        User::create($data);

        $response = $this->post('/api/get-token', Arr::only($data, ['email', 'password']));
        $this->assertEquals(200, $response->status());
        DB::rollBack();
    }

    /**
     * @test
     */
    public function repeatedAuthenticate_test()
    {
        DB::beginTransaction();
        $data = $this->getUser();

        $user = User::create($data);
        $this->actingAs($user);

        $response = $this->postJson('/api/get-token', Arr::only($data, ['email', 'password']));

        $response->assertStatus(200);
        $response->assertJson(fn($json) => $json->where('success', false)->etc());
        DB::rollBack();
    }
}
