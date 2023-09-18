<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['key' => 'current_session', 'value' => '2023-2024'],
            ['key' => 'school_title', 'value' => 'BS'],
            ['key' => 'school_name', 'value' => 'Elbeik International Schools'],
            ['key' => 'end_first_term', 'value' => '01-12-2023'],
            ['key' => 'end_second_term', 'value' => '01-03-2024'],
            ['key' => 'phone', 'value' => '0598729108'],
            ['key' => 'address', 'value' => 'غزة'],
            ['key' => 'school_email', 'value' => 'aboodelbeik3@gmail.com'],
            ['key' => 'logo', 'value' => '1.jpg'],
        ];

        DB::table('settings')->insert($data);
    }
}
