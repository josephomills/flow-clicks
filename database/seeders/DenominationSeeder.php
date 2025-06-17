<?php

namespace Database\Seeders;

use App\Models\Denomination;
use Illuminate\Database\Seeder;

class DenominationSeeder extends Seeder
{
    public function run(): void
    {
        $denominations = [
            [
                'name' => 'Good Shepherd Church', 
                'slug' => 'gsc', 
                'avg_attendance' => 0,
                'city' => 'Unknown',
                'country' => 'Guyana', // From Non-GMT zone
                'zone_id' => 5,
            ],
            [
                'name' => 'Jesus is the Door', 
                'slug' => 'jitd', 
                'avg_attendance' => 0,
                'city' => 'Unknown',
                'country' => 'Ghana',
                'zone_id' => 1,
            ],
            [
                'name' => 'First Love Church', 
                'slug' => 'flc', 
                'avg_attendance' => 0,
                'city' => 'Accra',
                'country' => 'Ghana',
                'zone_id' => 1,
            ],
            [
                'name' => 'First Love Church - London', 
                'slug' => 'flc-london', 
                'avg_attendance' => 0,
                'city' => 'London',
                'country' => 'United Kingdom',
                'zone_id' => 3, // Possibly Europe zone
            ],
            [
                'name' => 'First Love Church - Paris', 
                'slug' => 'flc-paris', 
                'avg_attendance' => 0,
                'city' => 'Paris',
                'country' => 'France',
                'zone_id' => 2,
            ],
            [
                'name' => 'Jesus is the Answer Church', 
                'slug' => 'jita', 
                'avg_attendance' => 0,
                'city' => 'Takoradi',
                'country' => 'Ghana',
                'zone_id' => 1,
            ],
            [
                'name' => 'Precious Soul Church', 
                'slug' => 'psc', 
                'avg_attendance' => 0,
                'city' => 'Accra',
                'country' => 'Ghana',
                'zone_id' => 1,
            ],
        ];

        Denomination::insert($denominations);
    }
}
