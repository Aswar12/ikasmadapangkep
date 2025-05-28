-- Script untuk menambahkan SEMUA kolom yang dibutuhkan di tabel users
-- Jalankan script ini di database MySQL/MariaDB Anda

-- 1. Tambahkan kolom untuk login tracking
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `last_login_at` TIMESTAMP NULL DEFAULT NULL,
ADD COLUMN IF NOT EXISTS `login_count` INT UNSIGNED NOT NULL DEFAULT 0,
ADD COLUMN IF NOT EXISTS `failed_login_attempts` INT UNSIGNED NOT NULL DEFAULT 0,
ADD COLUMN IF NOT EXISTS `login_locked_until` TIMESTAMP NULL DEFAULT NULL;

-- 2. Tambahkan kolom role jika belum ada
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `role` ENUM('admin', 'sub_admin', 'department_coordinator', 'alumni') DEFAULT 'alumni' AFTER `password`;

-- 3. Tambahkan kolom username jika belum ada
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `username` VARCHAR(50) NULL AFTER `name`;

-- 4. Tambahkan kolom whatsapp jika belum ada
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `whatsapp` VARCHAR(20) NULL AFTER `email`;

-- 5. Update semua user yang belum punya role menjadi 'alumni'
UPDATE `users` SET `role` = 'alumni' WHERE `role` IS NULL OR `role` = '';

-- 6. Verifikasi struktur tabel
DESCRIBE `users`;

-- 7. Cek jumlah user per role
SELECT `role`, COUNT(*) as total FROM `users` GROUP BY `role`;
