# Rangkuman Struktur Database dan Fitur Sistem IKA SMADA Pangkep

## 1. Struktur Database Lengkap

### Tabel Utama Database

#### A. Modul Manajemen Pengguna
- **users**: Tabel pengguna dengan role (admin, sub_admin, department_coordinator, alumni)
- **profiles**: Data lengkap profil alumni (pribadi, orang tua, pendidikan, pekerjaan)
- **password_reset_tokens**: Token reset password
- **login_attempts**: Log percobaan login
- **sessions**: Sesi pengguna aktif

#### B. Modul Organisasi & Departemen
- **departments**: Departemen/divisi dalam organisasi IKA
- **programs**: Program kerja per departemen
- **program_progress**: Progress tracking program kerja

#### C. Modul Event & Kegiatan  
- **events**: Event/kegiatan yang diselenggarakan
- **event_registrations**: Pendaftaran peserta event

#### D. Modul Karir & Lowongan
- **job_vacancies**: Lowongan pekerjaan

#### E. Modul Komunikasi
- **feedbacks**: Feedback/saran dari alumni
- **testimonials**: Testimoni alumni
- **notifications**: Sistem notifikasi

#### F. Modul Media & Galeri
- **galleries**: Album foto kegiatan
- **gallery_photos**: Foto-foto dalam album
- **photo_tags**: Tag pada foto

#### G. Modul Keuangan
- **payments**: Pembayaran iuran alumni
- **transactions**: Transaksi keuangan

#### H. Modul Sistem
- **activity_logs**: Log aktivitas sistem
- **jobs**: Queue pekerjaan Laravel
- **cache**: Cache sistem
- **personal_access_tokens**: Token API

## 2. Mapping Fitur Berdasarkan Program Kerja Departemen

### Departemen 1: Pendidikan dan Pengembangan Karir

#### Kegiatan yang Perlu Diakomodasi:
1. **Sosialisasi penjurusan minat dan karir**
   - Tabel terkait: `events`, `event_registrations`
   - Fitur: Event management, pendaftaran peserta

2. **Sharing session alumni dan siswa**
   - Tabel terkait: `events`, `testimonials`
   - Fitur: Event scheduling, testimoni alumni

3. **Seminar Nasional peningkatan kapasitas**
   - Tabel terkait: `events`, `payments`, `event_registrations`
   - Fitur: Event berbayar, manajemen peserta

4. **MOU Pengembangan karir dengan BPVP/BLK**
   - Tabel terkait: `job_vacancies`, `profiles`
   - Fitur: Job posting, career tracking

#### Fitur Database yang Diperlukan:
- ✅ Event management system (`events`, `event_registrations`)
- ✅ Payment system untuk event berbayar (`payments`)
- ✅ Career tracking dalam profile (`profiles`)
- ⚠️ **Perlu ditambah**: Tabel `partnerships` untuk MOU
- ⚠️ **Perlu ditambah**: Tabel `career_programs` untuk program karir

### Departemen 2: Humas dan Pengembangan Jaringan

#### Kegiatan yang Perlu Diakomodasi:
1. **Mengelola sosial media**
   - Tabel terkait: `galleries`, `gallery_photos`
   - Fitur: Content management, photo gallery

2. **Website IKA untuk register alumni**
   - Tabel terkait: `users`, `profiles`
   - Fitur: ✅ Sudah ada sistem registrasi

3. **Database alumni kerjasama operator dapodik**
   - Tabel terkait: `users`, `profiles`
   - Fitur: ✅ Sudah ada sistem database alumni

4. **Film dokumenter & foto studio**
   - Tabel terkait: `galleries`, `gallery_photos`
   - Fitur: Media management

#### Fitur Database yang Diperlukan:
- ✅ User registration system (`users`, `profiles`)
- ✅ Media gallery system (`galleries`, `gallery_photos`, `photo_tags`)
- ⚠️ **Perlu ditambah**: Tabel `media_content` untuk video/dokumenter
- ⚠️ **Perlu ditambah**: Tabel `social_media_posts` untuk manajemen konten sosmed

### Departemen 3: Agama, Budaya dan Kemasyarakatan

#### Kegiatan yang Perlu Diakomodasi:
1. **Pengajian/perayaan keagamaan**
2. **Halal bihalal**
3. **Bakti sosial**
4. **Galang dana untuk bencana/bantuan**
5. **Pelatihan dakwah**
6. **Kegiatan ramadhan**
7. **Pembinaan baca Quran/Rohis**

#### Fitur Database yang Diperlukan:
- ✅ Event system untuk semua kegiatan (`events`, `event_registrations`)
- ⚠️ **Perlu ditambah**: Tabel `donations` untuk galang dana
- ⚠️ **Perlu ditambah**: Tabel `donation_campaigns` untuk kampanye donasi
- ⚠️ **Perlu ditambah**: Tabel `religious_activities` untuk kegiatan keagamaan

### Departemen 4: Pembinaan Aparatur Organisasi

#### Kegiatan yang Perlu Diakomodasi:
1. **Pengadaan sekretariat tetap** (Rp 30 juta)
2. **Pembuatan kalender kegiatan** (Rp 500 ribu)
3. **Pengadaan mading** (Rp 500 ribu)
4. **Inventaris IKA** (Rp 5 juta)
5. **Laporan kegiatan 6 bulanan** (Rp 1 juta)

#### Fitur Database yang Diperlukan:
- ✅ Budget tracking dalam programs (`programs.budget`, `programs.realization`)
- ⚠️ **Perlu ditambah**: Tabel `inventory_items` untuk inventaris
- ⚠️ **Perlu ditambah**: Tabel `reports` untuk laporan kegiatan
- ⚠️ **Perlu ditambah**: Tabel `budget_allocations` untuk alokasi anggaran

