<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePwaSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('pwa_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name');
            $table->text('description');
            $table->string('theme_color');
            $table->string('background_color');
            $table->json('icons');
            $table->timestamps();
        });

        Schema::create('push_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('endpoint')->unique();
            $table->string('public_key')->nullable();
            $table->string('auth_token')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('push_subscriptions');
        Schema::dropIfExists('pwa_settings');
    }
}