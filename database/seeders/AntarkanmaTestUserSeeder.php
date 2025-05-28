<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AntarkanmaTestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat user dengan identifier "aswarsumarlin" sesuai error yang muncul
        $users = [
            [
                'name' => 'Aswar Sumarlin',
                'email' => 'aswarsumarlin@antarkanma.com',
                'username' => 'aswarsumarlin',
                'whatsapp' => '081234567890',
                'password' => Hash::make('aswar123'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Admin Antarkanma',
                'email' => 'admin@antarkanma.com',
                'username' => 'admin',
                'whatsapp' => '081234567891',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'User Test',
                'email' => 'user@antarkanma.com',
                'username' => 'usertest',
                'whatsapp' => '081234567892',
                'password' => Hash::make('user123'),
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $userData) {
            // Cek apakah user sudah ada (berdasarkan email)
            $existingUser = User::where('email', $userData['email'])->first();
            
            if (!$existingUser) {
                User::create($userData);
                $this->command->info("✅ User {$userData['name']} berhasil dibuat");
            } else {
                $this->command->info("ℹ️ User {$userData['name']} sudah ada");
            }
        }

        $this->command->info("\n🎯 ANTARKANMA TEST USERS:");
        $this->command->table(
            ['Nama', 'Email', 'Username', 'WhatsApp', 'Password'],
            [
                ['Aswar Sumarlin', 'aswarsumarlin@antarkanma.com', 'aswarsumarlin', '081234567890', 'aswar123'],
                ['Admin Antarkanma', 'admin@antarkanma.com', 'admin', '081234567891', 'admin123'],
                ['User Test', 'user@antarkanma.com', 'usertest', '081234567892', 'user123'],
            ]
        );
        
        $this->command->info("\n📱 Format Login yang Didukung:");
        $this->command->info("• Email: aswarsumarlin@antarkanma.com");
        $this->command->info("• Username: aswarsumarlin");
        $this->command->info("• WhatsApp: 081234567890, 6281234567890, +6281234567890");
    }
}
