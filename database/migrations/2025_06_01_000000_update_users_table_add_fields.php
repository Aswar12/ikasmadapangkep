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
        Schema::table('users', function (Blueprint $table) {
            // Additional fields for user profile
            $table->string('bio')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('social_media_links')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('current_position')->nullable();
            $table->string('current_company')->nullable();
            $table->string('education_history')->nullable();
            $table->string('work_history')->nullable();
            // Additional security fields
            $table->boolean('two_factor_enabled')->default(false);
            $table->string('two_factor_secret')->nullable();
            $table->timestamp('last_password_change')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'bio',
                'profile_picture',
                'social_media_links',
                'birth_date',
                'address',
                'city',
                'province',
                'postal_code',
                'current_position',
                'current_company',
                'education_history',
                'work_history',
                'two_factor_enabled',
                'two_factor_secret',
                'last_password_change'
            ]);
        });
    }
};