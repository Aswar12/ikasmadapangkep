# FIX: Profile Photo Column Missing

## Masalah
Error: `SQLSTATE[42S22]: Column not found: 1054 Unknown column 'profile_photo' in 'field list'`

Kolom `profile_photo` tidak ada di tabel `profiles`.

## Solusi

### Metode 1: Menggunakan Migration (Direkomendasikan)

1. **Jalankan script perbaikan otomatis**:
```bash
# Windows
fix-profile-photo-column.bat

# Linux/Mac
chmod +x fix-profile-photo-column.sh
./fix-profile-photo-column.sh
```

2. **Atau jalankan migration manual**:
```bash
php artisan migrate --force
```

3. **Jika migration tidak berjalan, jalankan spesifik migration**:
```bash
php artisan migrate --path=database/migrations/2025_05_30_000001_add_profile_photo_to_profiles_table.php --force
```

### Metode 2: Menggunakan Artisan Command

Saya telah membuat custom command untuk menambahkan kolom:

```bash
php artisan profile:add-photo-column
```

Command ini akan:
- Cek apakah tabel profiles ada
- Cek apakah kolom profile_photo sudah ada
- Menambahkan kolom jika belum ada
- Clear cache

### Metode 3: Manual via phpMyAdmin

Jika metode di atas tidak berhasil, tambahkan kolom manual:

1. Buka phpMyAdmin
2. Pilih database `ikasmadapangkep`
3. Pilih tabel `profiles`
4. Jalankan SQL query:
```sql
ALTER TABLE profiles ADD COLUMN profile_photo VARCHAR(255) NULL AFTER user_id;
```

### Metode 4: Refresh Migration (Hati-hati - Akan Menghapus Data)

**PERINGATAN**: Ini akan menghapus semua data di database!

```bash
php artisan migrate:refresh --seed
```

## File-file yang Terlibat

1. **Migration**: `database/migrations/2025_05_30_000001_add_profile_photo_to_profiles_table.php`
2. **Model**: `app/Models/Profile.php` (sudah ada `profile_photo` di $fillable)
3. **Command**: `app/Console/Commands/AddProfilePhotoColumn.php`
4. **Scripts**:
   - `fix-profile-photo-column.bat` (Windows)
   - `fix-profile-photo-column.sh` (Linux/Mac)

## Verifikasi

Setelah menambahkan kolom, verifikasi dengan:

1. **Cek struktur tabel di phpMyAdmin**
2. **Atau jalankan command**:
```bash
php artisan tinker
>>> \Illuminate\Support\Facades\Schema::hasColumn('profiles', 'profile_photo')
>>> exit
```

Hasilnya harus `true`.

## Troubleshooting

### Jika masih error setelah menambahkan kolom:

1. **Clear semua cache**:
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

2. **Restart server**:
- Stop dan start kembali Apache/Nginx
- Restart PHP

3. **Periksa koneksi database**:
- Pastikan `.env` file memiliki konfigurasi database yang benar
- Pastikan database `ikasmadapangkep` ada dan accessible

4. **Periksa Model Profile**:
- Pastikan `profile_photo` ada di array `$fillable`

## Catatan Penting

- Migration file sudah dibuat: `2025_05_30_000001_add_profile_photo_to_profiles_table.php`
- Model Profile sudah diupdate dengan `profile_photo` di $fillable
- User model sudah diupdate untuk handle profile photo
- Direktori `public/profile-photos` harus ada dan writable
