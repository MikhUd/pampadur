<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->dateTimeBetween($startDate = '-1 week', $endDate = 'now'),
            'is_liked' => $this->faker->boolean(50),
        ];
    }
}
