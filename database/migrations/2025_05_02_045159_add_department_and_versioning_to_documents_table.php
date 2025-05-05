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
        Schema::table('documents', function (Blueprint $table) {
            // Add department relationship
            $table->unsignedBigInteger('department_id')->after('id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');

            // Add versioning fields
            $table->string('version')->default('1.0');
            $table->boolean('is_current')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['department_id']);

            // Remove columns
            $table->dropColumn(['department_id', 'version', 'is_current']);
        });
    }
};
