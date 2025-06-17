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
                'country' => 'France,Togo,Ivory Coast,Angola,Sao Tome,Spain,Brazil',
                
               
            ],
            [
                'name' => 'Europe',
                'slug' => 'eu',
                'country' => 'Switzerland,Britain',
                
               
            ],
            [
                'name' => 'Africa',
                'slug' => 'africa',
                'country' => 'Zambia,Kenya,South Africa,Zimbabwe',
                
               
            ],
            [
                'name' => 'Non-GMT',
                'slug' => 'non-gmt',
                'country' => 'Guyana,USA,PNG,Fiji',
                
               
            ],
        
            ];

            Zone::insert($zones);
    }
}
