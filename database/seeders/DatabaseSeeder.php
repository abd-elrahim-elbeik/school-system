<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Nationality;
use App\Models\TypeBlood;
use Illuminate\Database\Seeder;
use SettingsTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'name' => 'super_admin',
            'email' => 'super_admin@app.cpm',
            'password' => 'password'
        ]);

        $this->call([
            BloodTableSeeder::class,
            NationalityTableSeeder::class,
            ReligionTableSeeder::class,
            GenderSeeder::class,
            SpecializationSeeder::class,
            SettingsTableSeeder::class,
        ]);

    }
}
