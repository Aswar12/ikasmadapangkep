<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin IKA SMADA',
            'email' => 'admin@ikasmada.com',
            'username' => 'admin',
            'phone' => '081234567890',
            'password' => Hash::make('password'),
            'graduation_year' => '2000',
            'role' => 'admin',
            'active' => true,
            'approved' => true,
            'registration_date' => now(),
            'email_verified_at' => now(),
        ]);

        Profile::create([
            'user_id' => $admin->id,
            'graduation_year' => '2000',
            'phone' => '081234567890',
        ]);

        // Create Alumni User
        $alumni = User::create([
            'name' => 'Alumni Test',
            'email' => 'alumni@ikasmada.com',
            'username' => 'alumni_test',
            'phone' => '081234567891',
            'password' => Hash::make('password'),
            'graduation_year' => '2010',
            'role' => 'alumni',
            'active' => true,
            'approved' => true,
            'registration_date' => now(),
            'email_verified_at' => now(),
        ]);

        Profile::create([
            'user_id' => $alumni->id,
            'graduation_year' => '2010',
            'phone' => '081234567891',
        ]);

        // Create Department Coordinator
        $coordinator = User::create([
            'name' => 'Koordinator Departemen',
            'email' => 'koordinator@ikasmada.com',
            'username' => 'koordinator',
            'phone' => '081234567892',
            'password' => Hash::make('password'),
            'graduation_year' => '2005',
            'role' => 'department_coordinator',
            'active' => true,
            'approved' => true,
            'registration_date' => now(),
            'email_verified_at' => now(),
        ]);

        Profile::create([
            'user_id' => $coordinator->id,
            'graduation_year' => '2005',
            'phone' => '081234567892',
        ]);

        // Create Sub-Admin
        $subAdmin = User::create([
            'name' => 'Sub Admin',
            'email' => 'subadmin@ikasmada.com',
            'username' => 'subadmin',
            'phone' => '081234567893',
            'password' => Hash::make('password'),
            'graduation_year' => '2008',
            'role' => 'sub_admin',
            'active' => true,
            'approved' => true,
            'registration_date' => now(),
            'email_verified_at' => now(),
        ]);

        Profile::create([
            'user_id' => $subAdmin->id,
            'graduation_year' => '2008',
            'phone' => '081234567893',
        ]);

        // Create Pending Approval User
        $pending = User::create([
            'name' => 'User Pending',
            'email' => 'pending@ikasmada.com',
            'username' => 'pending_user',
            'phone' => '081234567894',
            'password' => Hash::make('password'),
            'graduation_year' => '2015',
            'role' => 'alumni',
            'active' => false,
            'approved' => false,
            'registration_date' => now(),
            'email_verified_at' => now(),
        ]);

        Profile::create([
            'user_id' => $pending->id,
            'graduation_year' => '2015',
            'phone' => '081234567894',
        ]);
    }
}
