<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
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
            'name' => $this->faker->unique()->name,
            'can_create' => $this->faker->randomElement([true, false]),
            'can_read' => $this->faker->randomElement([true, false]),
            'can_update' => $this->faker->randomElement([true, false]),
            'can_delete' => $this->faker->randomElement([true, false]),
            'on_table' => '*',
        ];
    }
}
