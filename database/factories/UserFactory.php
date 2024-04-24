<?php

namespace Database\Factories;

use App\Enums\GenderType;
use App\Enums\Role;
use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $account = Account::factory()->make([
            'role_id' => Role::ROLE_USER,
        ]);

        return [
            'account_id' => $account->id,
            'pid' => strval($this->faker->unique()->randomDigit()),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'gender' => $this->faker->randomElement(GenderType::allCases()),
            'addr_province' => '1',
            'addr_province_name' => 'Hồ Chí Minh',
            'addr_district' => '1',
            'addr_district_name' => 'Bình Chánh',
            'addr_ward' => '1',
            'addr_ward_name' => 'An Phú Tây',
            'birthday' => $this->faker->date(),
            'contact' => $this->faker->phoneNumber(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
