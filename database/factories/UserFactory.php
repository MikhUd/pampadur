<?php

namespace Database\Factories;

use App\Models\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

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
            'email' => $this->faker->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'role_code' => UserRole::inRandomOrder()->first()->code,
            'user_location' => '53.'.rand(65, 90).'50000'.','.'87.'.rand(20, 45).'40000',
            'birth_date' => $this->faker->dateTimeBetween($startDate = '-35 years', $endDate = '-18 years'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

}
