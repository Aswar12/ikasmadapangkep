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
            // Add new columns
            $table->string('username', 50)->unique()->nullable()->after('name');
            $table->string('whatsapp', 20)->unique()->nullable()->after('email');
            $table->timestamp('last_login_at')->nullable()->after('remember_token');
            $table->unsignedInteger('login_count')->default(0)->after('last_login_at');
            $table->unsignedInteger('failed_login_attempts')->default(0)->after('login_count');
            $table->timestamp('login_locked_until')->nullable()->after('failed_login_attempts');
            
            // Add indexes for better performance
            $table->index('username');
            $table->index('whatsapp');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['username']);
            $table->dropIndex(['whatsapp']);
            $table->dropIndex(['email']);
            
            $table->dropColumn([
                'username',
                'whatsapp',
                'last_login_at',
                'login_count',
                'failed_login_attempts',
                'login_locked_until'
            ]);
        });
    }
};
