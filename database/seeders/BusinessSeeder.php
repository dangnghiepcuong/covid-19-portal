<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Account;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('businesses')->insert([
            'account_id' => Account::where('role', Role::ROLE['role_admin'])->min('id'),
            'tax_id' => '0658465463',
            'name' => 'Bộ Y tế',
            'addr_province' => 'Hà Nội',
            'addr_district' => 'Ba Đình',
            'addr_ward' => 'Kim Mã',
            'address' => '138A Giảng Võ',
            'contact' => '0246.273.2.273',
        ]);
    }
}
