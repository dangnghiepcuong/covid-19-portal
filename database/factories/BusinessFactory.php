<?php

namespace Database\Factories;

use App\Enums\Role;
use App\Models\Account;
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
        $account = Account::factory()->make([
            'role_id' => Role::ROLE_BUSINESS,
        ]);

        return [
            'account_id' => $account->id,
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
            'address' => $this->faker->address,
            'contact' => $this->faker->phoneNumber(),
        ];
    }
}
