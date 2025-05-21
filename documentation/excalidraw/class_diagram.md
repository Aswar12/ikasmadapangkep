# Class Diagram untuk IKA SMADA Pangkep

## Struktur Dasar Class

```
┌─────────────────┐
│     User        │
├─────────────────┤
│ id: bigint      │
│ name: string    │
│ email: string   │
│ password: string│
│ role: enum      │
├─────────────────┤
│ login()         │
│ logout()        │
│ updateProfile() │
└─────────────────┘
```

## Class Utama dan Relasi

### User Management
- **User** - Informasi dasar pengguna
- **Profile** - Detail profil alumni (1:1 dengan User)
- **AlumniStatus** - Status pekerjaan/pendidikan alumni (1:1 dengan User)

### Organisasi
- **Department** - Departemen dalam organisasi
- **Group** - Kelompok alumni (termasuk angkatan)
- **UserDepartment** - Hubungan user dengan departemen (M:N)
- **UserGroup** - Hubungan user dengan group/angkatan (M:N)

### Program & Kegiatan
- **ProgramKerja** - Program kerja departemen
- **ProgramUpdate** - Update progress program kerja
- **Event** - Kegiatan dan acara
- **EventRegistration** - Pendaftaran acara

### Keuangan
- **Payment** - Pembayaran iuran
- **CashFlow** - Arus kas (pemasukan/pengeluaran)

### Media & Dokumentasi
- **Album** - Album galeri
- **Photo** - Foto dalam album
- **PhotoTag** - Tag alumni dalam foto
- **Document** - Dokumen organisasi
- **DocumentVersion** - Versi dokumen

### Komunikasi
- **Notification** - Notifikasi ke pengguna
- **MUBES** - Musyawarah Besar
- **MUBESDecision** - Keputusan MUBES

## Contoh Relasi dan Kardinalitas

- User (1) ──────► Profile (1)
- User (1) ──────► AlumniStatus (1)
- User (M) ◄──────► Department (N)
- User (M) ◄──────► Group (N)
- Department (1) ──────► ProgramKerja (N)
- ProgramKerja (1) ──────► ProgramUpdate (N)
- Event (1) ──────► EventRegistration (N)
- User (1) ──────► Payment (N)
- Album (1) ──────► Photo (N)
- Photo (1) ──────► PhotoTag (N)

## Tips Pembuatan di Excalidraw

1. Mulai dengan class utama (**User**)
2. Tambahkan class terkait di sekitarnya
3. Buat relasi dengan arrow dan tambahkan kardinalitas
4. Gunakan warna berbeda untuk kategori class berbeda
5. Pastikan semua relasi terhubung dengan benar
