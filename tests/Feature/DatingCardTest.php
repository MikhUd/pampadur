<?php

namespace Tests\Feature;

use App\Models\DatingCard;
use App\Models\Like;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;


class DatingCardTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function createLike_test()
    {
        DB::beginTransaction();
        $userData = $this->getUser();

        $user = User::create($userData);

        $datingCardData = $this->getDatingCard();

        $datingCard = DatingCard::create($datingCardData);

        $data = [
            'liker_id' => $datingCard->id,
            'liked_id' => Like::select('liked_id')->where('liker_id', '!=', $datingCard->id)->first()->liked_id,
            'is_liked' => 1,
        ];
        $response = $this->actingAs($user)->post('/api/like/set', $data);
        $this->assertEquals(200, $response->status());
        $like = Like::where($data)->first();
        $this->assertNotNull($like);
        $response = $this->post('/api/like/set', $data);
        $this->assertEquals(403, $response->status());
        DB::rollBack();
    }
}
