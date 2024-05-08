<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UserSeeder::class,
        ]);

        \App\Models\Patient::factory(4)->create();

        $this->call([
            TypeofWorkSeeder::class,
            ScanSeeder::class,
            StatusSeeder::class,
            ChatSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
