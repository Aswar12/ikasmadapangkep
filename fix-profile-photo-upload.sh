#!/bin/bash

echo "============================================="
echo "FIX PROFILE PHOTO UPLOAD - IKA SMADA PANGKEP"
echo "============================================="
echo ""

echo "[1] Creating profile-photos directory in public folder..."
if [ ! -d "public/profile-photos" ]; then
    mkdir -p public/profile-photos
    echo "   - Directory created successfully"
else
    echo "   - Directory already exists"
fi

echo ""
echo "[2] Setting permissions..."
chmod -R 755 public/profile-photos
chown -R www-data:www-data public/profile-photos 2>/dev/null || chown -R $(whoami):$(whoami) public/profile-photos
echo "   - Permissions set"

echo ""
echo "[3] Creating storage link..."
php artisan storage:link 2>/dev/null
if [ $? -eq 0 ]; then
    echo "   - Storage link created/verified"
else
    echo "   - Storage link already exists or failed"
fi

echo ""
echo "[4] Clearing Laravel caches..."
php artisan cache:clear >/dev/null 2>&1
php artisan config:clear >/dev/null 2>&1
php artisan view:clear >/dev/null 2>&1
echo "   - Caches cleared"

echo ""
echo "============================================="
echo "FIX COMPLETED!"
echo "============================================="
echo ""
echo "Profile photo upload should now work properly."
echo "Please try uploading a photo again."
echo ""
