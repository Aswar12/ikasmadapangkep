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
        // Cek dan tambahkan kolom whatsapp jika belum ada
        if (!Schema::hasColumn('users', 'whatsapp')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('whatsapp', 20)->nullable()->after('email');
            });
            
            echo "✅ Kolom 'whatsapp' berhasil ditambahkan" . PHP_EOL;
        } else {
            echo "ℹ️ Kolom 'whatsapp' sudah ada" . PHP_EOL;
        }
        
        // Cek dan tambahkan kolom username jika belum ada
        if (!Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('username', 50)->nullable()->after('name');
            });
            
            echo "✅ Kolom 'username' berhasil ditambahkan" . PHP_EOL;
        } else {
            echo "ℹ️ Kolom 'username' sudah ada" . PHP_EOL;
        }
        
        // Copy data dari phone ke whatsapp jika ada kolom phone
        if (Schema::hasColumn('users', 'phone') && Schema::hasColumn('users', 'whatsapp')) {
            $copied = DB::statement('UPDATE users SET whatsapp = phone WHERE phone IS NOT NULL AND (whatsapp IS NULL OR whatsapp = "")');
            if ($copied) {
                echo "✅ Data berhasil disalin dari kolom 'phone' ke 'whatsapp'" . PHP_EOL;
            }
        }
        
        // Tambahkan unique constraint setelah data dipastikan bersih
        Schema::table('users', function (Blueprint $table) {
            // Hapus duplicate data dulu
            DB::statement('
                DELETE u1 FROM users u1
                INNER JOIN users u2 
                WHERE u1.id > u2.id 
                AND u1.whatsapp = u2.whatsapp 
                AND u1.whatsapp IS NOT NULL 
                AND u1.whatsapp != ""
            ');
            
            // Tambahkan unique constraint jika belum ada
            try {
                if (Schema::hasColumn('users', 'whatsapp')) {
                    $table->unique('whatsapp');
                }
                if (Schema::hasColumn('users', 'username')) {
                    $table->unique('username');
                }
            } catch (Exception $e) {
                // Ignore jika constraint sudah ada
                echo "ℹ️ Unique constraints mungkin sudah ada" . PHP_EOL;
            }
        });
        
        // Tambahkan kolom untuk login tracking jika belum ada
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable();
            }
            if (!Schema::hasColumn('users', 'login_count')) {
                $table->unsignedInteger('login_count')->default(0);
            }
            if (!Schema::hasColumn('users', 'failed_login_attempts')) {
                $table->unsignedInteger('failed_login_attempts')->default(0);
            }
            if (!Schema::hasColumn('users', 'login_locked_until')) {
                $table->timestamp('login_locked_until')->nullable();
            }
        });
        
        echo "✅ Migration berhasil dijalankan!" . PHP_EOL;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus unique constraints
            try {
                $table->dropUnique(['whatsapp']);
                $table->dropUnique(['username']);
            } catch (Exception $e) {
                // Ignore error
            }
            
            // Hapus kolom (hati-hati dengan data)
            if (Schema::hasColumn('users', 'whatsapp')) {
                $table->dropColumn('whatsapp');
            }
            if (Schema::hasColumn('users', 'login_locked_until')) {
                $table->dropColumn('login_locked_until');
            }
            if (Schema::hasColumn('users', 'failed_login_attempts')) {
                $table->dropColumn('failed_login_attempts');
            }
            if (Schema::hasColumn('users', 'login_count')) {
                $table->dropColumn('login_count');
            }
            if (Schema::hasColumn('users', 'last_login_at')) {
                $table->dropColumn('last_login_at');
            }
        });
    }
};
