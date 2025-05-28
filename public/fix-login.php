<?php
/**
 * Manual Fix Script untuk Antarkanma Login
 * Akses via browser: http://localhost/ikasmadapangkep/public/fix-login.php
 */

// Bootstrap Laravel
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "<h1>Fix Login Script untuk Antarkanma</h1>";
echo "<pre>";

try {
    // 1. Check users table
    echo "1. Checking users table...\n";
    if (Schema::hasTable('users')) {
        echo "✓ Users table exists\n\n";
        
        $columns = Schema::getColumnListing('users');
        echo "Current columns: " . implode(', ', $columns) . "\n\n";
        
        // 2. Add missing columns
        echo "2. Adding missing columns...\n";
        
        $addedColumns = [];
        
        // Add username column
        if (!in_array('username', $columns)) {
            Schema::table('users', function ($table) {
                $table->string('username')->nullable()->after('name');
            });
            $addedColumns[] = 'username';
            echo "✓ Added column: username\n";
        }
        
        // Add phone column
        if (!in_array('phone', $columns)) {
            Schema::table('users', function ($table) {
                $table->string('phone', 20)->nullable()->after('email');
            });
            $addedColumns[] = 'phone';
            echo "✓ Added column: phone\n";
        }
        
        // Add is_active column
        if (!in_array('is_active', $columns)) {
            Schema::table('users', function ($table) {
                $table->boolean('is_active')->default(true)->after('password');
            });
            $addedColumns[] = 'is_active';
            echo "✓ Added column: is_active\n";
        }
        
        // Add status column
        if (!in_array('status', $columns)) {
            Schema::table('users', function ($table) {
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved')->after('is_active');
            });
            $addedColumns[] = 'status';
            echo "✓ Added column: status\n";
        }
        
        // Add role column
        if (!in_array('role', $columns)) {
            Schema::table('users', function ($table) {
                $table->string('role')->default('user')->after('status');
            });
            $addedColumns[] = 'role';
            echo "✓ Added column: role\n";
        }
        
        if (empty($addedColumns)) {
            echo "✓ All required columns already exist\n";
        }
        
        echo "\n3. Updating existing users...\n";
        
        // Update all users to be active and approved
        $updated = DB::table('users')->update([
            'is_active' => true,
            'status' => 'approved'
        ]);
        
        echo "✓ Updated $updated users to active and approved status\n";
        
        // Generate usernames for users without one
        $usersWithoutUsername = DB::table('users')->whereNull('username')->get();
        
        foreach ($usersWithoutUsername as $user) {
            $username = explode('@', $user->email)[0];
            $username = preg_replace('/[^a-zA-Z0-9]/', '', $username);
            
            $counter = 1;
            $finalUsername = $username;
            
            while (DB::table('users')->where('username', $finalUsername)->exists()) {
                $finalUsername = $username . $counter;
                $counter++;
            }
            
            DB::table('users')->where('id', $user->id)->update(['username' => $finalUsername]);
            echo "✓ Generated username for user {$user->id}: $finalUsername\n";
        }
        
        // 4. Fix login_attempts table
        echo "\n4. Fixing login_attempts table...\n";
        
        if (Schema::hasTable('login_attempts')) {
            $loginColumns = Schema::getColumnListing('login_attempts');
            
            if (in_array('time', $loginColumns)) {
                Schema::table('login_attempts', function ($table) {
                    $table->dropColumn('time');
                });
                echo "✓ Removed 'time' column from login_attempts table\n";
            }
        }
        
        echo "\n5. Clearing cache...\n";
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        echo "✓ Cache cleared\n";
        
        echo "\n<strong style='color: green;'>✅ FIX COMPLETED SUCCESSFULLY!</strong>\n\n";
        
        echo "You can now login with:\n";
        echo "- Email\n";
        echo "- Username\n";
        echo "- Phone Number (WhatsApp)\n\n";
        
        echo "All users are now:\n";
        echo "- Active (is_active = true)\n";
        echo "- Approved (status = 'approved')\n";
        echo "- No admin approval needed\n";
        
    } else {
        echo "✗ Users table does not exist!\n";
        echo "Please run: php artisan migrate\n";
    }
    
} catch (Exception $e) {
    echo "\n<strong style='color: red;'>ERROR:</strong> " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "</pre>";

// Cleanup
echo "<hr>";
echo "<p><strong>Next steps:</strong></p>";
echo "<ol>";
echo "<li>Delete this file after running it (for security)</li>";
echo "<li>Try to login with email/username/phone</li>";
echo "<li>If still having issues, check Laravel logs in storage/logs/</li>";
echo "</ol>";
