<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            ZoneSeeder::class,
            DenominationSeeder::class,
            UsersSeeder::class,
            LinkTypeSeeder::class
        ]);

        // Create 10 dummy users
        
        // User::factory(10)->create();

        
    }
}
