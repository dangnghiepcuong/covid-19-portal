<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'id' => 1,
            'name' => 'role_admin',
            'can_create' => true,
            'can_read' => true,
            'can_update' => true,
            'can_delete' => true,
            'on_table' => 'accounts',
        ]);

        DB::table('roles')->insert([
            'name' => 'role_business',
            'can_create' => true,
            'can_read' => true,
            'can_update' => true,
            'can_delete' => true,
            'on_table' => 'businesses',
        ]);

        DB::table('roles')->insert([
            'name' => 'role_user',
            'can_create' => true,
            'can_read' => true,
            'can_update' => true,
            'can_delete' => true,
            'on_table' => 'users',
        ]);
    }
}
