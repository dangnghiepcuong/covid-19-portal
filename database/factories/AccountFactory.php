<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AccountFactory extends Factory
{
    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'password' => '123',
            'role' => 2,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }
}
