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
        // Drop and recreate login_attempts table with correct structure
        Schema::dropIfExists('login_attempts');
        
        Schema::create('login_attempts', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45);
            $table->string('login');
            $table->boolean('success')->default(false);
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index(['login', 'success']);
            $table->index(['ip_address', 'success']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_attempts');
    }
};
