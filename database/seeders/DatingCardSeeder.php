<?php

namespace Database\Seeders;

use App\Models\DatingCard;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatingCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DatingCard::factory(10)->create();

        // Добавляет к каждой DatingCard 5 рандомных тегов
        DatingCard::all()->each(function ($card) {
            $card->tags()->attach(Tag::inRandomOrder()->limit(5)->get());
        });

    }
}
