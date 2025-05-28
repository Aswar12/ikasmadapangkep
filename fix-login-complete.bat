@echo off
REM Script untuk memperbaiki masalah login Antarkanma

echo === Memperbaiki Sistem Login Antarkanma ===
echo.

REM 1. Jalankan migration untuk perbaikan
echo 1. Menjalankan migration perbaikan...
php artisan migrate --path=database/migrations/2025_05_25_000001_safe_update_users_table.php --force

REM 2. Jalankan fix command
echo.
echo 2. Menjalankan fix command...
php artisan fix:users-table

REM 3. Clear cache
echo.
echo 3. Membersihkan cache...
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

REM 4. Cek status
echo.
echo 4. Mengecek status...
php artisan tinker --execute="echo 'Total users: ' . \App\Models\User::count() . PHP_EOL;"

echo.
echo === Selesai ===
echo.
echo Sistem login telah diperbaiki!
echo.
echo Anda sekarang dapat login dengan:
echo - Email: user@example.com
echo - Username: username123
echo - Nomor WhatsApp: 081234567890
echo.
echo Semua user sekarang:
echo - Status: Approved (tidak perlu persetujuan admin)
echo - is_active: true (langsung aktif)
echo.
pause
