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
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('email_event')->default(true);
            $table->boolean('email_payment')->default(true);
            $table->boolean('email_program')->default(true);
            $table->boolean('email_news')->default(true);
            $table->boolean('push_event')->default(true);
            $table->boolean('push_payment')->default(true);
            $table->boolean('push_program')->default(true);
            $table->boolean('push_news')->default(true);
            $table->timestamps();
            
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_settings');
    }
};