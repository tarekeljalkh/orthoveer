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
                'price' => '105',
                'category_id' => '1',
                'lab_id' => '4',
            ],
            [
                'name' => 'Goutiere regide de 1 a 3 mm',
                'price' => '30',
                'category_id' => '1',
                'lab_id' => '4',
            ],
            [
                'name' => 'BWS',
                'price' => '45',
                'category_id' => '2',
                'lab_id' => '4',
            ],
            [
                'name' => 'Pendulum',
                'price' => '100',
                'category_id' => '2',
                'lab_id' => '4',
            ],
        ]);
    }
}
