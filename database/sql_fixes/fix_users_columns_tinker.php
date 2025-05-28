<?php

// Tinker script untuk menambahkan kolom-kolom yang hilang
// Jalankan dengan: php artisan tinker < fix_users_columns_tinker.php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "🔧 Memperbaiki kolom-kolom yang hilang di tabel users...\n";

$columnsToAdd = [
    'last_login_at' => 'TIMESTAMP NULL DEFAULT NULL',
    'login_count' => 'INT UNSIGNED NOT NULL DEFAULT 0', 
    'failed_login_attempts' => 'INT UNSIGNED NOT NULL DEFAULT 0',
    'login_locked_until' => 'TIMESTAMP NULL DEFAULT NULL'
];

foreach ($columnsToAdd as $column => $definition) {
    if (!Schema::hasColumn('users', $column)) {
        try {
            DB::statement("ALTER TABLE `users` ADD COLUMN `{$column}` {$definition}");
            echo "✅ Kolom '{$column}' berhasil ditambahkan\n";
        } catch (\Exception $e) {
            echo "❌ Gagal menambahkan kolom '{$column}': " . $e->getMessage() . "\n";
        }
    } else {
        echo "ℹ️  Kolom '{$column}' sudah ada\n";
    }
}

echo "\n✅ Selesai!\n";
