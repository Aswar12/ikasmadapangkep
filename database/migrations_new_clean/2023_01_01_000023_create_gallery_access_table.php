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
        Schema::create('gallery_access', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('group_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('year_id')->nullable()->constrained('year_references')->nullOnDelete();
            $table->enum('access_type', ['view', 'edit', 'upload', 'delete'])->default('view');
            $table->timestamps();
            
            // An album can have one access type per user/group/year
            $table->unique(['album_id', 'user_id', 'access_type'], 'album_user_access');
            $table->unique(['album_id', 'group_id', 'access_type'], 'album_group_access');
            $table->unique(['album_id', 'year_id', 'access_type'], 'album_year_access');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_access');
    }
};