<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\Role;
use App\Models\Vaccine;
use Illuminate\Database\Eloquent\Factories\Factory;

class VaccineLotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $vaccine = Vaccine::factory()->make([
            'is_allow' => true,
        ]);

        $role = Role::factory()->make();

        $business = Business::factory()->make([
            'role_id' => $role->id,
        ]);

        return [
            'created_at' => now(),
            'updated_at' => now(),
            'vaccine_id' => $vaccine->id,
            'lot' => $this->faker->buildingNumber(),
            'business_id' => $business->id,
            'quantity' => $this->faker->numberBetween(0,99999),
            'import_date' => now(),
            'expiry_date' => 365,
        ];
    }
}
