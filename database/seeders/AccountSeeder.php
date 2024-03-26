<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountSeeder extends Seeder
{
    public function run()
    {
        DB::table('accounts')->insert([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123'),
            'role' => 1,
        ]);
    }
}
