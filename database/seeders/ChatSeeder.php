<?php

namespace Database\Seeders;

use App\Models\Chat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Chat::insert([
            [
                'sender_id' => '2',
                'receiver_id' => '3',
                'message' => 'welcome to orthoveer',
                'seen' => 0,
            ],
            [
                'sender_id' => '3',
                'receiver_id' => '2',
                'message' => 'welcome to orthoveer',
                'seen' => 0,
            ],
            [
                'send_id' => '3',
                'receiver_id' => '4',
                'message' => 'welcome to orthoveer',
                'seen' => 0,
            ],
            [
                'sender_id' => '4',
                'receiver_id' => '3',
                'message' => 'welcome to orthoveer',
                'seen' => 0,
            ],
            [
                'sender_id' => '4',
                'receiver_id' => '5',
                'message' => 'welcome to orthoveer',
                'seen' => 0,

            ],
            [
                'sender_id' => '5',
                'receiver_id' => '4',
                'message' => 'welcome to orthoveer',
                'seen' => 0,

            ],

        ]);

    }
}
