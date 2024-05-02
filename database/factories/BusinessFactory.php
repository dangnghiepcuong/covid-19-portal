<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BusinessFactory extends Factory
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
            'tax_id' => strval($this->faker->randomNumber(9)),
            'name' => $this->faker->name,
            'addr_province' => '1',
            'addr_province_name' => 'Hồ Chí Minh',
            'addr_district' => '1',
            'addr_district_name' => 'Bình Chánh',
            'addr_ward' => '1',
            'addr_ward_name' => 'An Phú Tây',
            'address' => '',
            'contact' => '',
        ];
    }
}
