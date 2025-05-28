# Panduan Memperbaiki Error Database IKA SMA PANGKEP

## Masalah yang Terjadi

Ada dua masalah utama:

1. **Error Login**: Kolom-kolom untuk tracking login tidak ada (`last_login_at`, `login_count`, `failed_login_attempts`, `login_locked_until`)
2. **Error Dashboard**: Kolom `role` mungkin tidak ada atau user tidak memiliki role

## Solusi yang Tersedia

### 🚀 Solusi Cepat (Rekomendasi)

Jalankan SQL berikut di phpMyAdmin atau tool database lainnya:

```sql
-- Jalankan file: database/sql_fixes/fix_all_users_columns.sql
-- Atau copy paste SQL di bawah ini:

ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `last_login_at` TIMESTAMP NULL DEFAULT NULL,
ADD COLUMN IF NOT EXISTS `login_count` INT UNSIGNED NOT NULL DEFAULT 0,
ADD COLUMN IF NOT EXISTS `failed_login_attempts` INT UNSIGNED NOT NULL DEFAULT 0,
ADD COLUMN IF NOT EXISTS `login_locked_until` TIMESTAMP NULL DEFAULT NULL,
ADD COLUMN IF NOT EXISTS `role` ENUM('admin', 'sub_admin', 'department_coordinator', 'alumni') DEFAULT 'alumni' AFTER `password`,
ADD COLUMN IF NOT EXISTS `username` VARCHAR(50) NULL AFTER `name`,
ADD COLUMN IF NOT EXISTS `whatsapp` VARCHAR(20) NULL AFTER `email`;

UPDATE `users` SET `role` = 'alumni' WHERE `role` IS NULL OR `role` = '';
```

### 📦 Solusi Alternatif

#### 1. Menggunakan Artisan Command

```bash
cd C:\laragon\www\ikasmadapangkep
php artisan fix:all-users-columns
```

#### 2. Menggunakan Tinker

```bash
cd C:\laragon\www\ikasmadapangkep
php artisan tinker < database\sql_fixes\fix_all_columns_tinker.php
```

#### 3. Jalankan Migrasi

```bash
cd C:\laragon\www\ikasmadapangkep
php artisan migrate
```

#### 4. PHP Script Manual

```bash
cd C:\laragon\www\ikasmadapangkep\database\sql_fixes
php fix_users_columns.php
```

## Verifikasi

Setelah menjalankan salah satu solusi di atas, verifikasi dengan:

1. **Cek Struktur Tabel** di phpMyAdmin:
   ```sql
   DESCRIBE users;
   ```

2. **Pastikan kolom-kolom ini ada**:
   - `last_login_at` (TIMESTAMP NULL)
   - `login_count` (INT UNSIGNED DEFAULT 0)
   - `failed_login_attempts` (INT UNSIGNED DEFAULT 0)
   - `login_locked_until` (TIMESTAMP NULL)
   - `role` (ENUM)
   - `username` (VARCHAR)
   - `whatsapp` (VARCHAR)

3. **Coba login kembali** ke aplikasi

## Troubleshooting

Jika masih ada error:

1. **Clear cache**:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   ```

2. **Restart Laragon/XAMPP**

3. **Cek file log** di `storage/logs/laravel.log`

## File-file yang Telah Diperbaiki

- ✅ `app/Http/Controllers/DashboardController.php` - Method index() ditambahkan
- ✅ `app/Models/User.php` - Sudah mendukung kolom login tracking
- ✅ `app/Http/Controllers/Auth/LoginController.php` - Sudah menggunakan updateLoginInfo()

## Kontak Support

Jika masih mengalami masalah, silakan hubungi developer.
