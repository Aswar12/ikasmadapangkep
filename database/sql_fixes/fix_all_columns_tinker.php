<?php

// Tinker script untuk menambahkan SEMUA kolom yang dibutuhkan
// Jalankan dengan: php artisan tinker < fix_all_columns_tinker.php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "🔧 Memperbaiki SEMUA kolom yang dibutuhkan di tabel users...\n\n";

// Kolom untuk login tracking
$loginColumns = [
    'last_login_at' => 'TIMESTAMP NULL DEFAULT NULL',
    'login_count' => 'INT UNSIGNED NOT NULL DEFAULT 0', 
    'failed_login_attempts' => 'INT UNSIGNED NOT NULL DEFAULT 0',
    'login_locked_until' => 'TIMESTAMP NULL DEFAULT NULL'
];

// Kolom role
$roleColumn = [
    'role' => "ENUM('admin', 'sub_admin', 'department_coordinator', 'alumni') DEFAULT 'alumni'"
];

// Kolom lainnya
$otherColumns = [
    'username' => 'VARCHAR(50) NULL',
    'whatsapp' => 'VARCHAR(20) NULL'
];

$allColumns = array_merge($loginColumns, $roleColumn, $otherColumns);

echo "📋 Memeriksa dan menambahkan kolom...\n";
echo "=====================================\n";

foreach ($allColumns as $column => $definition) {
    if (!Schema::hasColumn('users', $column)) {
        try {
            // Tentukan posisi kolom
            $afterColumn = 'name'; // default after name
            
            // Posisi khusus untuk beberapa kolom
            if ($column === 'username') $afterColumn = 'name';
            if ($column === 'whatsapp') $afterColumn = 'email';
            if ($column === 'role') $afterColumn = 'password';
            
            DB::statement("ALTER TABLE `users` ADD COLUMN `{$column}` {$definition} AFTER `{$afterColumn}`");
            echo "✅ Kolom '{$column}' berhasil ditambahkan\n";
        } catch (\Exception $e) {
            echo "❌ Gagal menambahkan kolom '{$column}': " . $e->getMessage() . "\n";
        }
    } else {
        echo "ℹ️  Kolom '{$column}' sudah ada\n";
    }
}

// Update user tanpa role
echo "\n🔄 Memeriksa user tanpa role...\n";
$usersWithoutRole = DB::table('users')->whereNull('role')->orWhere('role', '')->count();
if ($usersWithoutRole > 0) {
    echo "⚠️  Ada {$usersWithoutRole} user tanpa role. Mengupdate ke 'alumni'...\n";
    DB::table('users')->whereNull('role')->orWhere('role', '')->update(['role' => 'alumni']);
    echo "✅ Semua user tanpa role telah diupdate ke 'alumni'\n";
} else {
    echo "✅ Semua user sudah memiliki role\n";
}

// Tampilkan statistik role
echo "\n📊 Statistik role user:\n";
echo "=====================================\n";
$roleStats = DB::table('users')->select('role', DB::raw('count(*) as total'))
    ->groupBy('role')
    ->get();

foreach ($roleStats as $stat) {
    echo sprintf("%-25s: %d user\n", $stat->role ?: 'Tidak ada role', $stat->total);
}

echo "\n✅ Selesai! Semua kolom telah diperiksa dan ditambahkan.\n";
