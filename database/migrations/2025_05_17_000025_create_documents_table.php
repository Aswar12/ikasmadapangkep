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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->foreignId('program_kerja_id')->nullable()->constrained('program_kerja')->nullOnDelete();
            $table->enum('document_type', ['report', 'proposal', 'minutes', 'letter', 'other'])->default('other');
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            $table->string('current_version')->default('1.0');
            $table->boolean('is_versioned')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
