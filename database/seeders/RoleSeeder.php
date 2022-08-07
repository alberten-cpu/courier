<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'role' => 'Admin',
            'role_identifier' => 'admin',
            'role_level' => 1,
            'status' => true,
        ]);

        Role::create([
            'role' => 'Customer',
            'role_identifier' => 'customer',
            'role_level' => 2,
            'status' => true,
        ]);

        Role::create([
            'role' => 'Driver',
            'role_identifier' => 'driver',
            'role_level' => 3,
            'status' => true,
        ]);
    }
}