### Departemen 5: Keuangan dan Kewirausahaan

#### Kegiatan yang Perlu Diakomodasi:
1. **Kartu anggota** (Rp 45.000/anggota)
2. **QRIS IKA** (gratis)
3. **Pelatihan kewirausahaan** (Rp 25 juta)
4. **Pencairan dana** (Rp 50.000/tahun)
5. **Baju kaos IKA**
6. **Kerjasama bank HIMBARA**

#### Fitur Database yang Diperlukan:
- ✅ Payment system (`payments`, `transactions`)
- ⚠️ **Perlu ditambah**: Tabel `membership_cards` untuk kartu anggota
- ⚠️ **Perlu ditambah**: Tabel `qris_transactions` untuk transaksi QRIS
- ⚠️ **Perlu ditambah**: Tabel `entrepreneurship_programs` untuk program kewirausahaan
- ⚠️ **Perlu ditambah**: Tabel `bank_partnerships` untuk kerjasama bank

## 3. Tabel Tambahan yang Diperlukan

### A. Tabel untuk Kemitraan dan MOU
```sql
CREATE TABLE partnerships (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    partner_name VARCHAR(255) NOT NULL,
    partner_type ENUM('government', 'private', 'education', 'ngo') NOT NULL,
    description TEXT,
    start_date DATE,
    end_date DATE,
    status ENUM('active', 'expired', 'terminated') DEFAULT 'active',
    contact_person VARCHAR(255),
    contact_phone VARCHAR(20),
    contact_email VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### B. Tabel untuk Donasi dan Galang Dana
```sql
CREATE TABLE donation_campaigns (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    target_amount DECIMAL(12,2) NOT NULL,
    collected_amount DECIMAL(12,2) DEFAULT 0,
    start_date DATE NOT NULL,
    end_date DATE,
    status ENUM('active', 'completed', 'cancelled') DEFAULT 'active',
    created_by BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE donations (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    campaign_id BIGINT,
    donor_id BIGINT,
    donor_name VARCHAR(255),
    amount DECIMAL(10,2) NOT NULL,
    message TEXT,
    is_anonymous BOOLEAN DEFAULT FALSE,
    payment_method VARCHAR(50),
    payment_proof VARCHAR(255),
    status ENUM('pending', 'verified', 'rejected') DEFAULT 'pending',
    verified_by BIGINT,
    verified_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (campaign_id) REFERENCES donation_campaigns(id) ON DELETE CASCADE,
    FOREIGN KEY (donor_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (verified_by) REFERENCES users(id) ON DELETE SET NULL
);
```

### C. Tabel untuk Inventaris
```sql
CREATE TABLE inventory_categories (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE inventory_items (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    category_id BIGINT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    quantity INT DEFAULT 1,
    unit VARCHAR(50),
    purchase_price DECIMAL(10,2),
    purchase_date DATE,
    condition_status ENUM('excellent', 'good', 'fair', 'poor', 'damaged') DEFAULT 'good',
    location VARCHAR(255),
    responsible_person BIGINT,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES inventory_categories(id) ON DELETE SET NULL,
    FOREIGN KEY (responsible_person) REFERENCES users(id) ON DELETE SET NULL
);
```

### D. Tabel untuk Kartu Anggota
```sql
CREATE TABLE membership_cards (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    card_number VARCHAR(20) UNIQUE NOT NULL,
    issue_date DATE NOT NULL,
    expiry_date DATE,
    status ENUM('active', 'expired', 'suspended') DEFAULT 'active',
    card_type ENUM('physical', 'digital', 'both') DEFAULT 'digital',
    printed_at TIMESTAMP NULL,
    delivered_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## 4. Estimasi Anggaran dari Database

### Total Anggaran Program Kerja per Departemen:
1. **Pendidikan & Pengembangan Karir**: Rp 27.500.000
2. **Humas & Pengembangan Jaringan**: Rp 2.000.000+ (40% dari sosmed)
3. **Agama, Budaya & Kemasyarakatan**: Tidak disebutkan detail
4. **Pembinaan Aparatur**: Rp 37.000.000
5. **Keuangan & Kewirausahaan**: Rp 25.000.000+ (kartu anggota dari ketua umum)

### Total Estimasi Minimum: **Rp 91.500.000** untuk periode 2025-2030

## 5. Prioritas Pengembangan Fitur

### Fase 1 (Immediate) - Core Features
- ✅ User management & registration
- ✅ Profile management
- ✅ Event management
- ✅ Payment system (iuran alumni)

### Fase 2 (Short Term) - Department Features
- 🔄 Program kerja departemen tracking
- 🔄 Donation & fundraising system
- 🔄 Inventory management
- 🔄 Membership card system

### Fase 3 (Medium Term) - Advanced Features
- 📋 Partnership & MOU management
- 📋 Advanced reporting system
- 📋 QRIS integration
- 📋 Social media content management

### Fase 4 (Long Term) - Integration & Automation
- 📋 Bank integration (HIMBARA)
- 📋 Automated reporting
- 📋 Mobile app
- 📋 Advanced analytics

## 6. Rekomendasi Teknis

1. **Database Optimization**: Tambahkan indexing pada kolom yang sering diquery
2. **Security**: Implementasi rate limiting untuk login attempts
3. **Backup Strategy**: Automated backup untuk data keuangan dan member
4. **API Development**: Buat API untuk integrasi dengan sistem eksternal
5. **Mobile Responsive**: Pastikan semua fitur mobile-friendly
6. **Notification System**: Real-time notification untuk event dan payment
7. **Report Generation**: Automated report untuk laporan bulanan/6 bulanan

---

*Dokumen ini dibuat berdasarkan analisis struktur database existing dan program kerja departemen IKA SMADA Pangkep periode 2025-2030*