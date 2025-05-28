#!/bin/bash
# Script untuk memperbaiki masalah login Antarkanma

echo "=== Memperbaiki Sistem Login Antarkanma ==="
echo ""

# 1. Jalankan migration
echo "1. Menjalankan migration..."
php artisan migrate --force

# 2. Clear cache
echo ""
echo "2. Membersihkan cache..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 3. Cek struktur tabel
echo ""
echo "3. Mengecek struktur tabel users..."
php artisan tinker --execute="
    \$columns = Schema::getColumnListing('users');
    echo 'Kolom dalam tabel users: ' . implode(', ', \$columns) . PHP_EOL;
    
    \$required = ['username', 'phone', 'is_active', 'status', 'role'];
    \$missing = array_diff(\$required, \$columns);
    
    if (empty(\$missing)) {
        echo 'Semua kolom yang diperlukan sudah ada!' . PHP_EOL;
    } else {
        echo 'Kolom yang hilang: ' . implode(', ', \$missing) . PHP_EOL;
    }
"

echo ""
echo "=== Selesai ==="
echo ""
echo "Silakan coba login kembali dengan:"
echo "- Email"
echo "- Username" 
echo "- Nomor WhatsApp"
