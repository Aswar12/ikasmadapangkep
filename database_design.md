# Desain Database Sistem Informasi IKA SMADA Pangkep

## Pendahuluan

Dokumen ini berisi desain database untuk Sistem Informasi Alumni IKA SMADA Pangkep. Database dirancang untuk mendukung semua fitur yang diperlukan sesuai dengan daftar kebutuhan fitur.

## Struktur Tabel

### 1. Modul Manajemen Pengguna

#### Tabel: `users`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| name | string | Nama lengkap pengguna |
| username | string | Username untuk login (nullable) |
| email | string | Email untuk login, unique |
| email_verified_at | timestamp | Waktu verifikasi email (nullable) |
| password | string | Password yang terenkripsi |
| ip_address | string(45) | Alamat IP terakhir login (nullable) |
| activation_code | string | Kode aktivasi akun (nullable) |
| forgotten_password_code | string | Kode reset password (nullable) |
| forgotten_password_time | timestamp | Waktu request reset password (nullable) |
| remember_code | string | Kode remember me (nullable) |
| created_on | timestamp | Waktu pembuatan akun (nullable) |
| last_login | timestamp | Waktu login terakhir (nullable) |
| active | boolean | Status aktivasi akun (default: false) |
| first_name | string | Nama depan (nullable) |
| last_name | string | Nama belakang (nullable) |
| graduation_year | string | Tahun kelulusan (nullable) |
| phone | string | Nomor telepon (nullable) |
| role | enum | Peran: 'admin', 'sub_admin', 'department_coordinator', 'alumni' (default: 'alumni') |
| remember_token | string | Token untuk fitur "remember me" (nullable) |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |

#### Tabel: `password_reset_tokens`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| email | string | Email (primary key) |
| token | string | Token reset password |
| created_at | timestamp | Waktu pembuatan token (nullable) |

#### Tabel: `login_attempts`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| ip_address | string(45) | Alamat IP yang mencoba login |
| login | string | Email/username yang digunakan |
| time | integer | Waktu percobaan login (UNIX timestamp) |
| success | boolean | Status keberhasilan login (default: false) |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |

#### Tabel: `system_logs`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| user_id | bigint | Foreign key ke tabel users (nullable) |
| action | string | Aksi yang dilakukan |
| module | string | Modul yang terlibat |
| description | text | Deskripsi log |
| old_values | json | Nilai lama (nullable) |
| new_values | json | Nilai baru (nullable) |
| ip_address | string | Alamat IP (nullable) |
| user_agent | string | User agent browser (nullable) |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |

### 2. Modul Grup & Peran

#### Tabel: `groups`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| name | string | Nama grup |
| description | text | Deskripsi grup (nullable) |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |

#### Tabel: `users_groups`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| user_id | bigint | Foreign key ke tabel users (cascade on delete) |
| group_id | bigint | Foreign key ke tabel groups (cascade on delete) |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |
| [user_id, group_id] | | Unique constraint |

### 3. Modul Profil Alumni

#### Tabel: `profiles`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| user_id | bigint | Foreign key ke tabel users (cascade on delete) |
| gender | string | Jenis kelamin (nullable) |
| birth_place | string | Tempat lahir (nullable) |
| birth_date | date | Tanggal lahir (nullable) |
| national_student_number | string | NISN (nullable) |
| address | text | Alamat lengkap (nullable) |
| phone_number | string | Nomor telepon (nullable) |
| father_name | string | Nama ayah (nullable) |
| father_occupation | string | Pekerjaan ayah (nullable) |
| mother_name | string | Nama ibu (nullable) |
| mother_occupation | string | Pekerjaan ibu (nullable) |
| entry_year | string | Tahun masuk sekolah (nullable) |
| graduation_year | string | Tahun lulus (nullable) |
| diploma_number | string | Nomor ijazah (nullable) |
| certificate_number | string | Nomor sertifikat (nullable) |
| profile_photo | string | Path foto profil (nullable) |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |

#### Tabel: `alumni_statuses`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| name | string | Nama status alumni |
| description | string | Deskripsi status (nullable) |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |

#### Tabel: `profession_references`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| name | string | Nama profesi (unique) |
| description | string | Deskripsi profesi (nullable) |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |

#### Tabel: `year_references`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| year | integer | Tahun kelulusan (unique) |
| description | string | Deskripsi tahun (nullable) |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |

### 4. Modul Departemen & Program Kerja

#### Tabel: `departments`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| name | string | Nama departemen |
| description | text | Deskripsi departemen (nullable) |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |

#### Tabel: `user_departments`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| user_id | bigint | Foreign key ke tabel users (cascade on delete) |
| department_id | bigint | Foreign key ke tabel departments (cascade on delete) |
| is_coordinator | boolean | Status koordinator (default: false) |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |
| [user_id, department_id] | | Unique constraint |

