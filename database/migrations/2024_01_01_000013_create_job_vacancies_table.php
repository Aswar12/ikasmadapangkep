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
        Schema::create('job_vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('company_name');
            $table->text('description');
            $table->text('requirements');
            $table->string('location');
            $table->enum('type', ['full_time', 'part_time', 'contract', 'internship', 'freelance']);
            $table->string('salary_range')->nullable();
            $table->date('deadline');
            $table->string('contact_person');
            $table->string('contact_email');
            $table->string('contact_phone')->nullable();
            $table->foreignId('posted_by')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['draft', 'published', 'closed'])->default('draft');
            $table->timestamps();
            
            // Indexes
            $table->index('status');
            $table->index('deadline');
            $table->index('posted_by');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};
