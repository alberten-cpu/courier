<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'first_name' => 'Admin',
            'email' => 'admin@gmail.com',
            'mobile' => '7894561230',
            'password' => Hash::make('admin@123'),
            'role_id' => Role::ADMIN
        ]);
    }
}
