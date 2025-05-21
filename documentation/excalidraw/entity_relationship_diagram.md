# Entity Relationship Diagram (ERD) IKA SMADA Pangkep

## ERD Struktur Utama

```
┌───────────────┐      ┌───────────────┐      ┌───────────────┐
│     users     │      │    profiles   │      │ alumni_status │
├───────────────┤      ├───────────────┤      ├───────────────┤
│ id (PK)       │──1──┬→1─ id (PK)       │      │ id (PK)       │
│ name          │     │  │ user_id (FK)  │←─┬─1─│ user_id (FK)  │
│ email         │     │  │ gender        │   │  │ status        │
│ password      │     │  │ birth_date    │   │  │ company_name  │
│ role          │     │  │ address       │   │  │ position      │
│ active        │     │  │ ...           │   │  │ ...           │
└─────────┬─────┘     │  └───────────────┘   │  └───────────────┘
          │           │                       │
          │           │                       │
    ┌─────┴─────┐     │                       │
    │           │     │                       │
    │           │     │                       │
    ↓           ↓     │                       │
┌───────────────┐     │  ┌───────────────┐    │
│ user_groups   │     │  │ user_depts    │    │
├───────────────┤     │  ├───────────────┤    │
│ id (PK)       │     │  │ id (PK)       │    │
│ user_id (FK)  │     │  │ user_id (FK)  │    │
│ group_id (FK) │     │  │ dept_id (FK)  │    │
│ role          │     │  │ role          │    │
└────────┬──────┘     │  └────────┬──────┘    │
         │            │           │           │
         │            │           │           │
         ↓            │           ↓           │
┌───────────────┐     │  ┌───────────────┐    │
│    groups     │     │  │  departments  │    │
├───────────────┤     │  ├───────────────┤    │
│ id (PK)       │     │  │ id (PK)       │    │
│ name          │     │  │ name          │    │
│ description   │     │  │ description   │    │
│ graduation_yr │     │  │ coordinator_id│    │
└───────────────┘     │  └───────┬───────┘    │
                      │          │            │
                      │          │            │
┌───────────────┐     │          ↓            │
│   payments    │     │  ┌───────────────┐    │
├───────────────┤     │  │ program_kerja │    │
│ id (PK)       │     │  ├───────────────┤    │
│ user_id (FK)  │←────┘  │ id (PK)       │    │
│ payment_year  │        │ dept_id (FK)  │    │
│ amount        │        │ name          │    │
│ status        │        │ description   │    │
│ ...           │        │ progress      │    │
└───────────────┘        │ status        │    │
                         └───────────────┘    │
                                              │
┌───────────────┐                             │
│    events     │                             │
├───────────────┤                             │
│ id (PK)       │                             │
│ title         │                             │
│ description   │                             │
│ start_date    │                             │
│ ...           │                             │
└───────┬───────┘                             │
        │                                     │
        ↓                                     │
┌───────────────┐                             │
│event_registers│                             │
├───────────────┤                             │
│ id (PK)       │                             │
│ event_id (FK) │                             │
│ user_id (FK)  │←────────────────────────────┘
│ status        │
│ ...           │
└───────────────┘
```

## Entitas Utama dan Kardinalitas

### 1. Manajemen Pengguna
- **users** (id, name, email, password, role, active...)
- **profiles** (id, user_id, gender, birth_date, address...)
- **alumni_statuses** (id, user_id, status, company_name...)
  - users 1:1 profiles
  - users 1:1 alumni_statuses

### 2. Manajemen Organisasi
- **departments** (id, name, description, coordinator_id...)
- **user_departments** (id, user_id, department_id, role...)
- **groups** (id, name, description, graduation_year...)
- **user_groups** (id, user_id, group_id, role...)
  - users M:N departments (melalui user_departments)
  - users M:N groups (melalui user_groups)

### 3. Program Kerja & Kegiatan
- **program_kerja** (id, department_id, name, description, status...)
- **program_updates** (id, program_kerja_id, user_id, progress...)
- **events** (id, title, description, start_date, location...)
- **event_registrations** (id, event_id, user_id, status...)
  - departments 1:N program_kerja
  - program_kerja 1:N program_updates
  - events 1:N event_registrations
  - users 1:N event_registrations

### 4. Keuangan
- **payments** (id, user_id, payment_year, amount, status...)
- **cash_flows** (id, type, amount, transaction_date, description...)
  - users 1:N payments
  - departments 1:N cash_flows

### 5. Media & Dokumentasi
- **albums** (id, title, description, created_by...)
- **photos** (id, album_id, file_path, caption...)
- **photo_tags** (id, photo_id, user_id, position_x, position_y...)
  - albums 1:N photos
  - photos 1:N photo_tags
  - users 1:N photo_tags

## Tips Pembuatan di Excalidraw

1. Gunakan rectangle untuk entity
2. Tuliskan nama entity di bagian atas
3. List attribute di bawahnya, tandai Primary Key (PK) dan Foreign Key (FK)
4. Hubungkan entities dengan garis, tambahkan kardinalitas (1, N, M)
5. Gunakan notasi crow's foot jika memungkinkan
6. Gunakan warna berbeda untuk kategori entity yang berbeda
