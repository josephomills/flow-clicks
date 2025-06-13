<?php

namespace Database\Seeders;

use App\Models\Zone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zones = [
            [
                'name' => 'Ghana',
                'slug' => 'gh',
                'country' => 'Ghana',
                
               
            ],
            [
                'name' => 'Languages',
                'slug' => 'lang',
                'country' => 'France,Germany',
                
               
            ],
            [
                'name' => 'Europe',
                'slug' => 'eu',
                'country' => 'Switzerland,Britain',
                
               
            ],
        
            ];

            Zone::insert($zones);
    }
}
