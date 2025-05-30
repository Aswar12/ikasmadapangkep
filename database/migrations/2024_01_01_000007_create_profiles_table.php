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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Data Pribadi
            $table->enum('gender', ['Laki-laki', 'Perempuan'])->nullable();
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('national_student_number')->nullable(); // NISN
            $table->text('address')->nullable();
            $table->string('phone_number')->nullable();
            
            // Data Orang Tua
            $table->string('father_name')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_occupation')->nullable();
            
            // Data Pendidikan
            $table->string('entry_year', 4)->nullable();
            $table->string('graduation_year', 4)->nullable();
            $table->string('diploma_number')->nullable(); // Nomor Ijazah
            $table->string('certificate_number')->nullable(); // Nomor SKHUN
            
            // Data Pekerjaan
            $table->enum('status', ['bekerja', 'studi', 'wirausaha', 'lainnya'])->nullable();
            $table->string('company_name')->nullable();
            $table->string('position')->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_phone')->nullable();
            $table->year('work_start_year')->nullable();
            
            // Data Pendidikan Lanjutan
            $table->string('university_name')->nullable();
            $table->string('major')->nullable();
            $table->string('degree')->nullable();
            $table->year('study_start_year')->nullable();
            $table->year('study_end_year')->nullable();
            
            // Data Wirausaha
            $table->string('business_name')->nullable();
            $table->string('business_type')->nullable();
            $table->text('business_address')->nullable();
            $table->year('business_start_year')->nullable();
            
            // Social Media
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index('graduation_year');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
