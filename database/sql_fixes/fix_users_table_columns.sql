-- Script untuk menambahkan kolom-kolom yang hilang di tabel users
-- Jalankan script ini di database MySQL/MariaDB Anda

-- Tambahkan kolom last_login_at jika belum ada
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `last_login_at` TIMESTAMP NULL DEFAULT NULL;

-- Tambahkan kolom login_count jika belum ada
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `login_count` INT UNSIGNED NOT NULL DEFAULT 0;

-- Tambahkan kolom failed_login_attempts jika belum ada
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `failed_login_attempts` INT UNSIGNED NOT NULL DEFAULT 0;

-- Tambahkan kolom login_locked_until jika belum ada
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `login_locked_until` TIMESTAMP NULL DEFAULT NULL;

-- Verifikasi struktur tabel
DESCRIBE `users`;
