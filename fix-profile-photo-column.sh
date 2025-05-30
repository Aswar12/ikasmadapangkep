#!/bin/bash

echo "============================================"
echo "FIX PROFILE PHOTO COLUMN - IKA SMADA PANGKEP"
echo "============================================"
echo ""

echo "[1] Running all migrations..."
php artisan migrate --force
if [ $? -ne 0 ]; then
    echo "   - Migration might have failed, continuing..."
else
    echo "   - Migrations completed"
fi

echo ""
echo "[2] Refreshing database schema cache..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear
echo "   - Cache cleared"

echo ""
echo "[3] Checking migration status..."
php artisan migrate:status | grep "add_profile_photo"
if [ $? -eq 0 ]; then
    echo "   - Profile photo migration found"
else
    echo "   - Profile photo migration not found, forcing migration..."
    php artisan migrate --path=database/migrations/2025_05_30_000001_add_profile_photo_to_profiles_table.php --force
fi

echo ""
echo "[4] Creating profile-photos directory if not exists..."
if [ ! -d "public/profile-photos" ]; then
    mkdir -p public/profile-photos
    chmod 755 public/profile-photos
    echo "   - Directory created"
else
    echo "   - Directory already exists"
fi

echo ""
echo "[5] Testing database connection and table structure..."
php -r "
require 'vendor/autoload.php';
\$app = require_once 'bootstrap/app.php';
\$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
use Illuminate\Support\Facades\Schema;

if (Schema::hasTable('profiles')) {
    echo '   - Profiles table exists' . PHP_EOL;
    if (Schema::hasColumn('profiles', 'profile_photo')) {
        echo '   - profile_photo column exists' . PHP_EOL;
    } else {
        echo '   - profile_photo column NOT found!' . PHP_EOL;
    }
} else {
    echo '   - Profiles table NOT found!' . PHP_EOL;
}
"

echo ""
echo "============================================"
echo "COMPLETED!"
echo "============================================"
echo ""
echo "If you still see errors about missing column:"
echo "1. Check if migration file exists in database/migrations/"
echo "2. Manually run: php artisan migrate:refresh --seed"
echo "3. Or add column manually in phpMyAdmin:"
echo "   ALTER TABLE profiles ADD COLUMN profile_photo VARCHAR(255) NULL AFTER user_id;"
echo ""