#### Tabel: `program_kerja`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| department_id | bigint | Foreign key ke tabel departments (cascade on delete) |
| name | string | Nama program kerja |
| description | text | Deskripsi program kerja (nullable) |
| start_date | date | Tanggal mulai (nullable) |
| end_date | date | Tanggal selesai (nullable) |
| location | string | Lokasi (nullable) |
| budget | decimal(12,2) | Anggaran (nullable) |
| pic_user_id | bigint | Foreign key ke tabel users - penanggung jawab (nullable) |
| progress_percentage | integer | Persentase progress (default: 0) |
| current_progress | text | Keterangan progress terkini (nullable) |
| status | enum | Status: 'planning', 'in_progress', 'completed', 'delayed', 'cancelled' (default: 'planning') |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |

#### Tabel: `program_kerja_updates`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| program_kerja_id | bigint | Foreign key ke tabel program_kerja (cascade on delete) |
| user_id | bigint | Foreign key ke tabel users (cascade on delete) |
| update_description | text | Deskripsi update |
| progress_percentage | integer | Persentase progress update (default: 0) |
| document_path | string | Path dokumen pendukung (nullable) |
| update_date | date | Tanggal update |
| updated_by | bigint | Foreign key ke tabel users - user yang melakukan update (nullable) |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |

### 5. Modul Event & Lowongan

#### Tabel: `events`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| event_name | string | Nama event |
| event_title | string | Judul event |
| event_slug | string | Slug event untuk URL (unique) |
| description | text | Deskripsi event (nullable) |
| event_date | datetime | Tanggal dan waktu event (nullable) |
| location | string | Lokasi event (nullable) |
| ticket_price | decimal(10,2) | Harga tiket (nullable) |
| quota | integer | Kuota peserta (nullable) |
| poster_image | string | Path poster event (nullable) |
| created_by | bigint | Foreign key ke tabel users - user yang membuat event (nullable) |
| posting_date | timestamp | Tanggal posting event |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |

#### Tabel: `event_registrations`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| event_id | bigint | Foreign key ke tabel events (cascade on delete) |
| user_id | bigint | Foreign key ke tabel users (cascade on delete) |
| status | enum | Status: 'registered', 'confirmed', 'attended', 'cancelled' (default: 'registered') |
| notes | text | Catatan (nullable) |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |
| [event_id, user_id] | | Unique constraint |

#### Tabel: `job_vacancies`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| user_id | bigint | Foreign key ke tabel users (cascade on delete) |
| company_name | string | Nama perusahaan |
| position | string | Posisi yang dibutuhkan |
| description | text | Deskripsi lowongan (nullable) |
| requirements | text | Persyaratan (nullable) |
| location | string | Lokasi kerja (nullable) |
| salary_min | decimal(15,2) | Gaji minimum (nullable) |
| salary_max | decimal(15,2) | Gaji maksimum (nullable) |
| is_salary_disclosed | boolean | Status tampil gaji (default: false) |
| application_deadline | date | Batas waktu lamaran (nullable) |
| application_link | string | Link untuk melamar (nullable) |
| contact_email | string | Email kontak (nullable) |
| contact_phone | string | Nomor telepon kontak (nullable) |
| company_logo | string | Path logo perusahaan (nullable) |
| is_active | boolean | Status aktif (default: true) |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |

### 6. Modul Feedback & Testimonial

#### Tabel: `feedbacks`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| user_id | bigint | Foreign key ke tabel users (nullable) |
| name | string | Nama pengirim feedback (nullable) |
| email | string | Email pengirim feedback (nullable) |
| subject | string | Subjek feedback |
| message | text | Isi pesan feedback |
| is_anonymous | boolean | Status anonim (default: false) |
| is_read | boolean | Status telah dibaca (default: false) |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |

#### Tabel: `testimonials`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| user_id | bigint | Foreign key ke tabel users (cascade on delete) |
| content | text | Isi testimonial |
| is_approved | boolean | Status disetujui (default: false) |
| is_featured | boolean | Status ditonjolkan (default: false) |
| display_order | integer | Urutan tampilan (nullable) |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |

### 7. Modul Gallery

#### Tabel: `albums`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| title | string | Judul album |
| description | text | Deskripsi album (nullable) |
| created_by | bigint | Foreign key ke tabel users (cascade on delete) |
| event_date | date | Tanggal event (nullable) |
| graduation_year | string | Tahun angkatan (nullable) |
| is_public | boolean | Status publik (default: true) |
| cover_image | string | Path cover image (nullable) |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |

