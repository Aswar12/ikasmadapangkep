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
            // Add approved column for user approval system
            if (!Schema::hasColumn('users', 'approved')) {
                $table->boolean('approved')->default(false)->after('active');
            }
            
            // Add registration_date column
            if (!Schema::hasColumn('users', 'registration_date')) {
                $table->timestamp('registration_date')->nullable()->after('approved');
            }
            
            // Add last_login_ip column (separate from ip_address)
            if (!Schema::hasColumn('users', 'last_login_ip')) {
                $table->string('last_login_ip', 45)->nullable()->after('last_login');
            }
            
            // Add current_job column
            if (!Schema::hasColumn('users', 'current_job')) {
                $table->string('current_job')->nullable()->after('role');
            }
            
            // Make username unique
            if (Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->nullable(false)->change();
            }
            
            // Make phone unique
            if (Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->unique()->nullable(false)->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'approved',
                'registration_date', 
                'last_login_ip',
                'current_job'
            ]);
        });
    }
};
