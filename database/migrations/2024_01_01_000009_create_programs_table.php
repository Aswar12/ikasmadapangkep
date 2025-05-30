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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('location')->nullable();
            $table->decimal('budget', 12, 2)->default(0);
            $table->decimal('realization', 12, 2)->default(0);
            $table->foreignId('pic_id')->nullable()->constrained('users')->onDelete('set null'); // Person In Charge
            $table->integer('progress')->default(0); // 0-100
            $table->enum('status', ['planning', 'ongoing', 'completed', 'cancelled', 'delayed'])->default('planning');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('department_id');
            $table->index('pic_id');
            $table->index('status');
            $table->index('start_date');
            $table->index('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
