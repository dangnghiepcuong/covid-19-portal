<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'on_date' => now(),
            'day_shift_limit' => 100,
            'noon_shift_limit' => 100,
            'night_shift_limit' => 100,
        ];
    }
}
