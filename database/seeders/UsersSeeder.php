<?php

namespace Database\Seeders;

use App\Models\Denomination;
use App\Models\Priviledge;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch the password from the .env file
        $adminPassword = env('SUPER_USER_PASSWORD', 'admin@12345');
        // Create a specific user for the admin
        $superAdmin = User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Super',
            'name' => 'sudoX',
            'role' => 'admin', // Set the role as 'admin'
            'email' => 'admin@gmail.com',
            'password' => bcrypt($adminPassword), // Provide the password and hash it
        ]);

   // Attach all denominations to the admin user
        $allDenominationIds = Denomination::pluck('id')->toArray();
        $superAdmin->denominations()->sync($allDenominationIds);
    }
}
