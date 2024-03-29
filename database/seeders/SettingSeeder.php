<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = array(
            array(
                "id" => 1,
                "key" => "site_name",
                "value" => "Orthoveer",
                "created_at" => "2023-08-05 10:31:55",
                "updated_at" => "2023-08-06 06:19:16",
            ),
            array(
                "id" => 2,
                "key" => "site_default_currency",
                "value" => "USD",
                "created_at" => "2023-08-05 10:31:55",
                "updated_at" => "2023-08-06 06:56:35",
            ),
            array(
                "id" => 3,
                "key" => "site_currency_icon",
                "value" => "$",
                "created_at" => "2023-08-05 10:31:55",
                "updated_at" => "2023-08-14 03:43:30",
            ),
            array(
                "id" => 4,
                "key" => "pusher_app_id",
                "value" => "1771792",
                "created_at" => "2023-08-26 10:36:34",
                "updated_at" => "2023-08-26 10:36:34",
            ),
            array(
                "id" => 5,
                "key" => "pusher_key",
                "value" => "d4df6e945b74d2d9d897",
                "created_at" => "2023-08-26 10:36:34",
                "updated_at" => "2023-08-26 10:36:34",
            ),
            array(
                "id" => 6,
                "key" => "pusher_secret",
                "value" => "7a8fc70030ba3e6c82b8",
                "created_at" => "2023-08-26 10:36:34",
                "updated_at" => "2023-08-26 10:36:34",
            ),
            array(
                "id" => 7,
                "key" => "pusher_cluster",
                "value" => "ap2",
                "created_at" => "2023-08-26 10:36:34",
                "updated_at" => "2023-08-26 10:36:34",
            ),
            array(
                "id" => 8,
                "key" => "mail_driver",
                "value" => "smtp",
                "created_at" => "2023-09-10 06:35:57",
                "updated_at" => "2023-09-10 06:44:34",
            ),
            array(
                "id" => 9,
                "key" => "mail_host",
                "value" => "sandbox.smtp.mailtrap.io",
                "created_at" => "2023-09-10 06:35:57",
                "updated_at" => "2023-09-10 06:44:34",
            ),
            array(
                "id" => 10,
                "key" => "mail_port",
                "value" => "2525",
                "created_at" => "2023-09-10 06:35:57",
                "updated_at" => "2023-09-10 06:44:34",
            ),
            array(
                "id" => 11,
                "key" => "mail_username",
                "value" => "808ae887829cf7",
                "created_at" => "2023-09-10 06:35:57",
                "updated_at" => "2023-09-10 06:44:34",
            ),
            array(
                "id" => 12,
                "key" => "mail_password",
                "value" => "188d4565252515",
                "created_at" => "2023-09-10 06:35:57",
                "updated_at" => "2023-09-10 06:44:34",
            ),
            array(
                "id" => 13,
                "key" => "mail_encryption",
                "value" => "tls",
                "created_at" => "2023-09-10 06:35:57",
                "updated_at" => "2023-09-10 06:44:34",
            ),
            array(
                "id" => 14,
                "key" => "mail_from_address",
                "value" => "food_park@example.com",
                "created_at" => "2023-09-10 06:35:57",
                "updated_at" => "2023-09-10 06:44:34",
            ),
            array(
                "id" => 15,
                "key" => "mail_receive_address",
                "value" => "support.food_park@example.com",
                "created_at" => "2023-09-10 06:35:57",
                "updated_at" => "2023-09-10 06:44:34",
            ),
            array(
                "id" => 16,
                "key" => "logo",
                "value" => "/assets/logo.png",
                "created_at" => "2023-09-17 09:27:14",
                "updated_at" => "2023-09-17 10:05:49",
            ),
            array(
                "id" => 17,
                "key" => "favicon",
                "value" => "/assets/favicon.png",
                "created_at" => "2023-09-17 09:27:14",
                "updated_at" => "2023-09-17 09:28:55",
            ),
            array(
                "id" => 18,
                "key" => "site_email",
                "value" => "foodpark@gmail.com",
                "created_at" => "2023-09-17 11:18:32",
                "updated_at" => "2023-09-17 11:18:32",
            ),
            array(
                "id" => 19,
                "key" => "site_phone",
                "value" => "+96487452145214",
                "created_at" => "2023-09-17 11:18:32",
                "updated_at" => "2023-09-17 11:18:32",
            ),
            array(
                "id" => 20,
                "key" => "site_color",
                "value" => "#ed7011",
                "created_at" => "2023-09-18 04:02:41",
                "updated_at" => "2023-09-18 04:15:30",
            ),
        );

        \DB::table('settings')->insert($settings);
    }
}
