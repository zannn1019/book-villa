<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VillaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'Villa ' . $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'price_per_night' => $this->faker->numberBetween(500000, 3000000),
            'location' => $this->faker->city() . ', Bali',
            'capacity' => $this->faker->numberBetween(2, 10),
            'image' => "https://picsum.photos/" . $this->faker->numberBetween(1200, 2000) . "/" . $this->faker->numberBetween(800, 1200) . "?random",
        ];
    }
}
