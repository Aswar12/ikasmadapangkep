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
        // Check if login_attempts table exists and has correct structure
        if (Schema::hasTable('login_attempts')) {
            Schema::table('login_attempts', function (Blueprint $table) {
                // Remove time column if exists
                if (Schema::hasColumn('login_attempts', 'time')) {
                    $table->dropColumn('time');
                }
                
                // Remove attempted_at column if exists (since we're using created_at)
                if (Schema::hasColumn('login_attempts', 'attempted_at')) {
                    $table->dropColumn('attempted_at');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('login_attempts', function (Blueprint $table) {
            // Add back time column
            $table->integer('time')->nullable();
        });
    }
};
