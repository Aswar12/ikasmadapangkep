@echo off
REM Script untuk memperbaiki masalah login Antarkanma

echo === Memperbaiki Sistem Login Antarkanma ===
echo.

REM 1. Jalankan migration
echo 1. Menjalankan migration...
php artisan migrate --force

REM 2. Clear cache
echo.
echo 2. Membersihkan cache...
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

REM 3. Cek struktur tabel (optional)
echo.
echo 3. Migration selesai!

echo.
echo === Selesai ===
echo.
echo Silakan coba login kembali dengan:
echo - Email
echo - Username
echo - Nomor WhatsApp
echo.
pause
