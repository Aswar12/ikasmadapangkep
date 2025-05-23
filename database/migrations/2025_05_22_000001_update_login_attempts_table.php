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
        Schema::table('login_attempts', function (Blueprint $table) {
            if (!Schema::hasColumn('login_attempts', 'time')) {
                $table->integer('time')->default(0)->after('success');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('login_attempts', function (Blueprint $table) {
            if (Schema::hasColumn('login_attempts', 'time')) {
                $table->dropColumn('time');
            }
        });
    }
};
