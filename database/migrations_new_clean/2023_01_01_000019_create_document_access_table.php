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
        Schema::create('document_access', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('group_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('access_type', ['view', 'edit', 'delete'])->default('view');
            $table->timestamps();
            
            // A document can have one access type per user/group/department
            $table->unique(['document_id', 'user_id', 'access_type'], 'document_user_access');
            $table->unique(['document_id', 'group_id', 'access_type'], 'document_group_access');
            $table->unique(['document_id', 'department_id', 'access_type'], 'document_department_access');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_access');
    }
};