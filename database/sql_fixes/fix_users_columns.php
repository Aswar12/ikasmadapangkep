<?php

// Script untuk menambahkan kolom-kolom yang hilang di tabel users
// Jalankan dengan: php fix_users_columns.php

require_once __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

try {
    echo "Memeriksa dan menambahkan kolom-kolom yang hilang...\n";
    
    // Cek dan tambahkan kolom last_login_at
    if (!Schema::hasColumn('users', 'last_login_at')) {
        DB::statement('ALTER TABLE `users` ADD COLUMN `last_login_at` TIMESTAMP NULL DEFAULT NULL');
        echo "✅ Kolom 'last_login_at' berhasil ditambahkan\n";
    } else {
        echo "ℹ️ Kolom 'last_login_at' sudah ada\n";
    }
    
    // Cek dan tambahkan kolom login_count
    if (!Schema::hasColumn('users', 'login_count')) {
        DB::statement('ALTER TABLE `users` ADD COLUMN `login_count` INT UNSIGNED NOT NULL DEFAULT 0');
        echo "✅ Kolom 'login_count' berhasil ditambahkan\n";
    } else {
        echo "ℹ️ Kolom 'login_count' sudah ada\n";
    }
    
    // Cek dan tambahkan kolom failed_login_attempts
    if (!Schema::hasColumn('users', 'failed_login_attempts')) {
        DB::statement('ALTER TABLE `users` ADD COLUMN `failed_login_attempts` INT UNSIGNED NOT NULL DEFAULT 0');
        echo "✅ Kolom 'failed_login_attempts' berhasil ditambahkan\n";
    } else {
        echo "ℹ️ Kolom 'failed_login_attempts' sudah ada\n";
    }
    
    // Cek dan tambahkan kolom login_locked_until
    if (!Schema::hasColumn('users', 'login_locked_until')) {
        DB::statement('ALTER TABLE `users` ADD COLUMN `login_locked_until` TIMESTAMP NULL DEFAULT NULL');
        echo "✅ Kolom 'login_locked_until' berhasil ditambahkan\n";
    } else {
        echo "ℹ️ Kolom 'login_locked_until' sudah ada\n";
    }
    
    // Tampilkan struktur tabel setelah update
    echo "\n📋 Struktur tabel 'users' setelah update:\n";
    echo "----------------------------------------\n";
    
    $columns = DB::select('DESCRIBE users');
    foreach ($columns as $column) {
        echo sprintf("%-25s %-20s %s %s\n", 
            $column->Field, 
            $column->Type, 
            $column->Null === 'NO' ? 'NOT NULL' : 'NULL',
            $column->Key ? "({$column->Key})" : ''
        );
    }
    
    echo "\n✅ Semua kolom berhasil ditambahkan/diverifikasi!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
