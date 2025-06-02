@echo off
echo Clearing Laravel cache...

cd /d "C:\laragon\www\ikasmadapangkep"

echo 1. Clearing route cache...
php artisan route:clear

echo 2. Clearing config cache...
php artisan config:clear

echo 3. Clearing view cache...
php artisan view:clear

echo 4. Clearing application cache...
php artisan cache:clear

echo 5. Optimizing...
php artisan optimize

echo.
echo Cache cleared successfully!
pause
