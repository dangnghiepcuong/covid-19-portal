<?php

namespace Database\Factories;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class AccountFactory extends Factory
{
    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('Aa@123456'),
            'role_id' => $this->faker->randomElement(Role::allCases()),
            'email_verified_at' => now(),
        ];
    }
}
