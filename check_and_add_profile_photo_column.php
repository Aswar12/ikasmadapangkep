<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

echo "========================================\n";
echo "ADDING PROFILE_PHOTO COLUMN VIA MIGRATION\n";
echo "========================================\n\n";

// Check if profiles table exists
if (Schema::hasTable('profiles')) {
    echo "[✓] Table 'profiles' exists\n";
    
    // Check if column already exists
    if (Schema::hasColumn('profiles', 'profile_photo')) {
        echo "[✓] Column 'profile_photo' already exists in profiles table\n";
    } else {
        echo "[!] Column 'profile_photo' does not exist. Running migration...\n";
        
        try {
            // Run the migration
            Artisan::call('migrate', ['--force' => true]);
            echo "[✓] Migration executed successfully\n";
            echo Artisan::output();
            
            // Verify column was added
            if (Schema::hasColumn('profiles', 'profile_photo')) {
                echo "[✓] Column 'profile_photo' has been added successfully!\n";
            } else {
                echo "[✗] Column still doesn't exist after migration\n";
            }
        } catch (Exception $e) {
            echo "[✗] Error running migration: " . $e->getMessage() . "\n";
        }
    }
    
    // Show current columns
    echo "\nCurrent columns in profiles table:\n";
    $columns = Schema::getColumnListing('profiles');
    foreach ($columns as $column) {
        echo "  - $column\n";
    }
    
} else {
    echo "[✗] Table 'profiles' does not exist!\n";
    echo "Please run: php artisan migrate\n";
}

echo "\n========================================\n";
echo "DONE!\n";
echo "========================================\n";
