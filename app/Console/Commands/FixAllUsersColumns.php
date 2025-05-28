<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixAllUsersColumns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:all-users-columns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix all missing columns in users table including role and login columns';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔧 Memeriksa dan menambahkan semua kolom yang dibutuhkan di tabel users...');
        
        try {
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
            
            $addedColumns = [];
            $existingColumns = [];
            $errors = [];
            
            // Proses setiap kolom
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
                        $addedColumns[] = $column;
                        $this->info("✅ Kolom '{$column}' berhasil ditambahkan");
                    } catch (\Exception $e) {
                        $errors[] = "Kolom '{$column}': " . $e->getMessage();
                        $this->error("❌ Gagal menambahkan kolom '{$column}': " . $e->getMessage());
                    }
                } else {
                    $existingColumns[] = $column;
                    $this->info("ℹ️  Kolom '{$column}' sudah ada");
                }
            }
            
            // Tampilkan ringkasan
            $this->info("\n📊 RINGKASAN:");
            $this->info("=====================================");
            
            if (!empty($addedColumns)) {
                $this->info("✅ Kolom yang berhasil ditambahkan: " . implode(', ', $addedColumns));
            }
            
            if (!empty($existingColumns)) {
                $this->info("ℹ️  Kolom yang sudah ada: " . implode(', ', $existingColumns));
            }
            
            if (!empty($errors)) {
                $this->error("\n❌ Error yang terjadi:");
                foreach ($errors as $error) {
                    $this->error("   - " . $error);
                }
            }
            
            // Tampilkan struktur tabel
            $this->info("\n📋 Struktur tabel 'users' saat ini:");
            $this->info("=====================================");
            
            $columns = DB::select('DESCRIBE users');
            
            $this->table(
                ['Field', 'Type', 'Null', 'Key', 'Default', 'Extra'],
                array_map(function ($column) {
                    return [
                        $column->Field,
                        $column->Type,
                        $column->Null,
                        $column->Key,
                        $column->Default ?? 'NULL',
                        $column->Extra
                    ];
                }, $columns)
            );
            
            // Cek apakah ada user tanpa role
            $usersWithoutRole = DB::table('users')->whereNull('role')->orWhere('role', '')->count();
            if ($usersWithoutRole > 0) {
                $this->warn("\n⚠️  Ada {$usersWithoutRole} user tanpa role. Mengupdate ke 'alumni'...");
                DB::table('users')->whereNull('role')->orWhere('role', '')->update(['role' => 'alumni']);
                $this->info("✅ Semua user tanpa role telah diupdate ke 'alumni'");
            }
            
            $this->info("\n✅ Proses selesai!");
            
        } catch (\Exception $e) {
            $this->error("❌ Error umum: " . $e->getMessage());
            $this->error("Stack trace: " . $e->getTraceAsString());
        }
        
        return Command::SUCCESS;
    }
}
