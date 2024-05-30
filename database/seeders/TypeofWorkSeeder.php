<?php

namespace Database\Seeders;

use App\Models\TypeofWork;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeofWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeofWork::insert([
            [
                'name' => 'Goutiere resine',
                'my_price' => '105',
                'lab_id' => '3',
                'second_lab_id' => '4',
                'external_lab_id' => '5',
            ],
            [
                'name' => 'Goutiere regide de 1 a 3 mm',
                'my_price' => '30',
                'lab_id' => '3',
                'second_lab_id' => '4',
                'external_lab_id' => '5',
            ],
            [
                'name' => 'BWS',
                'my_price' => '45',
                'lab_id' => '5',
                'second_lab_id' => '4',
                'external_lab_id' => '5',
            ],
            [
                'name' => 'Pendulum',
                'my_price' => '100',
                'lab_id' => '3',
                'second_lab_id' => '4',
                'external_lab_id' => '5',
            ],
        ]);
    }
}
