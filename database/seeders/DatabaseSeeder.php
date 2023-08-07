<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Nationality;
use App\Models\TypeBlood;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $this->call([
            BloodTableSeeder::class,
        ]);


        $this->call([
            NationalityTableSeeder::class,
        ]);

        $this->call([
            ReligionTableSeeder::class,
        ]);
    }
}
