# PowerShell Script untuk memperbaiki database IKA SMA PANGKEP
# Simpan sebagai: fix-database.ps1
# Jalankan dengan: Right-click > Run with PowerShell

Write-Host "=====================================" -ForegroundColor Cyan
Write-Host "  Fix Database IKA SMA PANGKEP" -ForegroundColor Cyan
Write-Host "=====================================" -ForegroundColor Cyan
Write-Host ""

# Set working directory
$projectPath = "C:\laragon\www\ikasmadapangkep"
Set-Location $projectPath

Write-Host "📂 Working directory: $projectPath" -ForegroundColor Yellow
Write-Host ""

# Pilihan metode
Write-Host "Pilih metode perbaikan:" -ForegroundColor Green
Write-Host "1. Artisan Command (Rekomendasi)" -ForegroundColor White
Write-Host "2. Tinker Script" -ForegroundColor White
Write-Host "3. Jalankan Migrasi" -ForegroundColor White
Write-Host "4. Clear Cache Only" -ForegroundColor White
Write-Host ""

$choice = Read-Host "Masukkan pilihan (1-4)"

switch ($choice) {
    "1" {
        Write-Host ""
        Write-Host "🔧 Menjalankan Artisan Command..." -ForegroundColor Yellow
        php artisan fix:all-users-columns
    }
    "2" {
        Write-Host ""
        Write-Host "🔧 Menjalankan Tinker Script..." -ForegroundColor Yellow
        Get-Content "database\sql_fixes\fix_all_columns_tinker.php" | php artisan tinker
    }
    "3" {
        Write-Host ""
        Write-Host "🔧 Menjalankan Migrasi..." -ForegroundColor Yellow
        php artisan migrate
    }
    "4" {
        Write-Host ""
        Write-Host "🔧 Clearing Cache..." -ForegroundColor Yellow
    }
}

# Clear cache
Write-Host ""
Write-Host "🧹 Clearing all caches..." -ForegroundColor Yellow
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

Write-Host ""
Write-Host "✅ Proses selesai!" -ForegroundColor Green
Write-Host ""
Write-Host "📋 Langkah selanjutnya:" -ForegroundColor Cyan
Write-Host "1. Cek phpMyAdmin untuk memastikan kolom sudah ditambahkan" -ForegroundColor White
Write-Host "2. Coba login kembali ke aplikasi" -ForegroundColor White
Write-Host "3. Jika masih error, jalankan SQL manual di phpMyAdmin" -ForegroundColor White
Write-Host ""
Write-Host "Tekan Enter untuk keluar..."
Read-Host
