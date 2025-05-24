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
            // Add attempted_at column
            $table->timestamp('attempted_at')->nullable()->after('success');
            
            // Remove old time column if it exists
            if (Schema::hasColumn('login_attempts', 'time')) {
                $table->dropColumn('time');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('login_attempts', function (Blueprint $table) {
            // Add back time column
            $table->integer('time')->after('success');
            
            // Remove attempted_at column
            if (Schema::hasColumn('login_attempts', 'attempted_at')) {
                $table->dropColumn('attempted_at');
            }
        });
    }
};
