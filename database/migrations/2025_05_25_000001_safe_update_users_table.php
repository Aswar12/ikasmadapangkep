<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cek dan tambahkan kolom satu per satu untuk menghindari error
        Schema::table('users', function (Blueprint $table) {
            // Cek dan tambahkan username
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->nullable()->after('name');
            }
        });
        
        Schema::table('users', function (Blueprint $table) {
            // Cek dan tambahkan phone
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 20)->nullable()->after('email');
            }
        });
        
        Schema::table('users', function (Blueprint $table) {
            // Cek dan tambahkan is_active
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('password');
            }
        });
        
        Schema::table('users', function (Blueprint $table) {
            // Cek dan tambahkan status
            if (!Schema::hasColumn('users', 'status')) {
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved')->after('is_active');
            }
        });
        
        Schema::table('users', function (Blueprint $table) {
            // Cek dan tambahkan role
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('user')->after('status');
            }
        });
        
        // Update semua user yang sudah ada menjadi approved
        DB::table('users')->whereNull('is_active')->update([
            'is_active' => true,
            'status' => 'approved'
        ]);
        
        // Set username untuk user yang belum punya (gunakan email sebagai username sementara)
        $users = DB::table('users')->whereNull('username')->get();
        foreach ($users as $user) {
            $username = explode('@', $user->email)[0];
            $counter = 1;
            $finalUsername = $username;
            
            // Cek uniqueness
            while (DB::table('users')->where('username', $finalUsername)->where('id', '!=', $user->id)->exists()) {
                $finalUsername = $username . $counter;
                $counter++;
            }
            
            DB::table('users')->where('id', $user->id)->update(['username' => $finalUsername]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'username')) {
                $table->dropColumn('username');
            }
            if (Schema::hasColumn('users', 'phone')) {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('users', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('users', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
