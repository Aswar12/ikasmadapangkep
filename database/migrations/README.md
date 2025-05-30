# Laravel Migrations untuk IKA SMADA Pangkep

## Daftar Migration Files

### Migration Dasar Laravel
1. `2024_01_01_000001_create_users_table.php` - Tabel users dengan role system
2. `2024_01_01_000002_create_password_reset_tokens_table.php` - Tabel untuk reset password
3. `2024_01_01_000003_create_sessions_table.php` - Tabel untuk session management
4. `2024_01_01_000004_create_cache_table.php` - Tabel untuk cache
5. `2024_01_01_000005_create_jobs_table.php` - Tabel untuk queue jobs
6. `2024_01_01_000006_create_personal_access_tokens_table.php` - Tabel untuk API tokens (Sanctum)

### Migration Fitur Aplikasi
7. `2024_01_01_000007_create_profiles_table.php` - Profil lengkap alumni
8. `2024_01_01_000008_create_departments_table.php` - 5 departemen organisasi
9. `2024_01_01_000009_create_programs_table.php` - Program kerja per departemen
10. `2024_01_01_000010_create_program_progress_table.php` - Progress tracking program kerja
11. `2024_01_01_000011_create_events_table.php` - Event alumni
12. `2024_01_01_000012_create_event_registrations_table.php` - Pendaftaran event
13. `2024_01_01_000013_create_job_vacancies_table.php` - Lowongan pekerjaan
14. `2024_01_01_000014_create_feedbacks_table.php` - Kritik dan saran
15. `2024_01_01_000015_create_testimonials_table.php` - Testimonial alumni
16. `2024_01_01_000016_create_activity_logs_table.php` - Log aktivitas sistem
17. `2024_01_01_000017_create_galleries_table.php` - Album foto per angkatan
18. `2024_01_01_000018_create_gallery_photos_table.php` - Foto dalam album
19. `2024_01_01_000019_create_photo_tags_table.php` - Tagging alumni dalam foto
20. `2024_01_01_000020_create_payments_table.php` - Pembayaran iuran tahunan
21. `2024_01_01_000021_create_transactions_table.php` - Arus kas keuangan
22. `2024_01_01_000022_create_notifications_table.php` - Notifikasi sistem
23. `2024_01_01_000023_create_documents_table.php` - Dokumen pendukung (polymorphic)

## Cara Menjalankan Migration

1. **Jalankan semua migration:**
   ```bash
   php artisan migrate
   ```

2. **Rollback migration:**
   ```bash
   php artisan migrate:rollback
   ```

3. **Reset dan re-run migration:**
   ```bash
   php artisan migrate:fresh
   ```

4. **Jalankan migration dengan seeder:**
   ```bash
   php artisan migrate:fresh --seed
   ```

## Seeder yang Tersedia

1. **DepartmentSeeder** - Mengisi 5 departemen:
   - Pendidikan & Pengembangan Karir
   - Humas & Pengembangan Jaringan
   - Agama, Budaya & Kemasyarakatan
   - Pembinaan Aparatur Organisasi
   - Keuangan & Kewirausahaan

2. **DatabaseSeeder** - Seeder utama yang memanggil semua seeder lain dan membuat:
   - Admin user default (email: admin@ikasmadapangkep.com, password: password)

## Role System

Aplikasi memiliki 4 level role:
1. **admin** - Akses penuh ke seluruh sistem
2. **sub_admin** - Koordinator angkatan
3. **department_coordinator** - Koordinator departemen
4. **alumni** - Akses dasar untuk alumni

## Fitur-fitur Utama

1. **Manajemen Pengguna** - Registrasi dengan approval, multi-role
2. **Profil Alumni** - Data lengkap termasuk pendidikan dan pekerjaan
3. **Departemen & Program Kerja** - Tracking progress program kerja
4. **Event & Lowongan** - Manajemen event dan lowongan pekerjaan
5. **Feedback & Testimonial** - Sistem kritik/saran dan testimonial
6. **Gallery** - Album foto per angkatan dengan tagging
7. **Keuangan** - Pembayaran iuran dan manajemen arus kas
8. **Notifikasi** - Sistem notifikasi untuk berbagai aktivitas
9. **Dokumentasi** - Upload dokumen pendukung (polymorphic)
10. **Activity Log** - Tracking seluruh aktivitas user

## Catatan Penting

- Pastikan database sudah dibuat sebelum menjalankan migration
- Default password untuk admin adalah 'password' - **HARUS DIGANTI** di production
- Semua tabel memiliki timestamps (created_at, updated_at)
- Foreign key constraints sudah diatur dengan cascade delete yang sesuai
- Index sudah ditambahkan untuk optimasi query
