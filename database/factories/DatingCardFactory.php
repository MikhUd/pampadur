<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DatingCardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->realText(rand(10, 50)),
            'about' => $this->faker->realText(rand(20, 80)),
            'gender' => rand(1, 2),
            'seeking_for' => rand(1, 2),
            'published_at' => rand(1, 2) == 1 ? $this->faker->dateTimeBetween('now','+14 days',null) : null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
