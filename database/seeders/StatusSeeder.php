<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch IDs of existing scans
        $scanIds = DB::table('scans')->pluck('id');

        // Define possible status values
        $statuses = ['pending', 'completed', 'rejected', 'resubmitted', 'delivered'];

        // Iterate over each scan ID and create a status for each
        foreach ($scanIds as $scanId) {
            DB::table('statuses')->insert([
                'scan_id' => $scanId,
                'status' => $statuses[array_rand($statuses)], // Random status for each scan
                'note' => 'Automatically generated status.', // Optional note
                'updated_by' => 3, // Could be a user ID or null
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
