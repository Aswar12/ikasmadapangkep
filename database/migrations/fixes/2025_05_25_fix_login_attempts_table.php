<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('login_attempts', function (Blueprint $table) {
            // Hapus kolom time jika ada
            if (Schema::hasColumn('login_attempts', 'time')) {
                $table->dropColumn('time');
            }
            
            // Pastikan kolom yang dibutuhkan ada
            if (!Schema::hasColumn('login_attempts', 'login')) {
                $table->string('login')->after('ip_address');
            }
            
            if (!Schema::hasColumn('login_attempts', 'success')) {
                $table->boolean('success')->default(false)->after('login');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('login_attempts', function (Blueprint $table) {
            $table->timestamp('time')->nullable();
        });
    }
};
