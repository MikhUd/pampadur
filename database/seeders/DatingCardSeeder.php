<?php

namespace Database\Seeders;

use App\Models\DatingCard;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatingCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DatingCard::factory(1000)->create()->each(function ($card) {
            $card->tags()->attach(Tag::inRandomOrder()->limit(5)->get());
            $card->user()->associate(User::doesntHave("datingCard")->inRandomOrder()->first())->save();
        });
    }
}
