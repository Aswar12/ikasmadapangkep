# FIX PROFILE PHOTO UPLOAD

## Masalah
Error "Path must not be empty" saat mengupload foto profil di halaman `/alumni/profile/edit`.

## Penyebab
1. Method `updateProfilePhoto` di Model User menggunakan Laravel Storage yang terkadang gagal di environment Windows/Laragon
2. Path file yang dihasilkan kosong atau false ketika `store()` method gagal
3. Direktori penyimpanan tidak ada atau tidak memiliki permission yang tepat

## Solusi yang Diterapkan

### 1. Update Model User (`app/Models/User.php`)
- Mengubah method `updateProfilePhoto` untuk menggunakan pendekatan manual yang lebih reliable
- Menambahkan validasi file yang lebih ketat
- Menggunakan `move()` method langsung ke public folder daripada Laravel Storage
- Menambahkan logging untuk debugging
- Memperbaiki method `getProfilePhotoUrlAttribute` untuk mendukung kedua lokasi penyimpanan

### 2. Perubahan Detail:
```php
// Sebelum:
$path = $photo->store('profile-photos', 'public');

// Sesudah:
// Menggunakan pendekatan manual dengan validasi lengkap
$photo->move($storageDir, $filename);
```

### 3. Script Perbaikan
Dua script telah dibuat untuk setup environment:

#### Windows (`fix-profile-photo-upload.bat`):
- Membuat direktori `public/profile-photos`
- Mengatur permissions
- Membuat storage link
- Clear cache Laravel

#### Linux/Mac (`fix-profile-photo-upload.sh`):
- Sama seperti Windows dengan command Linux

## Cara Menggunakan

### 1. Jalankan Script Perbaikan
```bash
# Windows
fix-profile-photo-upload.bat

# Linux/Mac
chmod +x fix-profile-photo-upload.sh
./fix-profile-photo-upload.sh
```

### 2. Test Upload Foto
1. Login sebagai alumni
2. Pergi ke `/alumni/profile/edit`
3. Pilih foto (JPG, PNG, GIF, max 2MB)
4. Klik tombol "Upload"
5. Foto akan tersimpan di `public/profile-photos/`

## Struktur Penyimpanan
```
public/
└── profile-photos/
    ├── profile_1_1234567890.jpg
    ├── profile_2_1234567891.png
    └── ...
```

## Troubleshooting

### Jika masih error:
1. Pastikan folder `public/profile-photos` ada dan writable
2. Check Laravel log di `storage/logs/laravel.log`
3. Pastikan file upload tidak corrupt atau terlalu besar
4. Clear browser cache

### Permission Issues (Linux/Mac):
```bash
sudo chown -R www-data:www-data public/profile-photos
sudo chmod -R 755 public/profile-photos
```

### Permission Issues (Windows):
- Klik kanan folder `public/profile-photos`
- Properties > Security > Edit
- Add "Everyone" dengan Full Control

## Keuntungan Solusi Ini
1. ✅ Lebih reliable di Windows/Laragon environment
2. ✅ Tidak tergantung pada Laravel Storage symbolic link
3. ✅ Error handling yang lebih baik
4. ✅ Logging untuk debugging
5. ✅ Backward compatible dengan foto yang sudah ada
