<?php

namespace Database\Factories;

use App\Models\DatingCard;
use App\Models\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'role_code' => UserRole::inRandomOrder()->first()->code,
            //Выбирает те картые которые еще не привязаны ни к одному пользователю.
            'dating_card_id' => DatingCard::whereNotExists(function ($query) {
                $query->select(DB::raw(1))->from('users')->whereColumn('users.dating_card_id', '=', 'dating_cards.id');
            })->inRandomOrder()->first(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

}
