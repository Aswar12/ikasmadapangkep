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
        Schema::create('department_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->enum('role_in_department', [
                'coordinator',      // Koordinator Departemen
                'secretary',        // Sekretaris Departemen
                'treasurer',        // Bendahara Departemen
                'member',          // Anggota Biasa
                'volunteer'        // Relawan/Sukarelawan
            ])->default('member');
            $table->enum('status', ['active', 'inactive', 'resigned'])->default('active');
            $table->date('joined_at')->nullable();
            $table->date('resigned_at')->nullable();
            $table->text('notes')->nullable(); // Catatan khusus
            $table->timestamps();
            
            // Unique constraint to prevent duplicate membership
            $table->unique(['user_id', 'department_id']);
            
            // Indexes
            $table->index(['department_id', 'role_in_department']);
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department_members');
    }
};