#### Tabel: `photos`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| album_id | bigint | Foreign key ke tabel albums (cascade on delete) |
| user_id | bigint | Foreign key ke tabel users (cascade on delete) |
| title | string | Judul foto (nullable) |
| description | text | Deskripsi foto (nullable) |
| file_path | string | Path file foto |
| file_size | integer | Ukuran file foto (KB) |
| mime_type | string | Tipe MIME |
| width | integer | Lebar foto (pixels) (nullable) |
| height | integer | Tinggi foto (pixels) (nullable) |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |

#### Tabel: `photo_tags`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| photo_id | bigint | Foreign key ke tabel photos (cascade on delete) |
| user_id | bigint | Foreign key ke tabel users (cascade on delete) |
| position_x | integer | Posisi X tag (nullable) |
| position_y | integer | Posisi Y tag (nullable) |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |
| [photo_id, user_id] | | Unique constraint |

#### Tabel: `gallery_access`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| album_id | bigint | Foreign key ke tabel albums (cascade on delete) |
| user_id | bigint | Foreign key ke tabel users (nullable) |
| group_id | bigint | Foreign key ke tabel groups (nullable) |
| year_id | bigint | Foreign key ke tabel year_references (nullable) |
| access_type | enum | Tipe akses: 'view', 'edit', 'upload', 'delete' (default: 'view') |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |

### 8. Modul Keuangan

#### Tabel: `payments`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| user_id | bigint | Foreign key ke tabel users (cascade on delete) |
| amount | decimal(10,2) | Jumlah pembayaran (default: 50000.00) |
| status | enum | Status: 'belum_bayar', 'menunggu_verifikasi', 'sudah_lunas' (default: 'belum_bayar') |
| payment_date | timestamp | Waktu pembayaran (nullable) |
| payment_method | string | Metode pembayaran (nullable) |
| payment_proof | string | Path bukti pembayaran (nullable) |
| year_period | string | Tahun periode pembayaran (nullable) |
| notes | text | Catatan (nullable) |
| verified_by | bigint | Foreign key ke tabel users - verifikator (nullable) |
| verification_date | timestamp | Waktu verifikasi (nullable) |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |

#### Tabel: `payment_reminders`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| user_id | bigint | Foreign key ke tabel users (cascade on delete) |
| year_id | bigint | Foreign key ke tabel year_references (cascade on delete) |
| due_date | date | Tanggal jatuh tempo |
| is_sent | boolean | Status telah dikirim (default: false) |
| sent_at | timestamp | Waktu pengiriman (nullable) |
| message | text | Isi pesan pengingat (nullable) |
| status | enum | Status: 'pending', 'sent', 'paid' (default: 'pending') |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |
| [user_id, year_id] | | Unique constraint |

#### Tabel: `cash_flow_categories`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| name | string | Nama kategori |
| type | enum | Tipe: 'income', 'expense' (default: 'expense') |
| description | text | Deskripsi kategori (nullable) |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |
| [name, type] | | Unique constraint |

#### Tabel: `cash_flows`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| transaction_type | enum | Tipe transaksi: 'income', 'expense' (default: 'income') |
| category_id | bigint | Foreign key ke tabel cash_flow_categories (cascade on delete) |
| amount | decimal(12,2) | Jumlah transaksi |
| transaction_date | date | Tanggal transaksi |
| description | string | Deskripsi transaksi (nullable) |
| receipt_image | string | Path bukti transaksi (nullable) |
| department_id | bigint | Foreign key ke tabel departments (nullable) |
| program_kerja_id | bigint | Foreign key ke tabel program_kerja (nullable) |
| created_by | bigint | Foreign key ke tabel users (cascade on delete) |
| approved_by | bigint | Foreign key ke tabel users - approver (nullable) |
| approval_date | timestamp | Waktu persetujuan (nullable) |
| status | enum | Status: 'pending', 'approved', 'rejected' (default: 'pending') |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |

### 9. Modul Dokumentasi

#### Tabel: `documents`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| title | string | Judul dokumen |
| description | text | Deskripsi dokumen (nullable) |
| department_id | bigint | Foreign key ke tabel departments (nullable) |
| program_kerja_id | bigint | Foreign key ke tabel program_kerja (nullable) |
| document_type | enum | Tipe dokumen: 'report', 'proposal', 'minutes', 'letter', 'other' (default: 'other') |
| uploaded_by | bigint | Foreign key ke tabel users (cascade on delete) |
| current_version | string | Versi dokumen saat ini (default: '1.0') |
| is_versioned | boolean | Status versioning (default: false) |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |

#### Tabel: `document_versions`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| document_id | bigint | Foreign key ke tabel documents (cascade on delete) |
| version | string | Nomor versi |
| change_notes | text | Catatan perubahan (nullable) |
| file_path | string | Path file dokumen |
| file_size | integer | Ukuran file (KB) |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |

