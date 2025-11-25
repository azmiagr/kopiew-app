<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Place>
 */
class PlaceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $openHour = fake()->numberBetween(6, 10);
        $closeHour = fake()->numberBetween(20, 23);
        $openMinute = fake()->randomElement(['00', '30']);
        $closeMinute = fake()->randomElement(['00', '30']);

        return [
            'name' => fake()->company(),
            'address' => fake()->streetAddress(),
            'description' => fake()->text(),
            'operating_hours' => sprintf('%02d.%s-%02d.%s', $openHour, $openMinute, $closeHour, $closeMinute),
        ];
    }
}
