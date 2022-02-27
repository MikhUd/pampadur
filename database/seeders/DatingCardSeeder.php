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
        DatingCard::factory(10)->create()->each(function ($card) {
            $card->tags()->attach(Tag::inRandomOrder()->limit(5)->get());
            $card->user()->associate(User::whereNotExists(function ($query) {
                $query->select(DB::raw(1))->from('dating_cards')->whereColumn('user_id', 'users.id');
            })->inRandomOrder()->first())->save();
        });

    }
}
