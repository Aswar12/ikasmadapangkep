<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed departments
        $this->call(DepartmentSeeder::class);
        
        // Create admin user
        \App\Models\User::factory()->create([
            'name' => 'Admin IKA SMADA',
            'email' => 'admin@ikasmadapangkep.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'status' => 'approved',
            'email_verified_at' => now(),
        ]);
        
        // You can add more seeders here
        // $this->call(UserSeeder::class);
    }
}
