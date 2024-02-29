<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'first_name' => 'super',
                'last_name' => 'admin',
                'email' => 'superadmin@superadmin.com',
                'mobile' => null,
                'landline' => null,
                'address' => null,
                'postal_code' => null,
                'siret_number' => null,
                'role' => 'super_admin',
                'password' => bcrypt('password')
            ],
            [
                'first_name' => 'admin',
                'last_name' => 'admin',
                'email' => 'admin@admin.com',
                'mobile' => null,
                'landline' => null,
                'address' => null,
                'postal_code' => null,
                'siret_number' => null,
                'role' => 'admin',
                'password' => bcrypt('password')
            ],
            [
                'first_name' => 'doctor',
                'last_name' => 'doctor',
                'email' => 'doctor@doctor.com',
                'mobile' => '1234567890',
                'landline' => '0987654321',
                'address' => '123 Main St',
                'postal_code' => '12345',
                'siret_number' => '123 456 789 00112',
                'role' => 'doctor',
                'password' => bcrypt('password')
            ],
            [
                'first_name' => 'lab',
                'last_name' => 'lab',
                'email' => 'lab@lab.com',
                'mobile' => null,
                'landline' => null,
                'address' => null,
                'postal_code' => null,
                'siret_number' => null,
                'role' => 'lab',
                'password' => bcrypt('password')
            ],
            [
                'first_name' => 'external',
                'last_name' => 'lab',
                'email' => 'externallab@externallab.com',
                'mobile' => null,
                'landline' => null,
                'address' => null,
                'postal_code' => null,
                'siret_number' => null,
                'role' => 'external_lab',
                'password' => bcrypt('password')
            ],
        ]);
    }
}
