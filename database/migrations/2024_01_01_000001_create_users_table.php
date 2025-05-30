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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username')->unique()->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('phone')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('profile_photo_path', 2048)->nullable();
            $table->enum('role', ['admin', 'sub_admin', 'department_coordinator', 'alumni'])->default('alumni');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('angkatan', 4)->nullable(); // Tahun kelulusan
            $table->timestamp('last_login_at')->nullable();
            $table->integer('login_count')->default(0);
            $table->integer('failed_login_attempts')->default(0);
            $table->timestamp('login_locked_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
            
            // Indexes
            $table->index('email');
            $table->index('username');
            $table->index('role');
            $table->index('status');
            $table->index('angkatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
