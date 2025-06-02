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
        // Create test users with different login methods
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'username' => 'admin',
                'whatsapp' => '081234567890',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'admin',
                'status' => 'approved',
            ],
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'username' => 'johndoe',
                'whatsapp' => '081234567891',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'username' => 'janesmith',
                'whatsapp' => '081234567892',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'username' => 'testuser',
                'whatsapp' => '081234567893',
                'password' => Hash::make('testpass'),
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        $this->command->info('Test users created successfully!');
        $this->command->table(
            ['Email', 'Username', 'WhatsApp', 'Password'],
            [
                ['admin@example.com', 'admin', '081234567890', 'password'],
                ['john@example.com', 'johndoe', '081234567891', 'password123'],
                ['jane@example.com', 'janesmith', '081234567892', 'password123'],
                ['test@example.com', 'testuser', '081234567893', 'testpass'],
            ]
        );
    }
}
