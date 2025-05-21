<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@ikasmadapangkep.org',
            'password' => Hash::make('password'),
            'first_name' => 'Admin',
            'last_name' => 'IKA SMADA',
            'phone' => '081234567890',
            'role' => 'admin',
            'active' => true,
            'email_verified_at' => now(),
        ]);

        // Create Department Coordinator
        User::create([
            'name' => 'Koordinator Pendidikan',
            'username' => 'koordinator',
            'email' => 'koordinator@ikasmadapangkep.org',
            'password' => Hash::make('password'),
            'first_name' => 'Koordinator',
            'last_name' => 'Pendidikan',
            'phone' => '081234567891',
            'graduation_year' => '2010',
            'role' => 'department_coordinator',
            'active' => true,
            'email_verified_at' => now(),
        ]);

        // Create Sub Admin (Angkatan Coordinator)
        User::create([
            'name' => 'Koordinator Angkatan 2015',
            'username' => 'angkatan2015',
            'email' => 'angkatan2015@ikasmadapangkep.org',
            'password' => Hash::make('password'),
            'first_name' => 'Koordinator',
            'last_name' => 'Angkatan 2015',
            'phone' => '081234567892',
            'graduation_year' => '2015',
            'role' => 'sub_admin',
            'active' => true,
            'email_verified_at' => now(),
        ]);

        // Create Regular Alumni
        User::create([
            'name' => 'Alumni Demo',
            'username' => 'alumni',
            'email' => 'alumni@ikasmadapangkep.org',
            'password' => Hash::make('password'),
            'first_name' => 'Alumni',
            'last_name' => 'Demo',
            'phone' => '081234567893',
            'graduation_year' => '2018',
            'role' => 'alumni',
            'active' => true,
            'email_verified_at' => now(),
        ]);
    }
}
