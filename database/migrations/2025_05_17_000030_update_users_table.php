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
            $table->string('username')->nullable()->after('name');
            $table->string('ip_address', 45)->nullable()->after('email');
            $table->string('activation_code')->nullable()->after('password');
            $table->string('forgotten_password_code')->nullable()->after('activation_code');
            $table->timestamp('forgotten_password_time')->nullable()->after('forgotten_password_code');
            $table->string('remember_code')->nullable()->after('forgotten_password_time');
            $table->timestamp('created_on')->nullable()->after('remember_code');
            $table->timestamp('last_login')->nullable()->after('created_on');
            $table->boolean('active')->default(false)->after('last_login');
            $table->string('first_name')->nullable()->after('active');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('graduation_year')->nullable()->after('last_name');
            $table->string('phone')->nullable()->after('graduation_year');
            $table->enum('role', ['admin', 'sub_admin', 'department_coordinator', 'alumni'])->default('alumni')->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'ip_address',
                'activation_code',
                'forgotten_password_code',
                'forgotten_password_time',
                'remember_code',
                'created_on',
                'last_login',
                'active',
                'first_name',
                'last_name',
                'graduation_year',
                'phone',
                'role'
            ]);
        });
    }
};
