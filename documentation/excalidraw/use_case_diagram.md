# Use Case Diagram untuk IKA SMADA Pangkep

## Aktor dalam Sistem

1. **Admin** - Pengelola utama sistem
2. **Alumni** - Anggota biasa (lulusan SMA Negeri 2 Pangkep)
3. **Koordinator Angkatan** - Alumni yang mengkoordinasi angkatan tertentu
4. **Ketua Departemen** - Pengelola departemen
5. **Bendahara** - Pengelola keuangan
6. **Sekretaris** - Pengelola dokumentasi dan administrasi
7. **Ketua Umum** - Pimpinan organisasi

## Use Case Utama

### Authentication & User Management
- Login
- Register
- Verify Email
- Reset Password
- Manage Profile
- Manage Users
- Approve Registration

### Alumni Management
- Search Alumni
- Update Alumni Status
- Filter Alumni by Year/Profession
- View Alumni Directory

### Organization Management
- Manage Departments
- Assign Coordinators
- Manage Year Groups
- Schedule MUBES
- Conduct MUBES
- Record MUBES Decisions

### Program & Event Management
- Create Program Kerja
- Track Program Progress
- Update Program Status
- Create Event
- Register for Event
- Manage Participants

### Financial Management
- Pay Annual Fee
- Verify Payment
- Manage Cash Flow
- Create Financial Report
- Upload Payment Proof
- View Payment Status

### Documentation & Gallery
- Upload Document
- Create Document Version
- Create Album
- Upload Photos
- Tag Alumni in Photos
- Search Documents

### Communication
- Send Notification
- Create Letter
- Manage Mail Archive
- Send Announcement

## Format Visual Excalidraw

```
┌─────────────────────────────────────────────────────────┐
│            Sistem Informasi IKA SMADA Pangkep           │
│                                                         │
│   ┌─────────┐         ┌─────────────┐                   │
│   │ Login   │◄────────┤   Alumni    │                   │
│   └─────────┘         └─────────────┘                   │
│        ▲                     │                          │
│        │                     │                          │
│        │                     ▼                          │
│   ┌─────────┐         ┌─────────────┐                   │
│   │ Register│◄────────┤Update Profile│                  │
│   └─────────┘         └─────────────┘                   │
│                                                         │
│   ┌─────────────┐     ┌─────────────┐                   │
│   │Manage Users │◄────┤   Admin     │                   │
│   └─────────────┘     └─────────────┘                   │
│                                                         │
│   ┌─────────────┐     ┌─────────────┐                   │
│   │Manage Dept  │◄────┤Ketua Umum   │                   │
│   └─────────────┘     └─────────────┘                   │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

## Tips Pembuatan di Excalidraw

1. Buat boundary system sebagai rectangle besar dengan sudut rounded
2. Letakkan stick figure aktor di luar boundary
3. Buat oval untuk setiap use case di dalam boundary
4. Hubungkan aktor dengan use case menggunakan garis lurus
5. Hubungkan antar use case dengan garis putus-putus dan label (<<include>>, <<extend>>)
6. Gunakan warna berbeda untuk kategori use case yang berbeda
