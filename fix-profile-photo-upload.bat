@echo off
echo =============================================
echo FIX PROFILE PHOTO UPLOAD - IKA SMADA PANGKEP
echo =============================================
echo.

echo [1] Creating profile-photos directory in public folder...
if not exist "public\profile-photos" (
    mkdir "public\profile-photos"
    echo    - Directory created successfully
) else (
    echo    - Directory already exists
)

echo.
echo [2] Setting permissions...
icacls "public\profile-photos" /grant Everyone:F /T >nul 2>&1
echo    - Permissions set to full access

echo.
echo [3] Creating storage link...
php artisan storage:link 2>nul
if %errorlevel% == 0 (
    echo    - Storage link created/verified
) else (
    echo    - Storage link already exists or failed
)

echo.
echo [4] Clearing Laravel caches...
php artisan cache:clear >nul 2>&1
php artisan config:clear >nul 2>&1
php artisan view:clear >nul 2>&1
echo    - Caches cleared

echo.
echo =============================================
echo FIX COMPLETED!
echo =============================================
echo.
echo Profile photo upload should now work properly.
echo Please try uploading a photo again.
echo.
pause
