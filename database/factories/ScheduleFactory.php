<?php

namespace Database\Factories;

use App\Models\VaccineLot;
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
        $vaccineLot = VaccineLot::factory()->make();

        return [
            'business_id' => $vaccineLot->business()->id,
            'vaccine_lot_id' => $vaccineLot->id,
            'on_date' => $this->faker,    
        ];
    }
}
