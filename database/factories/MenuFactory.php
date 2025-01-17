<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'image' => $this->faker->imageUrl(),
            'price' => $this->faker->randomElement([10000, 20000, 30000, 40000, 50000]),
            'description' => $this->faker->sentence,
            'status' => $this->faker->randomElement(['available', 'unavailable']),
        ];
    }
}