#### Tabel: `document_access`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| document_id | bigint | Foreign key ke tabel documents (cascade on delete) |
| user_id | bigint | Foreign key ke tabel users (nullable) |
| group_id | bigint | Foreign key ke tabel groups (nullable) |
| department_id | bigint | Foreign key ke tabel departments (nullable) |
| access_type | enum | Tipe akses: 'view', 'edit', 'delete' (default: 'view') |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |

### 10. Modul Notifikasi

#### Tabel: `notifications`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| user_id | bigint | Foreign key ke tabel users (cascade on delete) |
| title | string | Judul notifikasi |
| message | text | Isi notifikasi |
| type | string | Tipe notifikasi (nullable) |
| link | string | Link terkait (nullable) |
| is_read | boolean | Status telah dibaca (default: false) |
| read_at | timestamp | Waktu dibaca (nullable) |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |

#### Tabel: `notification_settings`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| user_id | bigint | Foreign key ke tabel users (cascade on delete) |
| email_event | boolean | Notifikasi event via email (default: true) |
| email_payment | boolean | Notifikasi pembayaran via email (default: true) |
| email_program | boolean | Notifikasi program kerja via email (default: true) |
| email_news | boolean | Notifikasi berita via email (default: true) |
| push_event | boolean | Notifikasi event via push (default: true) |
| push_payment | boolean | Notifikasi pembayaran via push (default: true) |
| push_program | boolean | Notifikasi program kerja via push (default: true) |
| push_news | boolean | Notifikasi berita via push (default: true) |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |
| [user_id] | | Unique constraint |

### 11. Modul PWA (Progressive Web App)

#### Tabel: `pwa_settings`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| name | string | Nama aplikasi |
| short_name | string | Nama singkat aplikasi |
| description | text | Deskripsi aplikasi |
| theme_color | string | Warna tema aplikasi |
| background_color | string | Warna latar aplikasi |
| icons | json | Data ikon aplikasi |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |

#### Tabel: `push_subscriptions`
| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | bigint | Primary key, auto increment |
| user_id | bigint | Foreign key ke tabel users (cascade on delete) |
| endpoint | string | Endpoint notifikasi push (unique) |
| public_key | string | Public key (nullable) |
| auth_token | string | Auth token (nullable) |
| created_at | timestamp | Waktu pembuatan record |
| updated_at | timestamp | Waktu pembaruan record terakhir |

## Relasi Antar Tabel

Berikut adalah relasi utama antar tabel:

1. `users` dengan `profiles`: one-to-one
2. `users` dengan `groups` (melalui `users_groups`): many-to-many
3. `users` dengan `departments` (melalui `user_departments`): many-to-many
4. `departments` dengan `program_kerja`: one-to-many
5. `program_kerja` dengan `program_kerja_updates`: one-to-many
6. `events` dengan `event_registrations`: one-to-many
7. `users` dengan `testimonials`: one-to-many
8. `users` dengan `job_vacancies`: one-to-many
9. `users` dengan `feedbacks`: one-to-many
10. `users` dengan `payments`: one-to-many
11. `users` dengan `payment_reminders`: one-to-many
12. `albums` dengan `photos`: one-to-many
13. `photos` dengan `photo_tags`: one-to-many
14. `cash_flow_categories` dengan `cash_flows`: one-to-many
15. `documents` dengan `document_versions`: one-to-many
16. `documents` dengan `document_access`: one-to-many
17. `users` dengan `notifications`: one-to-many
18. `users` dengan `notification_settings`: one-to-one

## Indeks dan Optimasi

1. Foreign key indeks untuk semua kolom foreign key
2. Unique constraint untuk relasi many-to-many
3. Indeks untuk kolom yang sering digunakan untuk pencarian seperti email, username, nama, tahun, dsb
4. Indeks untuk kolom tanggal yang sering digunakan untuk filter seperti event_date, transaction_date, dsb

## Catatan Implementasi

1. Tabel users memiliki kolom role untuk mendukung 4 level peran (admin, sub_admin, department_coordinator, alumni)
2. Modul gallery memiliki kontrol akses yang disesuaikan dengan kebutuhan untuk koordinator angkatan
3. Modul keuangan mencakup pembayaran, reminder, dan arus kas untuk mendukung pengelolaan keuangan yang komprehensif
4. Sistem notifikasi terintegrasi dengan PWA untuk mendukung notifikasi push
5. Sistem dokumen mendukung versioning untuk melacak perubahan dokumen
6. Tabel event_registrations memungkinkan pendaftaran event dan tracking status kehadiran
7. Modul job_vacancies memungkinkan alumni memposting dan mencari lowongan pekerjaan

Database dirancang dengan mempertimbangkan skalabilitas, kinerja, dan kemudahan pemeliharaan. Semua fitur yang dibutuhkan dalam features_list.md telah diimplementasikan dalam skema database.
