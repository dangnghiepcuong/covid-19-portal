<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VaccineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => $this->faker->name,
            'supplier' => $this->faker->name,
            'technology' => $this->faker->name,
            'country' => $this->faker->country,
            'is_allow' => $this->faker->boolean(50),
        ];
    }
}
