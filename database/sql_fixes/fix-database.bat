@echo off
echo =====================================
echo   Fix Database IKA SMA PANGKEP
echo =====================================
echo.

cd /d C:\laragon\www\ikasmadapangkep

echo [1] Clearing cache...
php artisan cache:clear
php artisan config:clear
php artisan view:clear
echo.

echo [2] Menjalankan fix command...
php artisan fix:all-users-columns
echo.

echo [3] Proses selesai!
echo.
echo Silakan coba login kembali.
echo Jika masih error, jalankan SQL manual di phpMyAdmin.
echo.
pause
