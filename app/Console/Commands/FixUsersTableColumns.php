<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixUsersTableColumns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:users-columns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix missing columns in users table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔧 Memeriksa dan menambahkan kolom-kolom yang hilang di tabel users...');
        
        try {
            $columnsToAdd = [
                'last_login_at' => 'TIMESTAMP NULL DEFAULT NULL',
                'login_count' => 'INT UNSIGNED NOT NULL DEFAULT 0',
                'failed_login_attempts' => 'INT UNSIGNED NOT NULL DEFAULT 0',
                'login_locked_until' => 'TIMESTAMP NULL DEFAULT NULL'
            ];
            
            $addedColumns = [];
            $existingColumns = [];
            
            foreach ($columnsToAdd as $column => $definition) {
                if (!Schema::hasColumn('users', $column)) {
                    try {
                        DB::statement("ALTER TABLE `users` ADD COLUMN `{$column}` {$definition}");
                        $addedColumns[] = $column;
                        $this->info("✅ Kolom '{$column}' berhasil ditambahkan");
                    } catch (\Exception $e) {
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
            
            $this->info("\n✅ Proses selesai!");
            
            // Cek apakah perlu menjalankan migrasi
            $pendingMigrations = DB::select("SELECT migration FROM migrations WHERE migration LIKE '%fix_login_columns%' OR migration LIKE '%add_authentication_fields%'");
            
            if (empty($pendingMigrations)) {
                $this->warn("\n⚠️  Ada beberapa migrasi terkait login yang belum dijalankan.");
                $this->warn("Jalankan: php artisan migrate");
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Error umum: " . $e->getMessage());
            $this->error("Stack trace: " . $e->getTraceAsString());
        }
        
        return Command::SUCCESS;
    }
}
