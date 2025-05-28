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
        Schema::table('users', function (Blueprint $table) {
            // Add username field if it doesn't exist
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username', 50)->unique()->nullable()->after('name');
            }
            
            // Add whatsapp field if it doesn't exist
            if (!Schema::hasColumn('users', 'whatsapp')) {
                $table->string('whatsapp', 20)->unique()->nullable()->after('email');
            }
            
            // Add last_login_at timestamp
            if (!Schema::hasColumn('users', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable();
            }
            
            // Add login_count counter
            if (!Schema::hasColumn('users', 'login_count')) {
                $table->unsignedInteger('login_count')->default(0);
            }
            
            // Add failed_login_attempts counter
            if (!Schema::hasColumn('users', 'failed_login_attempts')) {
                $table->unsignedTinyInteger('failed_login_attempts')->default(0);
            }
            
            // Add indexes for performance
            $table->index('username');
            $table->index('whatsapp');
            $table->index('last_login_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop indexes first
            $table->dropIndex(['username']);
            $table->dropIndex(['whatsapp']);
            $table->dropIndex(['last_login_at']);
            
            // Drop columns
            $table->dropColumn([
                'username',
                'whatsapp',
                'last_login_at',
                'login_count',
                'failed_login_attempts'
            ]);
        });
    }
};
