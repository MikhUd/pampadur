<?php

namespace Database\Seeders;

use App\Models\DatingCard;
use App\Models\Like;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datingCardIds = DatingCard::all()->pluck('id');

        Like::factory(500)
            ->sequence(fn ($sequence) => [
                'liker_id' => $datingCardIds[$sequence->index],
                'liked_id' => $datingCardIds[count($datingCardIds)-$sequence->index - 1],
            ])
            ->create();
    }
}
