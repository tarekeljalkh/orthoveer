<?php
namespace Database\Seeders;

use App\Models\User;
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
                'first_name' => 'admin',
                'last_name' => 'admin',
                'email' => 'admin@admin.com',
                'mobile' => null,
                'landline' => null,
                'address' => null,
                'siret_number' => null,
                'role' => 'admin',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'street' => null,
                'suburb' => null,
                'postcode' => null,
                'country' => null,
            ],
            [
                'first_name' => 'doctor',
                'last_name' => 'doctor',
                'email' => 'doctor@doctor.com',
                'mobile' => '1234567890',
                'landline' => '0987654321',
                'address' => '123 Main St',
                'siret_number' => '123 456 789 00112',
                'role' => 'doctor',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'street' => '456 Doctor St',
                'suburb' => 'MediCity',
                'postcode' => 'HealthState',
                'country' => 'MedLand',
            ],
            [
                'first_name' => 'lab',
                'last_name' => 'lab',
                'email' => 'lab@lab.com',
                'mobile' => null,
                'landline' => null,
                'address' => null,
                'siret_number' => null,
                'role' => 'lab',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'street' => null,
                'suburb' => null,
                'postcode' => null,
                'country' => null,
            ],
            [
                'first_name' => 'Second',
                'last_name' => 'second lab',
                'email' => 'secondlab@secondlab.com',
                'mobile' => null,
                'landline' => null,
                'address' => null,
                'siret_number' => null,
                'role' => 'second_lab',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'street' => null,
                'suburb' => null,
                'postcode' => null,
                'country' => null,
            ],
            [
                'first_name' => 'external',
                'last_name' => 'lab',
                'email' => 'externallab@externallab.com',
                'mobile' => null,
                'landline' => null,
                'address' => null,
                'siret_number' => null,
                'role' => 'external_lab',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'street' => null,
                'suburb' => null,
                'postcode' => null,
                'country' => null,
            ],
        ]);
    }
}
