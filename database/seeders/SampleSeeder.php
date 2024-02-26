<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class SampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $samples = [
            [
                'doctor_id' => 3, // assuming a doctor_id of 1, you'll need to adjust this based on your actual data
                'scan_date' => Carbon::createFromFormat('d/m/Y', '05/12/2023'),
                'order_id' => '146186184',
                'patient_name' => 'GARCON, Juliana',
                'practitioner' => 'Najim, Nicolas',
                'cabinet' => 'Orthodontie Exclusive',
                'procedure' => 'Modèle d’étude / Record',
                'due_date' => Carbon::createFromFormat('d/m/Y', '19/12/2023'),
                'status' => 'return',
            ],
            [
                'doctor_id' => 3, // assuming a doctor_id of 1, you'll need to adjust this based on your actual data
                'scan_date' => Carbon::createFromFormat('d/m/Y', '05/12/2023'),
                'order_id' => '146186184',
                'patient_name' => 'GARCON, Juliana',
                'practitioner' => 'Najim, Nicolas',
                'cabinet' => 'Orthodontie Exclusive',
                'procedure' => 'Modèle d’étude / Record',
                'due_date' => Carbon::createFromFormat('d/m/Y', '19/12/2023'),
                'status' => 'done',
            ],

            // Add more cases based on the image you provided
        ];

        foreach ($samples as $sample) {
            DB::table('samples')->insert([
                'doctor_id' => $sample['doctor_id'],
                'scan_date' => $sample['scan_date'],
                'order_id' => $sample['order_id'],
                'patient_name' => $sample['patient_name'],
                'practitioner' => $sample['practitioner'],
                'cabinet' => $sample['cabinet'],
                'procedure' => $sample['procedure'],
                'due_date' => $sample['due_date'],
                'status' => $sample['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
