<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cek apakah kolom whatsapp sudah ada
        if (!Schema::hasColumn('users', 'whatsapp')) {
            Schema::table('users', function (Blueprint $table) {
                // Tambahkan kolom whatsapp setelah email
                $table->string('whatsapp', 20)->nullable()->unique()->after('email');
                
                // Tambahkan index untuk performance
                $table->index('whatsapp');
            });
        }
        
        // Jika ada kolom phone dan belum ada data di whatsapp, copy data dari phone ke whatsapp
        if (Schema::hasColumn('users', 'phone') && Schema::hasColumn('users', 'whatsapp')) {
            // Copy data dari phone ke whatsapp jika whatsapp kosong
            DB::statement('UPDATE users SET whatsapp = phone WHERE phone IS NOT NULL AND (whatsapp IS NULL OR whatsapp = "")');
        }
        
        // Pastikan kolom-kolom lain yang dibutuhkan login juga ada
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username', 50)->nullable()->unique()->after('name');
                $table->index('username');
            }
            
            if (!Schema::hasColumn('users', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable()->after('remember_token');
            }
            
            if (!Schema::hasColumn('users', 'login_count')) {
                $table->unsignedInteger('login_count')->default(0)->after('last_login_at');
            }
            
            if (!Schema::hasColumn('users', 'failed_login_attempts')) {
                $table->unsignedInteger('failed_login_attempts')->default(0)->after('login_count');
            }
            
            if (!Schema::hasColumn('users', 'login_locked_until')) {
                $table->timestamp('login_locked_until')->nullable()->after('failed_login_attempts');
            }
        });
        
        // Tambahkan indexes yang mungkin belum ada
        if (!$this->indexExists('users', 'users_email_index')) {
            Schema::table('users', function (Blueprint $table) {
                $table->index('email');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop indexes
            if ($this->indexExists('users', 'users_whatsapp_index')) {
                $table->dropIndex(['whatsapp']);
            }
            if ($this->indexExists('users', 'users_username_index')) {
                $table->dropIndex(['username']);
            }
            if ($this->indexExists('users', 'users_email_index')) {
                $table->dropIndex(['email']);
            }
            
            // Drop columns (hati-hati, ini akan menghapus data)
            if (Schema::hasColumn('users', 'whatsapp')) {
                $table->dropColumn('whatsapp');
            }
        });
    }
    
    /**
     * Check if index exists
     */
    private function indexExists($table, $index)
    {
        $sm = Schema::getConnection()->getDoctrineSchemaManager();
        $indexesFound = $sm->listTableIndexes($table);
        
        return array_key_exists($index, $indexesFound);
    }
};
