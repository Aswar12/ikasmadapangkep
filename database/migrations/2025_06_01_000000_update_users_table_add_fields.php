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
            if (!Schema::hasColumn('users', 'ip_address')) {
                $table->string('ip_address')->nullable()->after('id');
            }
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->after('ip_address');
            }
            if (!Schema::hasColumn('users', 'salt')) {
                $table->string('salt')->nullable()->after('password');
            }
            if (!Schema::hasColumn('users', 'activation_code')) {
                $table->string('activation_code')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'forgotten_password_code')) {
                $table->string('forgotten_password_code')->nullable()->after('activation_code');
            }
            if (!Schema::hasColumn('users', 'forgotten_password_time')) {
                $table->timestamp('forgotten_password_time')->nullable()->after('forgotten_password_code');
            }
            if (!Schema::hasColumn('users', 'remember_code')) {
                $table->string('remember_code')->nullable()->after('forgotten_password_time');
            }
            if (!Schema::hasColumn('users', 'created_on')) {
                $table->timestamp('created_on')->nullable()->after('remember_code');
            }
            if (!Schema::hasColumn('users', 'last_login')) {
                $table->timestamp('last_login')->nullable()->after('created_on');
            }
            if (!Schema::hasColumn('users', 'active')) {
                $table->boolean('active')->default(false)->after('last_login');
            }
            if (!Schema::hasColumn('users', 'first_name')) {
                $table->string('first_name')->nullable()->after('active');
            }
            if (!Schema::hasColumn('users', 'last_name')) {
                $table->string('last_name')->nullable()->after('first_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = [
                'ip_address',
                'username',
                'salt',
                'activation_code',
                'forgotten_password_code',
                'forgotten_password_time',
                'remember_code',
                'created_on',
                'last_login',
                'active',
                'first_name',
                'last_name',
            ];
            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
