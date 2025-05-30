#!/bin/bash

echo "========================================"
echo "ADDING PROFILE_PHOTO COLUMN TO DATABASE"
echo "========================================"
echo ""

echo "[1] Running migration..."
php artisan migrate 2>/dev/null

echo ""
echo "[2] Checking and adding column directly via MySQL..."
php -r "
require 'vendor/autoload.php';
\$app = require_once 'bootstrap/app.php';
\$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

if (!Schema::hasColumn('profiles', 'profile_photo')) {
    DB::statement('ALTER TABLE profiles ADD COLUMN profile_photo VARCHAR(255) NULL AFTER user_id');
    echo 'Column added successfully!';
} else {
    echo 'Column already exists!';
}
"

echo ""
echo "[3] Clearing cache..."
php artisan cache:clear >/dev/null 2>&1
php artisan config:clear >/dev/null 2>&1

echo ""
echo "========================================"
echo "COMPLETED!"
echo "========================================"
echo ""
echo "The profile_photo column should now exist in the profiles table."
echo "Please try uploading a photo again."
echo ""
