<?php

namespace Database\Seeders;

use App\Models\LinkType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LinkTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types =[
            ['name' => 'facebook', 'slug'=> 'fb'],
            ['name' => 'youtube', 'slug'=> 'yt'],
            ['name' => 'twitter', 'slug'=> 'x'],
        ];

        LinkType::insert($types);
               
}

}