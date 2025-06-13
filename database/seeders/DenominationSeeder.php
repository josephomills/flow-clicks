<?php

namespace Database\Seeders;

use App\Models\Denomination;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DenominationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $denominations = [
            [
                'name' => 'First Love Church - Accra', 
                'slug' => 'flc-accra', 
                'population' => 30_000,
                'city' => 'Accra',
                'country' => 'Ghana',
                'zone_id' => 1
    
            ], 
            [
                'name' => 'First Love Church - London', 
                'slug' => 'flc-london', 
                'population' => 30_000,
                'city' => 'London',
                'country' => 'United Kingdom',
                'zone_id' => 1
    
            ], 
            [
                'name' => 'First Love Church - Paris', 
                'slug' => 'flc-paris', 
                'population' => 30_000,
                'city' => 'Paris',
                'country' => 'France',
                'zone_id' => 2
    
            ],
            
            [
                'name' => 'Jesus is the Answer Church - Takoradi', 
                'slug' => 'jita-takoradi', 
                'population' => 30_000,
                'city' => 'Takoradi',
                'country' => 'Ghana',
                'zone_id' => 1
    
            ],
            [
                'name' => 'Precious Soul Church', 
                'slug' => 'psc', 
                'population' => 30_000,
                'city' => 'Accra',
                'country' => 'Ghana',
                'zone_id' => 1
    
            ]
        ];

        Denomination::insert($denominations);
    }
}
