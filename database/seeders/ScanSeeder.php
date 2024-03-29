<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class ScanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $scans = [
            [
                'doctor_id' => 3, // assuming a doctor_id of 1, you'll need to adjust this based on your actual data
                'patient_id' => 1,
                'scan_date' => Carbon::createFromFormat('d/m/Y', '05/12/2023'),
                'practitioner' => 'Najim, Nicolas',
                'cabinet' => 'Orthodontie Exclusive',
                'procedure' => 'Modèle d’étude / Record',
                'due_date' => Carbon::createFromFormat('d/m/Y', '19/12/2023'),
                'status' => 'pending',
            ],
            [
                'doctor_id' => 3, // assuming a doctor_id of 1, you'll need to adjust this based on your actual data
                'patient_id' => 1,
                'scan_date' => Carbon::createFromFormat('d/m/Y', '05/12/2023'),
                'practitioner' => 'Najim, Nicolas',
                'cabinet' => 'Orthodontie Exclusive',
                'procedure' => 'Modèle d’étude / Record',
                'due_date' => Carbon::createFromFormat('d/m/Y', '19/12/2023'),
                'status' => 'pending',
            ],

            // Add more cases based on the image you provided
        ];

        foreach ($scans as $scan) {
            DB::table('scans')->insert([
                'doctor_id' => $scan['doctor_id'],
                'patient_id' => $scan['patient_id'],
                'scan_date' => $scan['scan_date'],
                'practitioner' => $scan['practitioner'],
                'cabinet' => $scan['cabinet'],
                'procedure' => $scan['procedure'],
                'due_date' => $scan['due_date'],
                'status' => $scan['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
